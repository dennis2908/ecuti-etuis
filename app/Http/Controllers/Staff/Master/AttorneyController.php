<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterAttorney;
use App\MasterModel\MasterState;
use App\MasterModel\MasterDistrict;
use App\OtherModel\Address;
use App\LogModel\LogSystem;
use Validator;

class AttorneyController extends Controller
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

        $states = MasterState::all();
        $districts = MasterDistrict::all();

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 50;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Data Induk - Pejabat Peguam";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $attorney = MasterAttorney::with(['address.district','address.state']);

            return datatables()->of($attorney)
                ->editColumn('address', function ($attorney) {
                    return $attorney->address->address1.
                    ($attorney->address->address2 ? ',<br>'.$attorney->address->address2 : '').
                    ($attorney->address->address3 ? ',<br>'.$attorney->address->address3 : '').
                    ',<br>'.
                    $attorney->address->postcode.' '.
                    ($attorney->address->district ? $attorney->address->district->name : '').', '.
                    ($attorney->address->state ? $attorney->address->state->name : '');
                })
                ->editColumn('created_at', function ($attorney) {
                    return date('d/m/Y h:i A', strtotime($attorney->created_at));
                })
                ->editColumn('action', function ($attorney) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="edit('.$attorney->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="remove('.$attorney->id.')" href="javascript:;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 50;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Data Induk - Pejabat Peguam";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('admin.master.attorney.index', compact('states', 'districts'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address1' => 'required|string',
            'postcode' => 'required|digits:5',
            'state_id' => 'required|integer',
            'district_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create($request->all());
        $request->request->add(['address_id' => $address->id]);
        $attorney = MasterAttorney::create($request->all());

        $log = new LogSystem;
        $log->module_id = 50;
        $log->activity_type_id = 4;
        $log->description = "Tambah Data Induk - Pejabat Peguam";
        $log->data_new = json_encode($attorney);
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
        $log->description = "Popup kemaskini Data Induk - Pejabat Peguam";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attorney = MasterAttorney::findOrFail($request->id);
        $states = MasterState::all();
        $districts = MasterDistrict::all();

        return view('admin.master.attorney.edit', compact('attorney', 'states', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:master_attorney,name,'.$request->id,
            'address1' => 'required|string',
            'postcode' => 'required|digits:5',
            'state_id' => 'required|integer',
            'district_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $attorney = MasterAttorney::findOrFail($request->id);
        $address = Address::findOrFail($attorney->address_id)->update($request->all());

        $log = new LogSystem;
        $log->module_id = 50;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Data Induk - Pejabat Peguam";
        $log->data_old = json_encode($attorney);

        $attorney = $attorney->update($request->all());

        $log->data_new = json_encode($attorney);
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
        $attorney = MasterAttorney::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 50;
        $log->activity_type_id = 6;
        $log->description = "Padam Data Induk - Pejabat Peguam";
        $log->data_old = json_encode($attorney);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attorney->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
}
