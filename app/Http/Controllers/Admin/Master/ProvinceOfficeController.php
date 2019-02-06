<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterProvinceOffice;
use App\MasterModel\MasterState;
use App\MasterModel\MasterDistrict;
use App\OtherModel\Address;
use App\LogModel\LogSystem;
use Validator;

class ProvinceOfficeController extends Controller
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
            $log->description = "Papar senarai Data Induk - Pejabat Wilayah";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $province = MasterProvinceOffice::with(['address.state','address.district']);

            return datatables()->of($province)
                ->editColumn('address', function ($province) {
                    if($province->address)
                        return $province->address->address1.
                        ($province->address->address2 ? ',<br>'.$province->address->address2 : '').
                        ($province->address->address3 ? ',<br>'.$province->address->address3 : '').
                        ',<br>'.
                        $province->address->postcode.' '.
                        ($province->address->district ? $province->address->district->name : '').', '.
                        ($province->address->state ? $province->address->state->name : '');
                    else
                        return '-';
                })
                ->editColumn('created_at', function ($province) {
                    return date('d/m/Y h:i A', strtotime($province->created_at));
                })
                ->editColumn('action', function ($province) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="edit('.$province->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="remove('.$province->id.')" href="javascript:;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 50;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Data Induk - Pejabat Wilayah";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('admin.master.province-office.index', compact('states', 'districts'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:master_province_office',
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
        $province = MasterProvinceOffice::create($request->all());

        $log = new LogSystem;
        $log->module_id = 50;
        $log->activity_type_id = 4;
        $log->description = "Tambah Data Induk - Pejabat Wilayah";
        $log->data_new = json_encode($province);
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
        $log->description = "Popup kemaskini Data Induk - Pejabat Wilayah";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $province = MasterProvinceOffice::findOrFail($request->id);
        $states = MasterState::all();
        $districts = MasterDistrict::all();

        return view('admin.master.province-office.edit', compact('province', 'states', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:master_province_office,name,'.$request->id,
            'address1' => 'required|string',
            'postcode' => 'required|digits:5',
            'state_id' => 'required|integer',
            'district_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $province = MasterProvinceOffice::findOrFail($request->id);
        $address = Address::findOrFail($province->address_id)->update($request->all());

        $log = new LogSystem;
        $log->module_id = 50;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Data Induk - Pejabat Wilayah";
        $log->data_old = json_encode($province);

        $province->update($request->all());

        $log->data_new = json_encode($province);
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
        $province = MasterProvinceOffice::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 50;
        $log->activity_type_id = 6;
        $log->description = "Padam Data Induk - Pejabat Wilayah";
        $log->data_old = json_encode($province);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $province->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
}
