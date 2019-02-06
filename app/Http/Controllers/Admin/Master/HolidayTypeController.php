<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterHolidayType;
use App\LogModel\LogSystem;
use Carbon\Carbon;
use Validator;

class HolidayTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 50;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Data Induk - Jenis Cuti";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $types = MasterHolidayType::all();

            return datatables()->of($types)
                ->editColumn('start_date', function ($type) {
                   return $type->start_date ? date('d/m/Y', strtotime($type->start_date)) : "";
                })
                ->editColumn('day', function($type) {
                    setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
                    return strftime("%A", strtotime($type->start_date));
                })
                ->editColumn('end_date', function ($type) {
					// list tanggal merah selain hari minggu
					
					$date_tgl = date('Y-m-d', strtotime($type->start_date)); 
					
					if($type->start_date && $type->duration)
					{
						for($i=0;$i<$type->duration;$i++){
			
							if ( date("N", strtotime($date_tgl)) == 7 || date("N", strtotime($date_tgl)) == 6)
							   $i--;
						
							$date_tgl = date('Y-m-d', strtotime($date_tgl. ' + 1 days')); 
						}
					 
						// menghitung selisih hari yang bukan tanggal merah dan hari minggu
						return date('d/m/Y', strtotime($date_tgl));
						
					}
					else if($type->start_date && !($type->duration))
					{
					 
						// menghitung selisih hari yang bukan tanggal merah dan hari minggu
						return date('d/m/Y', strtotime($type->start_date));
						
					}
					else
					 return "";		
						
					
                    //return date('d/m/Y', strtotime($type->start_date. ' + '.$type->duration.' days'));
                })
                ->editColumn('action', function ($type) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="edit('.$type->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="remove('.$type->id.')" href="javascript:;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 50;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Data Induk - Jenis Cuti";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('admin.master.holiday-type.index');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:master_holiday_type',
            'duration' => 'required|integer'
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $type = MasterHolidayType::create([
                'name' => $request->name,
                'start_date' => $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString() : null,
                'duration' => $request->duration,
            ]);

        $log = new LogSystem;
        $log->module_id = 50;
        $log->activity_type_id = 4;
        $log->description = "Tambah Data Induk - Jenis Cuti";
        $log->data_new = json_encode($type);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function edit(Request $request)
    {
        $log = new LogSystem;
        $log->module_id = 50;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Data Induk - Jenis Cuti";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $type = MasterHolidayType::findOrFail($request->id);

        return view('admin.master.holiday-type.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:master_holiday_type,name,'.$request->id,
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $type = MasterHolidayType::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 50;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Data Induk - Jenis Cuti";
        $log->data_old = json_encode($type);

        $type->update([
                'name' => $request->name,
                'start_date' => ($request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString() : null),
                'duration' => $request->duration,
            ]);

        $log->data_new = json_encode($type);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Remove the specified resource from storage.
     * @param  Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $type = MasterHolidayType::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 50;
        $log->activity_type_id = 6;
        $log->description = "Padam Data Induk - Jenis Cuti";
        $log->data_old = json_encode($type);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $type->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
}
