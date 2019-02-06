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
