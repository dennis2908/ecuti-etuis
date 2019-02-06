<?php

namespace App\Http\Controllers\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterMeetingType;
use App\LogModel\LogSystem;
use App\FilingModel\Tenure;
use Carbon\Carbon;
use Validator;

class TenureController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['auth','role:ks']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $meeting_types = MasterMeetingType::all();

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 52;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Penggal";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $tenures = auth()->user()->entity->tenures()->with(['meeting_type']);

            return datatables()->of($tenures)
            	->editColumn('tenure', function ($tenure) {
            		return $tenure->start_year."-".$tenure->end_year;
            	})
                ->editColumn('meeting_type.name', function ($tenure) {
                    return $tenure->meeting_type ? $tenure->meeting_type->name : '';
                })
            	->editColumn('meeting_at', function ($tenure) {
            		return $tenure->meeting_at ? date('d/m/Y', strtotime($tenure->meeting_at)) : '';
            	})
                ->editColumn('action', function ($tenure) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="edit('.$tenure->id.')" href="javascript:;" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="remove('.$tenure->id.')" href="javascript:;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 52;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Penggal";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('registration.tenure.index', compact('meeting_types'));
    }

     /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'meeting_type_id' => 'required|integer',
            'meeting_date' => 'required',
            'duration' => 'required|integer',
            'start_year' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['meeting_at' => Carbon::createFromFormat('d/m/Y', $request->meeting_date)->toDateString()]);
        $request->request->add(['end_year' => $request->start_year + $request->duration - 1]);
        $tenure = auth()->user()->entity->tenures()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 52;
        $log->activity_type_id = 4;
        $log->description = "Tambah Penggal";
        $log->data_new = json_encode($tenure);
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
    public function edit(Request $request){
        $meeting_types = MasterMeetingType::all();

        $log = new LogSystem;
        $log->module_id = 52;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Penggal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $tenure = Tenure::findOrFail($request->id);

        return view('registration.tenure.edit', compact('tenure','meeting_types'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request){

    	$tenure = Tenure::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'meeting_type_id' => 'required|integer',
            'meeting_date' => 'required',
            'duration' => 'required|integer',
            'start_year' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['meeting_at' => Carbon::createFromFormat('d/m/Y', $request->meeting_date)->toDateString()]);
        $request->request->add(['end_year' => $request->start_year + $request->duration - 1]);

        $log = new LogSystem;
        $log->module_id = 52;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Penggal";
        $log->data_old = json_encode($tenure);
        
        $tenure->update($request->all());

        $log->data_new = json_encode($tenure);
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
    public function delete(Request $request){

        try {
            $tenure = Tenure::findOrFail($request->id);

            $log = new LogSystem;
            $log->module_id = 52;
            $log->activity_type_id = 6;
            $log->description = "Padam Penggal";
            $log->data_old = json_encode($tenure);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $tenure->delete();

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
        }
        catch(\Exception $e) {
            return response()->json(['status' => 'error', 'title' => 'Ralat!', 'message' => 'Data tidak berjaya dipadam.']);
        }
        
    }
}
