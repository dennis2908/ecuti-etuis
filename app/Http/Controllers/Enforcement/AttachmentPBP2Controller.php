<?php

namespace App\Http\Controllers\Enforcement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FilingModel\Enforcement;
use App\FilingModel\EnforcementPBP2;
use App\FilingModel\EnforcementA1;
use App\FilingModel\EnforcementA2;
use App\FilingModel\EnforcementA3;
use App\FilingModel\EnforcementA4;
use App\FilingModel\EnforcementA5;
use App\FilingModel\EnforcementA6;
use App\FilingModel\EnforcementB1;
use App\FilingModel\EnforcementC1;
use App\FilingModel\EnforcementD1;
use App\FilingModel\EnforcementAllowance;
use App\FilingModel\EnforcementArbitrator;
use App\FilingModel\EnforcementExaminer;
use App\FilingModel\EnforcementIncentive;
use App\FilingModel\EnforcementTrustee;
use App\MasterModel\MasterState;
use App\MasterModel\MasterDesignation;
use App\OtherModel\Address;
use App\FilingModel\Branch;
use App\LogModel\LogSystem;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;


class AttachmentPBP2Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function a1_index(Request $request) {

        $states = MasterState::all();
        $designations = MasterDesignation::all();

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Lampiran A1 - PBP2";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $a1 = EnforcementA1::where('enforcement_id', $request->id)->with('address');

            return datatables()->of($a1)
            ->editColumn('designation.name', function ($a1) {
                return $a1->designation ? $a1->designation->name : '';
            })
            ->editColumn('address', function ($a1) {
                if($a1->address)
                    return $a1->address->address1.
                        ($a1->address->address2 ? ',<br>'.$a1->address->address2 : '').
                        ($a1->address->address3 ? ',<br>'.$a1->address->address3 : '').
                        ',<br>'.
                        $a1->address->postcode.' '.
                        ($a1->address->district ? $a1->address->district->name : '').', '.
                        ($a1->address->state ? $a1->address->state->name : '');
                else
                    return "";
            })
            ->editColumn('action', function ($a1) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="edit('.$a1->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="remove('.$a1->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
        }
        return view('enforcement.pbp2.a1.index', compact('designations','states'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a1_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'designation_id' => 'required|integer',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'office_location' => 'required|string',
            'grade' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create($request->all());
        $a1 = EnforcementA1::create([
            'enforcement_id' => $request->id,
            'designation_id' => $request->designation_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'office_location' => $request->office_location,
            'grade' => $request->grade,
            'address_id' => $address->id,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran A1";
        $log->data_new = json_encode($a1);
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
    public function a1_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran A1";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $a1 = EnforcementA1::findOrFail($request->a1_id);
        $states = MasterState::all();
        $designations = MasterDesignation::all();

        return view('enforcement.pbp2.a1.edit', compact('a1','states','designations'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a1_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'designation_id' => 'required|integer',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'office_location' => 'required|string',
            'grade' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $a1 = EnforcementA1::findOrFail($request->a1_id);
        $address = Address::findOrFail($a1->address_id)->update($request->all());

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran A1";
        $log->data_old = json_encode($a1);

        $a1->update($request->all());

        $log->data_new = json_encode($a1);
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
    public function a1_delete(Request $request) {

        $a1 = EnforcementA1::findOrFail($request->a1_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran A1";
        $log->data_old = json_encode($a1);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $a1->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function a2_index(Request $request) {
        $states = MasterState::all();
        $designations = MasterDesignation::all();

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Lampiran A2 - PBP2";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $a2 = EnforcementA2::where('enforcement_id', $request->id);

            return datatables()->of($a2)
            ->editColumn('designation.name', function ($a2) {
                return $a2->designation ? $a2->designation->name : '';
            })
            ->editColumn('address', function ($a2) {
                if($a2->address)
                    return $a2->address->address1.
                        ($a2->address->address2 ? ',<br>'.$a2->address->address2 : '').
                        ($a2->address->address3 ? ',<br>'.$a2->address->address3 : '').
                        ',<br>'.
                        $a2->address->postcode.' '.
                        ($a2->address->district ? $a2->address->district->name : '').', '.
                        ($a2->address->state ? $a2->address->state->name : '');
                else
                    return "";
            })
            ->editColumn('action', function ($a2) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="edit('.$a2->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="remove('.$a2->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
        }

        return view('enforcement.pbp2.a2.index', compact('states','designations'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a2_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'designation_id' => 'required|integer',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'office_location' => 'required|string',
            'grade' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create($request->all());
        $a2 = EnforcementA2::create([
            'enforcement_id' => $request->id,
            'designation_id' => $request->designation_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'office_location' => $request->office_location,
            'grade' => $request->grade,
            'address_id' => $address->id,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran A2";
        $log->data_new = json_encode($a2);
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
    public function a2_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran A2";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $a2 = EnforcementA2::findOrFail($request->a2_id);
        $states = MasterState::all();
        $designations = MasterDesignation::all();

        return view('enforcement.pbp2.a2.edit', compact('a2','states','designations'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a2_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'designation_id' => 'required|integer',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'office_location' => 'required|string',
            'grade' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $a2 = EnforcementA2::findOrFail($request->a2_id);
        $address = Address::findOrFail($a2->address_id)->update($request->all());
        
        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran A2";
        $log->data_old = json_encode($a2);

        $a2->update($request->all());

        $log->data_new = json_encode($a2);
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
    public function a2_delete(Request $request) {

        $a2 = EnforcementA2::findOrFail($request->a2_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran A2";
        $log->data_old = json_encode($a2);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $a2->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    public function a3_list (Request $request){

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Lampiran A3 - PBP2";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $a3 = EnforcementA3::where('enforcement_id', $request->id)->with('designation');

            return datatables()->of($a3)
            ->editColumn('designation.name', function ($a3){
                return $a3->designation ? $a3->designation->name : '';
            })
            ->editColumn('allowance', function ($a3){
                $allowance_list = '';
                foreach ($a3->allowances as $key => $allowance) {
                    $allowance_list .= $allowance->name.' - RM'.$allowance->value.'<br>';
                }
                return $allowance_list;
            })
            ->editColumn('incentive', function ($a3){
                $incentive_list = '';
                foreach ($a3->incentives as $key => $incentive) {
                    $incentive_list .= $incentive->name.' - RM'.$incentive->value.'<br>';
                }
                return $incentive_list;
            })
            ->editColumn('action', function ($a3) {
                $button = "";
                $button .= '<a href="'.route('pbp2.a3.form', [request()->id,$a3->id]).'" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="remove('.$a3->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
        }
        return view('enforcement.pbp2.a3.list');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a3_index(Request $request) {
        
        $designations = MasterDesignation::all();

        $a3 = EnforcementA3::updateOrCreate([
            'enforcement_id' => $request->id,
        ]);
        return view('enforcement.pbp2.a3.index', compact('designations','a3'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function a3_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran A3";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $designations = MasterDesignation::all();
        $a3 = EnforcementA3::findOrFail($request->a3_id);

        return view('enforcement.pbp2.a3.index', compact('designations','a3'));
    }

    /**
     * Remove the specified resource from storage.
     * @param  Request $request
     * @return Response
     */
    public function a3_delete(Request $request) {

        $a3 = EnforcementA3::findOrFail($request->a3_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran A3";
        $log->data_old = json_encode($a3);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $a3->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function allowance_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Lampiran A3 (Elaun) - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $allowance = EnforcementAllowance::where('filing_type', 'App\FilingModel\EnforcementA3')->where('filing_id', $request->a3_id);

        return datatables()->of($allowance)
        ->editColumn('action', function ($allowance) {
            $button = "";
            // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
            $button .= '<a onclick="editAllowance('.$allowance->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

            $button .= '<a onclick="removeAllowance('.$allowance->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function allowance_insert(Request $request) {
       
        $validator = Validator::make($request->all(), [
            'allowance' => 'required|string',
            'allowance_value' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $enforcement = EnforcementA3::findOrFail($request->a3_id);
        $allowance = $enforcement->allowances()->create([
            'name' => $request->allowance,
            'value' => $request->allowance_value,
        ]);
        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran A3 (Elaun)";
        $log->data_new = json_encode($allowance);
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
    public function allowance_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran A3 (Elaun)";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $allowance = EnforcementAllowance::findOrFail($request->allowance_id);

        return view('enforcement.pbp2.a3.allowance.edit', compact('allowance'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function allowance_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'allowance' => 'required|string',
            'allowance_value' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $allowance = EnforcementAllowance::findOrFail($request->allowance_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran A3 (Elaun)";
        $log->data_old = json_encode($allowance);

        $allowance->update([
            'name' => $request->allowance,
            'value' => $request->allowance_value
        ]);

        $log->data_new = json_encode($allowance);
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
    public function allowance_delete(Request $request) {

        $allowance = EnforcementAllowance::findOrFail($request->allowance_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran A3 (Elaun)";
        $log->data_old = json_encode($allowance);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $allowance->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function incentive_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Lampiran A3 (Insentif) - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $incentive = EnforcementIncentive::where('filing_id', $request->a3_id);

        return datatables()->of($incentive)
        ->editColumn('action', function ($incentive) {
            $button = "";
            // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
            $button .= '<a onclick="editIncentive('.$incentive->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

            $button .= '<a onclick="removeIncentive('.$incentive->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function incentive_insert(Request $request) {
       
        $validator = Validator::make($request->all(), [
            'incentive' => 'required|string',
            'incentive_value' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $enforcement = EnforcementA3::findOrFail($request->a3_id);
        $incentive = $enforcement->incentives()->create([
            'name' => $request->incentive,
            'value' => $request->incentive_value,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran A3 (Insentif)";
        $log->data_new = json_encode($incentive);
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
    public function incentive_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran A3 (Insentif)";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();
        
        $incentive = EnforcementIncentive::findOrFail($request->incentive_id);

        return view('enforcement.pbp2.a3.incentive.edit', compact('incentive'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function incentive_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'incentive' => 'required|string',
            'incentive_value' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $incentive = EnforcementIncentive::findOrFail($request->incentive_id);
        // dd($incentive);
        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran A3 (Insentif)";
        $log->data_old = json_encode($incentive);

        $incentive->update([
            'name' => $request->incentive,
            'value' => $request->incentive_value
        ]);

        $log->data_new = json_encode($incentive);
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
    public function incentive_delete(Request $request) {

        $incentive = EnforcementIncentive::findOrFail($request->incentive_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran A3 (Insentif)";
        $log->data_old = json_encode($incentive);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $incentive->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    public function a4_list (Request $request){

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Lampiran A4 - PBP2";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $a4 = EnforcementA4::where('enforcement_id', $request->id)->with('designation');

            return datatables()->of($a4)
            ->editColumn('designation.name', function ($a4){
                return $a4->designation ? $a4->designation->name : '';
            })
            ->editColumn('appointed_at', function ($a4){
                return $a4->appointed_at ? date('d/m/Y', strtotime($a4->appointed_at)) : '';
            })
            ->editColumn('allowance', function ($a4){
                $allowance_list = '';
                foreach ($a4->allowances as $key => $allowance) {
                    $allowance_list .= $allowance->name.' - RM'.$allowance->value.'<br>';
                }
                return $allowance_list;
            })
            ->editColumn('incentive', function ($a4){
                $incentive_list = '';
                foreach ($a4->incentives as $key => $incentive) {
                    $incentive_list .= $incentive->name.' - RM'.$incentive->value.'<br>';
                }
                return $incentive_list;
            })
            ->editColumn('action', function ($a4) {
                $button = "";
                $button .= '<a href="'.route('pbp2.a4.form', [request()->id,$a4->id]).'" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="remove('.$a4->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
        }
        return view('enforcement.pbp2.a4.list');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a4_index(Request $request) {
        
        $designations = MasterDesignation::all();

        $a4 = EnforcementA4::updateOrCreate([
            'enforcement_id' => $request->id,
        ]);

        return view('enforcement.pbp2.a4.index', compact('designations','a4'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function a4_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran A4";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $designations = MasterDesignation::all();
        $a4 = EnforcementA4::findOrFail($request->a4_id);

        return view('enforcement.pbp2.a4.index', compact('designations','a4'));
    }

    /**
     * Remove the specified resource from storage.
     * @param  Request $request
     * @return Response
     */
    public function a4_delete(Request $request) {

        $a4 = EnforcementA4::findOrFail($request->a4_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran A4";
        $log->data_old = json_encode($a4);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $a4->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function a4_allowance_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Lampiran A4 (Elaun) - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $allowance = EnforcementAllowance::where('filing_type', 'App\FilingModel\EnforcementA4')->where('filing_id', $request->a4_id);

        return datatables()->of($allowance)
        ->editColumn('action', function ($allowance) {
            $button = "";
            // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
            $button .= '<a onclick="editAllowance('.$allowance->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

            $button .= '<a onclick="removeAllowance('.$allowance->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a4_allowance_insert(Request $request) {
       
        $validator = Validator::make($request->all(), [
            'allowance' => 'required|string',
            'allowance_value' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $enforcement = EnforcementA4::findOrFail($request->a4_id);
        $allowance = $enforcement->allowances()->create([
            'name' => $request->allowance,
            'value' => $request->allowance_value,
        ]);
        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran A4 (Elaun)";
        $log->data_new = json_encode($allowance);
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
    public function a4_allowance_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran A4 (Elaun)";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $allowance = EnforcementAllowance::findOrFail($request->allowance_id);

        return view('enforcement.pbp2.a4.allowance.edit', compact('allowance'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a4_allowance_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'allowance' => 'required|string',
            'allowance_value' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $allowance = EnforcementAllowance::findOrFail($request->allowance_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran A4 (Elaun)";
        $log->data_old = json_encode($allowance);

        $allowance->update([
            'name' => $request->allowance,
            'value' => $request->allowance_value
        ]);

        $log->data_new = json_encode($allowance);
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
    public function a4_allowance_delete(Request $request) {

        $allowance = EnforcementAllowance::findOrFail($request->allowance_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran A4 (Elaun)";
        $log->data_old = json_encode($allowance);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $allowance->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function a4_incentive_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Lampiran A4 (Insentif) - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $incentive = EnforcementIncentive::where('filing_type', 'App\FilingModel\EnforcementA4')->where('filing_id', $request->a4_id);

        return datatables()->of($incentive)
        ->editColumn('action', function ($incentive) {
            $button = "";
            // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
            $button .= '<a onclick="editIncentive('.$incentive->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

            $button .= '<a onclick="removeIncentive('.$incentive->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a4_incentive_insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'incentive' => 'required|string',
            'incentive_value' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $enforcement = EnforcementA4::findOrFail($request->a4_id);
        $incentive = $enforcement->incentives()->create([
            'name' => $request->incentive,
            'value' => $request->incentive_value,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran A4 (Insentif)";
        $log->data_new = json_encode($incentive);
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
    public function a4_incentive_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran A4 (Insentif)";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $incentive = EnforcementIncentive::findOrFail($request->incentive_id);

        return view('enforcement.pbp2.a4.incentive.edit', compact('incentive'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a4_incentive_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'incentive' => 'required|string',
            'incentive_value' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $incentive = EnforcementIncentive::findOrFail($request->incentive_id);
        
        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran A4 (Insentif)";
        $log->data_old = json_encode($incentive);

        $incentive->update([
            'name' => $request->incentive,
            'value' => $request->incentive_value
        ]);

        $log->data_new = json_encode($incentive);
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
    public function a4_incentive_delete(Request $request) {

        $incentive = EnforcementIncentive::findOrFail($request->incentive_id);
        dd($incentive);
        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran A4 (Insentif)";
        $log->data_old = json_encode($incentive);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $incentive->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    public function a5_index (Request $request){

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Lampiran A5 - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $enforcement = Enforcement::findOrFail($request->id);

        if($enforcement->a5->count() != $enforcement->entity->branches->count()){

            $branches = Branch::where('user_union_id', $enforcement->entity_id)->get();

            foreach ($branches as $key => $branch) {
                $data[] = EnforcementA5::create(['enforcement_id' => $enforcement->id, 'branch_id' => $branch->id]);
            }
        }
        $a5 = $enforcement->a5()->get();
        // dd($a5);
        return datatables()->of($a5)
        ->editColumn('name', function ($a5) {
            return $a5->branch->name;
        })
        ->editColumn('action', function ($a5) {
            $button = "";

            $button .= '<a id="" href="'.route('pbp2.a5.form', [$a5->enforcement->id, $a5->id] ).'" target="_blank" class="btn btn-primary btn-cons text-capitalize btn-sm"><i class="fa fa-plus m-r-5"></i> Lampiran A5</a>';

            return $button;
        })
        ->make(true);

        
    }

    public function a5_edit (Request $request){

        $a5 = EnforcementA5::findOrFail($request->a5_id);

        return view('enforcement.pbp2.a5', compact('a5'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function a6_index(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Lampiran A6 - PBP2";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $a6 = EnforcementA6::where('enforcement_id', $request->id);

            return datatables()->of($a6)
            ->editColumn('action', function ($a6) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="edit('.$a6->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="remove('.$a6->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
        }
        return view('enforcement.pbp2.a6.index');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a6_insert(Request $request) {
       
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string',
            'duration' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $a6 = EnforcementA6::create([
            'enforcement_id' => $request->id,
            'company_name' => $request->company_name,
            'duration' => $request->duration,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran A6";
        $log->data_new = json_encode($a6);
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
    public function a6_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran A6";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $a6 = EnforcementA6::findOrFail($request->a6_id);

        return view('enforcement.pbp2.a6.edit', compact('a6'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function a6_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string',
            'duration' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $a6 = EnforcementA6::findOrFail($request->a6_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran A6";
        $log->data_old = json_encode($a6);

        $a6->update($request->all());

        $log->data_new = json_encode($a6);
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
    public function a6_delete(Request $request) {

        $a6 = EnforcementA6::findOrFail($request->a6_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran A6";
        $log->data_old = json_encode($a6);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $a6->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function b1_index(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Lampiran B1 - PBP2";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $b1 = EnforcementB1::where('enforcement_id', $request->id);

            return datatables()->of($b1)
            ->editColumn('action', function ($b1) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="edit('.$b1->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="remove('.$b1->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
        }
        return view('enforcement.pbp2.b1.index');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function b1_insert(Request $request) {
       
        $validator = Validator::make($request->all(), [
            'asset_type' => 'required|string',
            'year_obtained' => 'required',
            'current_value' => 'required',
            'location' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $b1 = EnforcementB1::create([
            'enforcement_id' => $request->id,
            'asset_type' => $request->asset_type,
            'year_obtained' =>  Carbon::createFromFormat('Y', $request->year_obtained)->toDateString(),
            'current_value' => $request->current_value,
            'location' => $request->location,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran B1";
        $log->data_new = json_encode($b1);
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
    public function b1_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran B1";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $b1 = EnforcementB1::findOrFail($request->b1_id);

        return view('enforcement.pbp2.b1.edit', compact('b1'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function b1_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'asset_type' => 'required|string',
            'year_obtained' => 'required',
            'current_value' => 'required',
            'location' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $b1 = EnforcementB1::findOrFail($request->b1_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran B1";
        $log->data_old = json_encode($b1);

        $request->request->add(['year_obtained' => Carbon::createFromFormat('Y', $request->year_obtained)->toDateString()]);
        $b1->update($request->all());

        $log->data_new = json_encode($b1);
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
    public function b1_delete(Request $request) {

        $b1 = EnforcementB1::findOrFail($request->b1_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran B1";
        $log->data_old = json_encode($b1);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $b1->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    public function c1_index (Request $request){

        $c1 = EnforcementC1::updateOrCreate([
            'enforcement_id' => $request->id,
        ]);

        return view('enforcement.pbp2.c1', compact('c1'));
    }

    public function d1_index (Request $request){

        $d1 = EnforcementD1::updateOrCreate([
            'enforcement_id' => $request->id,
        ]);

        return view('enforcement.pbp2.d1.index', compact('d1'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function examiner_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Lampiran D1 (Pemeriksa Undi) - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $examiner = EnforcementExaminer::where('enforcement_id', $request->id);

        return datatables()->of($examiner)
        ->editColumn('appointed_at', function ($examiner) {
            return $examiner->appointed_at ? date('d/m/Y',strtotime($examiner->appointed_at)) : '';
        })
        ->editColumn('action', function ($examiner) {
            $button = "";
            // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
            $button .= '<a onclick="editExaminer('.$examiner->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

            $button .= '<a onclick="removeExaminer('.$examiner->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function examiner_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'identification_no' => 'required|string',
            'appointed_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $examiner = EnforcementExaminer::create([
            'enforcement_id' => $request->id,
            'name' => $request->name,
            'identification_no' => $request->identification_no,
            'appointed_at' => Carbon::createFromFormat('d/m/Y', $request->appointed_date)->toDateString(),
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran D1 (Pemeriksa Undi)";
        $log->data_new = json_encode($examiner);
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
    public function examiner_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran D1 (Pemeriksa Undi)";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $examiner = EnforcementExaminer::findOrFail($request->examiner_id);

        return view('enforcement.pbp2.d1.tab1.edit', compact('examiner'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function examiner_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'identification_no' => 'required|string',
            'appointed_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['appointed_at' => Carbon::createFromFormat('d/m/Y', $request->appointed_date)->toDateString()]);
        $examiner = EnforcementExaminer::findOrFail($request->examiner_id);
        
        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran D1 (Pemeriksa Undi)";
        $log->data_old = json_encode($examiner);

        $examiner->update($request->all());

        $log->data_new = json_encode($examiner);
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
    public function examiner_delete(Request $request) {

        $examiner = EnforcementExaminer::findOrFail($request->examiner_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran D1 (Pemeriksa Undi)";
        $log->data_old = json_encode($examiner);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $examiner->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function trustee_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Lampiran D1 (Pemegang Amanah) - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $trustee = EnforcementTrustee::where('enforcement_id', $request->id);

        return datatables()->of($trustee)
        ->editColumn('appointed_at', function ($trustee) {
            return $trustee->appointed_at ? date('d/m/Y',strtotime($trustee->appointed_at)) : '';
        })
        ->editColumn('date_of_birth', function ($trustee) {
            return $trustee->date_of_birth ? date('d/m/Y',strtotime($trustee->date_of_birth)) : '';
        })
        ->editColumn('action', function ($trustee) {
            $button = "";
            // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
            $button .= '<a onclick="editTrustee('.$trustee->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

            $button .= '<a onclick="removeTrustee('.$trustee->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function trustee_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'identification_no' => 'required|string',
            'appointed_date' => 'required',
            'birth_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $trustee = EnforcementTrustee::create([
            'enforcement_id' => $request->id,
            'name' => $request->name,
            'identification_no' => $request->identification_no,
            'appointed_at' => Carbon::createFromFormat('d/m/Y', $request->appointed_date)->toDateString(),
            'date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->birth_date)->toDateString(),
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran D1 (Pemegang Amanah)";
        $log->data_new = json_encode($trustee);
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
    public function trustee_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran D1 (Pemegang Amanah)";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $trustee = EnforcementTrustee::findOrFail($request->trustee_id);

        return view('enforcement.pbp2.d1.tab2.edit', compact('trustee'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function trustee_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'identification_no' => 'required|string',
            'appointed_date' => 'required',
            'birth_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['appointed_at' => Carbon::createFromFormat('d/m/Y', $request->appointed_date)->toDateString()]);
        $request->request->add(['date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->birth_date)->toDateString()]);
        $trustee = EnforcementTrustee::findOrFail($request->trustee_id);
        
        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran D1 (Pemegang Amanah)";
        $log->data_old = json_encode($trustee);

        $trustee->update($request->all());

        $log->data_new = json_encode($trustee);
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
    public function trustee_delete(Request $request) {

        $trustee = EnforcementTrustee::findOrFail($request->trustee_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran D1 (Pemegang Amanah)";
        $log->data_old = json_encode($trustee);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $trustee->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function arbitrator_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Lampiran D1 (Jemaah Penimbangtara) - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $arbitrator = EnforcementArbitrator::where('enforcement_id', $request->id);

        return datatables()->of($arbitrator)
        ->editColumn('appointed_at', function ($arbitrator) {
            return $arbitrator->appointed_at ? date('d/m/Y',strtotime($arbitrator->appointed_at)) : '';
        })
        ->editColumn('action', function ($arbitrator) {
            $button = "";
            // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
            $button .= '<a onclick="editArbitrator('.$arbitrator->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

            $button .= '<a onclick="removeArbitrator('.$arbitrator->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function arbitrator_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'identification_no' => 'required|string',
            'appointed_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $arbitrator = EnforcementArbitrator::create([
            'enforcement_id' => $request->id,
            'name' => $request->name,
            'identification_no' => $request->identification_no,
            'appointed_at' => Carbon::createFromFormat('d/m/Y', $request->appointed_date)->toDateString(),
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Lampiran D1 (Jemaah Penimbangtara)";
        $log->data_new = json_encode($arbitrator);
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
    public function arbitrator_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Lampiran D1 (Jemaah Penimbangtara)";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $arbitrator = EnforcementArbitrator::findOrFail($request->arbitrator_id);

        return view('enforcement.pbp2.d1.tab3.edit', compact('arbitrator'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function arbitrator_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'identification_no' => 'required|string',
            'appointed_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['appointed_at' => Carbon::createFromFormat('d/m/Y', $request->appointed_date)->toDateString()]);
        $arbitrator = EnforcementArbitrator::findOrFail($request->arbitrator_id);
        
        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Lampiran D1 (Jemaah Penimbangtara)";
        $log->data_old = json_encode($arbitrator);

        $arbitrator->update($request->all());

        $log->data_new = json_encode($arbitrator);
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
    public function arbitrator_delete(Request $request) {

        $arbitrator = EnforcementArbitrator::findOrFail($request->arbitrator_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Lampiran D1 (Jemaah Penimbangtara)";
        $log->data_old = json_encode($arbitrator);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $arbitrator->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
    
}
