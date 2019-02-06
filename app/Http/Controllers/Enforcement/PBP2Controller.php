<?php

namespace App\Http\Controllers\Enforcement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\Mail\Filing\Queried;
use App\FilingModel\Enforcement;
use App\FilingModel\EnforcementPBP2;
use App\FilingModel\EnforcementExternalConsultant;
use App\FilingModel\EnforcementInternalConsultant;
use App\FilingModel\EnforcementAccount;
use App\FilingModel\EnforcementAuditor;
use App\FilingModel\EnforcementExaminer;
use App\FilingModel\EnforcementArbitrator;
use App\FilingModel\EnforcementTrustee;
use App\FilingModel\EnforcementFixedDepositAccount;
use App\FilingModel\EnforcementRecord;
use App\FilingModel\EnforcementNotice;
use App\FilingModel\EnforcementMeeting;
use App\MasterModel\MasterProvinceOffice;
use App\MasterModel\MasterAddressType;
use App\MasterModel\MasterState;
use App\MasterModel\MasterMeetingType;
use App\OtherModel\Address;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\Query;
use App\UserFederation;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;


class PBP2Controller extends Controller
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
    public function index(Request $request){

        $enforcement = Enforcement::findOrFail($request->id);
        if($enforcement->pbp2)
            $pbp2 = EnforcementPBP2::where('enforcement_id', $request->id)->firstOrFail();
        else{
            $address = Address::create([]);

            $pbp2 = EnforcementPBP2::create([
                'latest_address_id' => $address->id,
                'enforcement_id' => $enforcement->id,
                'created_by_user_id' => auth()->id(),
            ]);
        }
        $province_offices = MasterProvinceOffice::all();
        $address_types = MasterAddressType::all();
        $states = MasterState::all();
        $meeting_types = MasterMeetingType::whereIn('id',[2,3,6])->get();
        $federations = UserFederation::all();

        return view('enforcement.pbp2.index', compact('enforcement','province_offices','address_types','states','meeting_types','federations'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function internal_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Badan Perunding Dalam Negeri - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $internals = EnforcementInternalConsultant::where('enforcement_id', $request->id);

        return datatables()->of($internals)
            ->editColumn('action', function ($internal) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="editInternal('.$internal->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="removeInternal('.$internal->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function internal_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'consultant' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $internal = EnforcementInternalConsultant::create([
            'enforcement_id' => $request->id,
            'consultant' => $request->consultant,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Badan Perunding Dalam Negeri";
        $log->data_new = json_encode($internal);
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
    public function internal_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Badan Perunding Dalam Negeri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $internal = EnforcementInternalConsultant::findOrFail($request->internal_id);

        return view('enforcement.pbp2.internal-consultant.edit', compact('internal'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function internal_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'consultant' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $internal = EnforcementInternalConsultant::findOrFail($request->internal_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Badan Perunding Dalam Negeri";
        $log->data_old = json_encode($internal);

        $internal->update($request->all());

        $log->data_new = json_encode($internal);
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
    public function internal_delete(Request $request) {

        $internal = EnforcementInternalConsultant::findOrFail($request->internal_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Badan Perunding Dalam Negeri";
        $log->data_old = json_encode($internal);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $internal->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //**
    // * Show the application dashboard.
    // *
    // * @return \Illuminate\Http\Response
    // */
    public function external_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Badan Perunding Luar Negeri - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $externals = EnforcementExternalConsultant::where('enforcement_id', $request->id);

        return datatables()->of($externals)
            ->editColumn('action', function ($external) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="editExternal('.$external->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="removeExternal('.$external->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function external_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'consultant' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $external = EnforcementExternalConsultant::create([
            'enforcement_id' => $request->id,
            'consultant' => $request->consultant,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Badan Perunding Luar Negeri";
        $log->data_new = json_encode($external);
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
    public function external_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Badan Perunding Luar Negeri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $external = EnforcementExternalConsultant::findOrFail($request->external_id);

        return view('enforcement.pbp2.external-consultant.edit', compact('external'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function external_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'consultant' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $external = EnforcementExternalConsultant::findOrFail($request->external_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Badan Perunding Luar Negeri";
        $log->data_old = json_encode($external);

        $external->update($request->all());

        $log->data_new = json_encode($external);
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
    public function external_delete(Request $request) {

        $external = EnforcementExternalConsultant::findOrFail($request->external_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Badan Perunding Luar Negeri";
        $log->data_old = json_encode($external);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $external->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //**
    // * Show the application dashboard.
    // *
    // * @return \Illuminate\Http\Response
    // */
    public function account_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Akaun Semasa/Simpanan - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $accounts = EnforcementAccount::where('enforcement_id', $request->id);

        return datatables()->of($accounts)
            ->editColumn('account_type', function ($account) {
                 return $account->account_type_id == 1 ? 'Akaun Simpanan' : 'Akaun Semasa';
            })
            ->editColumn('action', function ($account) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="editAccount('.$account->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="removeAccount('.$account->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function account_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'account_type_id' => 'required|integer',
            'account_no' => 'required|string',
            'bank_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account = EnforcementAccount::create([
            'enforcement_id' => $request->id,
            'account_type_id' => $request->account_type_id,
            'account_no' => $request->account_no,
            'bank_name' => $request->bank_name,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Akaun Semasa/Simpanan";
        $log->data_new = json_encode($account);
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
    public function account_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Akaun Semasa/Simpanan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $account= EnforcementAccount::findOrFail($request->account_id);

        return view('enforcement.pbp2.account.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function account_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_type_id' => 'required|integer',
            'account_no' => 'required|string',
            'bank_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account = EnforcementAccount::findOrFail($request->account_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Akaun Semasa/Simpanan";
        $log->data_old = json_encode($account);

        $account->update($request->all());

        $log->data_new = json_encode($account);
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
    public function account_delete(Request $request) {

        $account = EnforcementAccount::findOrFail($request->account_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Akaun Semasa/Simpanan";
        $log->data_old = json_encode($account);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $account->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //**
    // * Show the application dashboard.
    // *
    // * @return \Illuminate\Http\Response
    // */
    public function auditor_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Juruaudit - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $auditors = EnforcementAuditor::where('enforcement_id', $request->id);

        return datatables()->of($auditors)
            ->editColumn('action', function ($auditor) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="editAuditor('.$auditor->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="removeAuditor('.$auditor->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function auditor_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'designation' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $auditor = EnforcementAuditor::create([
            'enforcement_id' => $request->id,
            'name' => $request->name,
            'designation' => $request->designation,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Juruaudit";
        $log->data_new = json_encode($auditor);
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
    public function auditor_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Juruaudit";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $auditor= EnforcementAuditor::findOrFail($request->auditor_id);

        return view('enforcement.pbp2.auditor.edit', compact('auditor'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function auditor_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'designation' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $auditor = EnforcementAuditor::findOrFail($request->auditor_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Juruaudit";
        $log->data_old = json_encode($auditor);

        $auditor->update($request->all());

        $log->data_new = json_encode($auditor);
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
    public function auditor_delete(Request $request) {

        $auditor = EnforcementAuditor::findOrFail($request->auditor_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Juruaudit";
        $log->data_old = json_encode($auditor);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $auditor->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //**
    // * Show the application dashboard.
    // *
    // * @return \Illuminate\Http\Response
    // */
    public function fd_account_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Akaun Simpanan Tetap - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fdaccounts = EnforcementFixedDepositAccount::where('enforcement_id', $request->id);

        return datatables()->of($fdaccounts)
            ->editColumn('matured_at', function ($fdaccount) {
                return date('d/m/Y', strtotime($fdaccount->matured_at));
            })
            ->editColumn('action', function ($fdaccount) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="editFDAccount('.$fdaccount->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="removeFDAccount('.$fdaccount->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function fd_account_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string',
            'certificate_no' => 'required|string',
            'matured_date' => 'required',
            'total' => 'required'
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $fdaccount = EnforcementFixedDepositAccount::create([
            'enforcement_id' => $request->id,
            'bank_name' => $request->bank_name,
            'certificate_no' => $request->certificate_no,
            'matured_at' => Carbon::createFromFormat('d/m/Y', $request->matured_date)->toDateString(),
            'total' => $request->total
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Akaun Simpanan Tetap";
        $log->data_new = json_encode($fdaccount);
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
    public function fd_account_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Akaun Simpanan Tetap";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fdaccount= EnforcementFixedDepositAccount::findOrFail($request->fdaccount_id);

        return view('enforcement.pbp2.fixed-deposit-account.edit', compact('fdaccount'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function fd_account_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string',
            'certificate_no' => 'required|string',
            'matured_date' => 'required',
            'total' => 'required'
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $request->request->add(['matured_at' => Carbon::createFromFormat('d/m/Y', $request->matured_date)->toDateString()]);
        $fdaccount = EnforcementFixedDepositAccount::findOrFail($request->fdaccount_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Akaun Simpanan Tetap";
        $log->data_old = json_encode($fdaccount);

        $fdaccount->update($request->all());

        $log->data_new = json_encode($fdaccount);
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
    public function fd_account_delete(Request $request) {

        $fdaccount = EnforcementFixedDepositAccount::findOrFail($request->fdaccount_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Akaun Simpanan Tetap";
        $log->data_old = json_encode($fdaccount);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fdaccount->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //**
    // * Show the application dashboard.
    // *
    // * @return \Illuminate\Http\Response
    // */
    public function meeting_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Mesyuarat Sebelum - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $meetings = EnforcementMeeting::where('enforcement_id', $request->id);

        return datatables()->of($meetings)
            ->editColumn('meeting_at', function ($meeting) {
                return date('d/m/Y', strtotime($meeting->meeting_at));
            })
            ->editColumn('action', function ($meeting) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="editMeeting('.$meeting->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="removeMeeting('.$meeting->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function meeting_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'total_meeting' => 'required|string',
            'meeting_date' => 'required'
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $meeting = EnforcementMeeting::create([
            'enforcement_id' => $request->id,
            'total_meeting' => $request->total_meeting,
            'meeting_at' => Carbon::createFromFormat('d/m/Y', $request->meeting_date)->toDateString(),
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Mesyuarat Sebelum";
        $log->data_new = json_encode($meeting);
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
    public function meeting_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Mesyuarat Sebelum";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $meeting= EnforcementMeeting::findOrFail($request->meeting_id);

        return view('enforcement.pbp2.meeting.edit', compact('meeting'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function meeting_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'total_meeting' => 'required|string',
            'meeting_date' => 'required'
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $request->request->add(['meeting_at' => Carbon::createFromFormat('d/m/Y', $request->meeting_date)->toDateString()]);
        $meeting = EnforcementMeeting::findOrFail($request->meeting_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Mesyuarat Sebelum";
        $log->data_old = json_encode($meeting);

        $meeting->update($request->all());

        $log->data_new = json_encode($meeting);
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
    public function meeting_delete(Request $request) {

        $meeting = EnforcementMeeting::findOrFail($request->meeting_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Mesyuarat Sebelum";
        $log->data_old = json_encode($meeting);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $meeting->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //**
    // * Show the application dashboard.
    // *
    // * @return \Illuminate\Http\Response
    // */
    public function notice_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Notis Pegawai - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $notices = EnforcementNotice::where('enforcement_id', $request->id);

        return datatables()->of($notices)
            ->editColumn('action', function ($notice) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="editNotice('.$notice->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="removeNotice('.$notice->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function notice_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'notice' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $notice = EnforcementNotice::create([
            'enforcement_id' => $request->id,
            'notice' => $request->notice,
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Notis Pegawai";
        $log->data_new = json_encode($notice);
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
    public function notice_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Notis Pegawai";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $notice= EnforcementNotice::findOrFail($request->notice_id);

        return view('enforcement.pbp2.notice.edit', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function notice_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'notice' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $notice = EnforcementNotice::findOrFail($request->notice_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Notis Pegawai";
        $log->data_old = json_encode($notice);

        $notice->update($request->all());

        $log->data_new = json_encode($notice);
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
    public function notice_delete(Request $request) {

        $notice = EnforcementNotice::findOrFail($request->notice_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Notis Pegawai";
        $log->data_old = json_encode($notice);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $notice->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

        //**
    // * Show the application dashboard.
    // *
    // * @return \Illuminate\Http\Response
    // */
    public function record_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Rekod Pemeriksaan - PBP2";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $records = EnforcementRecord::where('enforcement_id', $request->id);

        return datatables()->of($records)
            ->editColumn('inspection_at', function ($record) {
                return date('d/m/Y', strtotime($record->inspection_at));
            })
            ->editColumn('action', function ($record) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="editRecord('.$record->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                $button .= '<a onclick="removeRecord('.$record->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function record_insert(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'duration' => 'required|string',
            'inspection_date' => 'required'
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $record = EnforcementRecord::create([
            'enforcement_id' => $request->id,
            'duration' => $request->duration,
            'inspection_at' => Carbon::createFromFormat('d/m/Y', $request->inspection_date)->toDateString(),
        ]);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah PBP2 - Butiran Rekod Pemeriksaan";
        $log->data_new = json_encode($record);
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
    public function record_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini PBP2 - Butiran Rekod Pemeriksaan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $record= EnforcementRecord::findOrFail($request->record_id);

        return view('enforcement.pbp2.record.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function record_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'duration' => 'required|string',
            'inspection_date' => 'required'
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $request->request->add(['inspection_at' => Carbon::createFromFormat('d/m/Y', $request->inspection_date)->toDateString()]);
        $record = EnforcementRecord::findOrFail($request->record_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini PBP2 - Butiran Rekod Pemeriksaan";
        $log->data_old = json_encode($record);

        $record->update($request->all());

        $log->data_new = json_encode($record);
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
    public function record_delete(Request $request) {

        $record = EnforcementRecord::findOrFail($request->record_id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam PBP2 - Butiran Rekod Pemeriksaan";
        $log->data_old = json_encode($record);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $record->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    public function download(Request $request) {

        $filing = EnforcementPBP2::where('enforcement_id', $request->id)->firstOrFail();
        $total_male = $filing->registered_male + $filing->union_male + $filing->rightful_male + $filing->foreign_male;
        $total_female = $filing->registered_female + $filing->union_female + $filing->rightful_female + $filing->foreign_female;
        $total_all = $total_male+$total_female;
                                                              // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'union_type' => $filing->enforcement->branch ? htmlspecialchars('Cawangan') : $filing->enforcement->entity->formb->has_branch == 1  ? htmlspecialchars('Induk') : htmlspecialchars('Tanpa Cawangan'),
            'province_office_name' => $filing->province_office ? htmlspecialchars($filing->province_office->name) : '',
            'investigation_date' => htmlspecialchars(date('d/m/Y H:i:s', strtotime($filing->investigation_date))),
            'old_investigation_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->old_investigation_date))),
            'location' => htmlspecialchars($filing->location),
            'is_purpose1' => $filing->is_administration_record == 1 ? htmlspecialchars('/') : '',
            'is_purpose2' => $filing->is_finance_record == 1 ? htmlspecialchars('/') : '',
            'is_purpose3' => $filing->is_complaint_investigation == 1 ? htmlspecialchars('/') : '',
            'complaint_reference_no' => $filing->is_complaint_investigation == 1 ? htmlspecialchars($filing->complaint_reference_no) : '',
            'entity_name' => htmlspecialchars($filing->enforcement->entity->name),
            'phone' => htmlspecialchars($filing->enforcement->entity->user->phone),
            'fax' => htmlspecialchars($filing->fax),
            'email' => htmlspecialchars($filing->enforcement->entity->user->email),
            'website' => htmlspecialchars($filing->website),
            'address' => $filing->latest_address ? 
                htmlspecialchars($filing->latest_address->address1).
                ($filing->latest_address->address2 ? ', '.htmlspecialchars($filing->latest_address->address2) : '').
                ($filing->latest_address->address3 ? ', '.htmlspecialchars($filing->latest_address->address3) : '').
                ', '.($filing->latest_address->postcode).
                ($filing->latest_address->district ? ' '.htmlspecialchars($filing->latest_address->district->name) : '').
                ($filing->latest_address->state ? ', '.htmlspecialchars($filing->latest_address->state->name) : '') :
                htmlspecialchars($filing->enforcement->entity->addresses->last()->address->address1).
                ($filing->enforcement->entity->addresses->last()->address->address2 ? ', '.htmlspecialchars($filing->enforcement->entity->addresses->last()->address->address2) : '').
                ($filing->enforcement->entity->addresses->last()->address->address3 ? ', '.htmlspecialchars($filing->enforcement->entity->addresses->last()->address->address3) : '').
                ', '.($filing->enforcement->entity->addresses->last()->address->postcode).
                ($filing->enforcement->entity->addresses->last()->address->district ? ' '.htmlspecialchars($filing->enforcement->entity->addresses->last()->address->district->name) : '').
                ($filing->enforcement->entity->addresses->last()->address->state ? ', '.htmlspecialchars($filing->enforcement->entity->addresses->last()->address->state->name) : ''),
            'is_loc1' => $filing->address_type ? ($filing->address_type_id == 1 ? htmlspecialchars('/') : '') : '',
            'is_loc2' => $filing->address_type ? ($filing->address_type_id == 2 ? htmlspecialchars('/') : '') : '',
            'is_loc3' => $filing->address_type ? ($filing->address_type_id == 3 ? htmlspecialchars('/') : '') : '',
            'is_a1' => $filing->enforcement->a1 ? htmlspecialchars('/') : '',
            'is_a2' => $filing->enforcement->a2 ? htmlspecialchars('/') : '',
            'is_a3' => $filing->enforcement->a3 ? htmlspecialchars('/') : '',
            'is_a4' => $filing->enforcement->a4 ? htmlspecialchars('/') : '',
            'dashboard' => htmlspecialchars($filing->dashboard),
            'is_2.1a' => $filing->is_fee_registration == 1 ? htmlspecialchars('/') : '',
            'is_2.1b' => $filing->kpks_approved_at ? htmlspecialchars('/') : '',            
            'kpks_approved_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->kpks_approved_at))),
            'is_2.1c' => $filing->fee_details ? htmlspecialchars('/') : '',
            'fee_details' => htmlspecialchars($filing->fee_details),            
            'is_221a' => $filing->justification_nonformat ? htmlspecialchars('/') : '',
            'justification_nonformat' => htmlspecialchars($filing->justification_nonformat),
            'is_221b' => $filing->is_exampted ? htmlspecialchars('/') : '',
            'is_221c' => $filing->is_accepted ? htmlspecialchars('/') : '',
            'is_221d' => $filing->cash_book_updated_at ? htmlspecialchars('/') : '',
            'cash_book_update_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->cash_book_updated_at))),
            'is_221e' => $filing->is_account_balanced_monthly == 1 ? htmlspecialchars('/') : '',
            'is_221f' => $filing->justification_exceed_limit ? htmlspecialchars('/') : '',
            'justification_exceed_limit' => htmlspecialchars($filing->justification_exceed_limit),
            'is_221g' => $filing->cash_limit ? htmlspecialchars('/') : '',
            'cash_limit' => htmlspecialchars($filing->cash_limit),
            'is_221h' => $filing->balance_at ? htmlspecialchars('/') : '',
            'balance_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->balance_at))),
            'is_fund' => $filing->saving_cash || $filing->saving_bank || $filing->saving_at_hand ? htmlspecialchars('/') : '',
            'is_mon1' => $filing->is_monthly_maintained == 1 ? htmlspecialchars('/') : '',
            'is_mon2' => $filing->is_monthly_maintained == 2 ? htmlspecialchars('/') : '',
            'saving_cash' => htmlspecialchars($filing->saving_cash),
            'saving_bank' => htmlspecialchars($filing->saving_bank),
            'saving_at_hand' => htmlspecialchars($filing->saving_at_hand),
            'is_t223' => $filing->total_book_saved ? htmlspecialchars('/') : '',
            'saved' => htmlspecialchars($filing->total_book_saved),
            'num_saved' => htmlspecialchars($filing->num_book_saved),
            'series_saved' => htmlspecialchars($filing->series_book_saved),
            'used' => htmlspecialchars($filing->total_book_used),
            'num_used' => htmlspecialchars($filing->num_book_used),
            'series_used' => htmlspecialchars($filing->series_book_used),
            'unused' => htmlspecialchars($filing->total_book_unused),
            'num_unused' => htmlspecialchars($filing->num_book_unused),
            'series_unused' => htmlspecialchars($filing->series_book_unused),
            'is_223a' => $filing->is_stock_maintained == 1 ? htmlspecialchars('/') : '',
            'is_223b' => $filing->is_cash_updated == 1 ? htmlspecialchars('/') : '',
            'is_224a' => $filing->is_receipt_printed == 1 ? htmlspecialchars('/') : '',
            'is_224b' => $filing->is_receipt_issued == 1 ? htmlspecialchars('/') : '',
            'is_224c' => $filing->is_receipt_given == 1 ? htmlspecialchars('/') : '',
            'is_224d' => $filing->is_receipt_duplicated == 1 ? htmlspecialchars('/') : '',
            'is_224e' => $filing->receipt_no ? htmlspecialchars('/') : '',
            'receipt_no' => htmlspecialchars($filing->receipt_no),
            'receipt_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->receipt_at))),
            'receipt_purpose' => htmlspecialchars($filing->receipt_purpose),
            'total_receipt' => htmlspecialchars($filing->total_receipt),
            'is_224f' => $filing->is_receipt_verified == 1 ? htmlspecialchars('/') : '',
            'is_225a' => $filing->is_jounal_maintained == 1 ? htmlspecialchars('/') : '',
            'is_225b' => $filing->is_jurnal_updated == 1 ? htmlspecialchars('/') : '',
            'is_226a' => $filing->is_ledger_maintained == 1 ? htmlspecialchars('/') : '',
            'is_226b' => $filing->is_payment_recorded == 1 ? htmlspecialchars('/') : '',
            'is_226c' => $filing->is_ledger_recorded == 1 ? htmlspecialchars('/') : '',
            'is_226d' => $filing->is_ledger_updated == 1 ? htmlspecialchars('/') : '', 
            'is_227a' => $filing->is_voucher_mainained == 1 ? htmlspecialchars('/') : '',
            'is_227b' => $filing->is_voucher_issued == 1 ? htmlspecialchars('/') : '',
            'is_227c' => $filing->is_voucher_signed == 1 ? htmlspecialchars('/') : '',
            'is_227d' => $filing->is_voucher_attached == 1 ? htmlspecialchars('/') : '',
            'is_227e' => $filing->is_voucher_arranged == 1 ? htmlspecialchars('/') : '',
            'is_227f' => $filing->voucher_no ? htmlspecialchars('/') : '',
            'voucher_no' => htmlspecialchars($filing->voucher_no),
            'voucher_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->voucher_at))),
            'voucher_purpose' => htmlspecialchars($filing->voucher_purpose),
            'total_voucher' => htmlspecialchars($filing->total_voucher),
            'is_228a' => $filing->is_asset_registered == 1 ? htmlspecialchars('/') : '',
            'is_228b' => $filing->justification_unregistered ? htmlspecialchars('/') : '',
            'justification_unregistered' => htmlspecialchars($filing->justification_unregistered),
            'is_b1' => $filing->enforcement->b1 ? htmlspecialchars('/') : '',
            'asset_purchased_notes' => htmlspecialchars($filing->asset_purchased_notes),
            'is_228d' => $filing->depreciation_approved_notes ? htmlspecialchars('/') : '',
            'depreciation_approved_notes' => htmlspecialchars($filing->depreciation_approved_notes),
            'is_228e' => $filing->is_copy_saved == 1 ? htmlspecialchars('/') : '',
            'meeting_budget_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'is_31a' => $filing->meeting_type ? htmlspecialchars('/') : '',
            'is_c1' => $filing->enforcement->c1 ? htmlspecialchars('/') : '',
            'statement_start_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->statement_start_at))),
            'statement_end_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->statement_end_at))),
            'is_33a' => $filing->enforcement->auditors ? htmlspecialchars('/') : '',
            'is_33b' => $filing->audited_at ? htmlspecialchars('/') : '',
            'audited_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->audited_at))),
            'is_rec' => $filing->enforcement->records ? htmlspecialchars('/') : '',
            'is_acc' => $filing->enforcement->accounts ? htmlspecialchars('/') : '', 
            'is_fd_acc' => $filing->enforcement->fd_accounts ? htmlspecialchars('/') : '',
            'is_35a' => $filing->latest_formn_year ? htmlspecialchars('/') : '',
            'latest_formn_year' => htmlspecialchars(date('d/m/Y', strtotime($filing->latest_formn_year))),
            'is_35b' => $filing->missed_formn_year ? htmlspecialchars('/') : '',
            'missed_formn_year' =>  htmlspecialchars(date('d/m/Y', strtotime($filing->missed_formn_year))),
            'is_35c' => $filing->missed_formn_year ? htmlspecialchars('/') : '',
            'justification_notsubmit' =>  htmlspecialchars(date('d/m/Y', strtotime($filing->justification_notsubmit))),
            'is_35d' => $filing->non_external_auditor ? htmlspecialchars('/') : '',
            'non_external_auditor' => htmlspecialchars($filing->non_external_auditor),
            'is_41a' =>  $filing->meeting_duration ? htmlspecialchars('/') : '',
            'dur1' => $filing->meeting_duration_id == 1 ? htmlspecialchars('/') : '',
            'dur2' => $filing->meeting_duration_id == 2 ? htmlspecialchars('/') : '',
            'dur3' => $filing->meeting_duration_id == 3 ? htmlspecialchars('/') : '',
            'is_41b' => $filing->is_agenda_meeting == 1 ? htmlspecialchars('/') : '',
            'is_41c' => $filing->is_enough_corum == 1 ? htmlspecialchars('/') : '',
            'is_41d' => $filing->is_minutes_prepared == 1 ? htmlspecialchars('/') : '',
            'is_41e' => $filing->is_ammendment_approved == 1 ? htmlspecialchars('/') : '',
            'is_41f' => $filing->is_complaint == 1 ? htmlspecialchars('/') : '',
            'is_41g' => $filing->last_meeting_at ? htmlspecialchars('/') : '',
            'last_meeting_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->last_meeting_at))),
            'tenure_start' => htmlspecialchars($filing->tenure_start),
            'tenure_end' => htmlspecialchars($filing->tenure_end),
            'is_42a' => $filing->tenure_officer_start ? htmlspecialchars('/') : '',
            'tenure_officer_start' => htmlspecialchars($filing->tenure_officer_start),
            'tenure_officer_end' => htmlspecialchars($filing->tenure_officer_end),
            'last_election_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->last_election_at))),
            'is_42d' => $filing->forml_at ? htmlspecialchars('/') : '',
            'forml_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->forml_at))),
            'submitted_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->submitted_at))),
            'is_42e' => $filing->enforcement->notices ? htmlspecialchars('/') : '',
            'is_42f' => $filing->exception_civil_at ? htmlspecialchars('/') : '',
            'exception_civil_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->exception_civil_at))),
            'is_42g' => $filing->exception_minister_at ? htmlspecialchars('/') : '',
            'exception_minister_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->exception_minister_at))),
            'is_43a' => $filing->is_officer_changed == 1 ? htmlspecialchars('/') : '',
            'is_43b' => $filing->is_changes_approved == 1 ? htmlspecialchars('/') : '',
            'is_43c' => $filing->is_notice_submitted == 1 ? htmlspecialchars('/') : '',
            'is_44a' => $filing->is_worker_appointed == 1 ? htmlspecialchars('/') : '',
            'is_44b' => $filing->is_appoinment_approved == 1 ? htmlspecialchars('/') : '',
            'is_44c' => $filing->is_worker_changes == 1 ? htmlspecialchars('/') : '',
            'is_44d' => $filing->is_worker_notice_submitted == 1 ? htmlspecialchars('/') : '',
            'is_45a' => $filing->is_committee_meeting == 1 ? htmlspecialchars('/') : '',
            'is_45b' => $filing->is_committee_verified == 1 ? htmlspecialchars('/') : '',
            'is_45c' => $filing->is_committee_enough == 1 ? htmlspecialchars('/') : '',
            'is_45d' => $filing->last_committee_at ? htmlspecialchars('/') : '',
            'last_committee_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->last_committee_at))),
            'is_45e' => $filing->enforcement->meetings ? htmlspecialchars('/') : '',
            'is_46a' => $filing->total_examiner ? htmlspecialchars('/') : '',
            'total_examiner' => htmlspecialchars($filing->total_examiner),
            'is_d1' => $filing->enforcement->d1 ? htmlspecialchars('/') : '',
            'is_47a' => $filing->is_d1_obey == 1 ? htmlspecialchars('/') : '',
            'is_48a' => $filing->is_arbitrator_appointed == 1 ? htmlspecialchars('/') : '',
            'is_51a' => $filing->enforcement->federations ? htmlspecialchars('/') : '',
            'is_52a' => $filing->enforcement->internal_consultants ? htmlspecialchars('/') : '',
            'is_53a' => $filing->enforcement->external_consultants ? htmlspecialchars('/') : '',
            'comment' => htmlspecialchars($filing->comment),
            'io_name' => htmlspecialchars($filing->created_by->name),
            'date' => htmlspecialchars(date('d/m/Y', strtotime($filing->created_at))),
        ];

        if($filing->enforcement->entity->formb->union_type_id == 2){
            $data = array_merge($data, [  
                'is_2.1d' => $filing->registered_male || $filing->registered_female ? htmlspecialchars('/') : '',
                'is_2.1e' => '',
                'reg_m' => htmlspecialchars($filing->registered_male),
                'reg_f' => htmlspecialchars($filing->registered_female),
                'right_m' => htmlspecialchars($filing->rightful_male),
                'right_f' => htmlspecialchars($filing->rightful_female),
                'union_m' => htmlspecialchars($filing->union_male),
                'union_f' => htmlspecialchars($filing->union_female),
                'for_m' => htmlspecialchars($filing->foreign_male),
                'for_f' => htmlspecialchars($filing->foreign_female),
                'male' => htmlspecialchars($total_male),
                'fem' => htmlspecialchars($total_female),
                'reg' => htmlspecialchars($filing->registered_male + $filing->registered_female),
                'right' => htmlspecialchars($filing->rightful_male + $filing->rightful_female),
                'union' => htmlspecialchars($filing->union_male + $filing->union_female),
                'foreign' => htmlspecialchars($filing->foreign_male + $filing->foreign_female),
                'all' => htmlspecialchars($total_all),
                'reg_em' => htmlspecialchars(''),
                'reg_ef' => htmlspecialchars(''),
                'rightful_em' => htmlspecialchars(''),
                'rightful_ef' => htmlspecialchars(''),
                'union_em' => htmlspecialchars(''),
                'union_ef' => htmlspecialchars(''),
                'foreign_em' => htmlspecialchars(''),
                'foreign_ef' => htmlspecialchars(''),
                'emp_m' => htmlspecialchars(''),
                'emp_f' => htmlspecialchars(''),
                'reg_e' => htmlspecialchars(''),
                'rightful_e' => htmlspecialchars(''),
                'union_e' => htmlspecialchars(''),
                'foreign_e' => htmlspecialchars(''),
                'emp_all' => htmlspecialchars(''),
            ]);
        }
        else {
            $data = array_merge($data, [
                'is_2.1e' => $filing->registered_male || $filing->registered_female ? htmlspecialchars('/') : '',
                'is_2.1d' => '',
                'reg_em' => htmlspecialchars($filing->registered_male),
                'reg_ef' => htmlspecialchars($filing->registered_female),
                'rightful_em' => htmlspecialchars($filing->rightful_male),
                'rightful_ef' => htmlspecialchars($filing->rightful_female),
                'union_em' => htmlspecialchars($filing->union_male),
                'union_ef' => htmlspecialchars($filing->union_female),
                'foreign_em' => htmlspecialchars($filing->foreign_male),
                'foreign_ef' => htmlspecialchars($filing->foreign_female),
                'emp_m' => htmlspecialchars($total_male),
                'emp_f' => htmlspecialchars($total_female),
                'reg_e' => htmlspecialchars($filing->registered_male + $filing->registered_female),
                'rightful_e' => htmlspecialchars($filing->rightful_male + $filing->rightful_female),
                'union_e' => htmlspecialchars($filing->union_male + $filing->union_female),
                'foreign_e' => htmlspecialchars($filing->foreign_male + $filing->foreign_female),
                'emp_all' => htmlspecialchars($total_all),
                'reg_m' => htmlspecialchars(''),
                'reg_f' => htmlspecialchars(''),
                'right_m' => htmlspecialchars(''),
                'right_f' => htmlspecialchars(''),
                'union_m' => htmlspecialchars(''),
                'union_f' => htmlspecialchars(''),
                'for_m' => htmlspecialchars(''),
                'for_f' => htmlspecialchars(''),
                'male' => htmlspecialchars(''),
                'fem' => htmlspecialchars(''),
                'reg' => htmlspecialchars(''),
                'right' => htmlspecialchars(''),
                'union' => htmlspecialchars(''),
                'foreign' => htmlspecialchars(''),
                'all' => htmlspecialchars(''),
            ]);
        }

        $log = new LogSystem;
        $log->module_id = 29;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/enforcement/report.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table leaving
        $rows = $filing->enforcement->records;
        $document->cloneRow('duration_record', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('duration_record#'.($index+1), htmlspecialchars($row->duration));
            $document->setValue('date_record#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row->inspection_at))));
        }

        // Generate table fixed deposit accoint
        $rows = $filing->enforcement->fd_accounts;
        $document->cloneRow('cert_no', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('cert_no#'.($index+1), htmlspecialchars($row->cert_no));
            $document->setValue('bank_name#'.($index+1), htmlspecialchars($row->bank_name));
            $document->setValue('matured_at#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row->matured_at))));
            $document->setValue('amount#'.($index+1), htmlspecialchars($row->amount));
        }

        // Generate table meeting
        $rows = $filing->enforcement->meetings;
        $document->cloneRow('meeting_at', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('total_meeting#'.($index+1), htmlspecialchars($row->total_meeting));
            $document->setValue('meeting_at#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row->meeting_at))));
        }

        // Generate list
        $auditors = $filing->enforcement->auditors;

        $document->cloneBlockString('list', count($auditors));

        foreach($auditors as $index => $auditor){
            $content = preg_replace('~\R~u', '<w:br/>', $auditor->name);
            $document->setValue('auditor_name', strtoupper($content), 1);
            $document->setValue('auditor_designation', strtoupper($auditor->designation), 1);
        }

        // Generate list account
        $accounts = $filing->enforcement->accounts;

        $document->cloneBlockString('list2', count($accounts));

        foreach($accounts as $index => $account){
            $content = preg_replace('~\R~u', '<w:br/>', $account->a_account_no);
            $document->setValue('a_account_no', strtoupper($content), 1);
            $document->setValue('a_bank_name', strtoupper($account->a_bank_name), 1);
        }

        // Generate list
        $notices = $filing->enforcement->notices;

        $document->cloneBlockString('list3', count($notices));

        foreach($notices as $index => $notice){
            $content = preg_replace('~\R~u', '<w:br/>', $notice->notice);
            $document->setValue('notice', strtoupper($content), 1);
        }

        // Generate list
        $federations = $filing->enforcement->federations;

        $document->cloneBlockString('list4', count($federations));

        foreach($federations as $index => $federation){
            $content = preg_replace('~\R~u', '<w:br/>', $federation->federation->name);
            $document->setValue('federation_name', strtoupper($content), 1);
        }

        // Generate list
        $internal_consultants = $filing->enforcement->internal_consultants;

        $document->cloneBlockString('list5', count($internal_consultants));

        foreach($internal_consultants as $index => $internal){
            $content = preg_replace('~\R~u', '<w:br/>', $internal->consultant);
            $document->setValue('internal_consultant', strtoupper($content), 1);
        }

        // Generate list
        $external_consultants = $filing->enforcement->external_consultants;

        $document->cloneBlockString('list6', count($external_consultants));

        foreach($external_consultants as $index => $external){
            $content = preg_replace('~\R~u', '<w:br/>', $external->consultant);
            $document->setValue('external_consultant', strtoupper($content), 1);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Laporan Penguatkuasaan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function a1_download(Request $request) {

        $filing = Enforcement::findOrFail($request->id);
                                                              // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [];

        $log = new LogSystem;
        $log->module_id = 29;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/enforcement/attachment_a1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table leaving
        $rows = $filing->a1;
        $document->cloneRow('no', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('a1_designation#'.($index+1), ($row->designation ? htmlspecialchars($row->designation->name) : ''));
            $document->setValue('a1_name#'.($index+1), htmlspecialchars($row->name));
            $document->setValue('a1_address#'.($index+1), htmlspecialchars($row->address->address1).
                ($row->address->address2 ? ', '.htmlspecialchars($row->address->address2) : '').
                ($row->address->address3 ? ', '.htmlspecialchars($row->address->address3) : '').
                ', '.($row->address->postcode).
                ($row->address->district ? ' '.htmlspecialchars($row->address->district->name) : '').
                ($row->address->state ? ', '.htmlspecialchars($row->address->state->name) : ''));
            $document->setValue('a1_phone#'.($index+1), htmlspecialchars($row->phone));
            $document->setValue('a1_email#'.($index+1), htmlspecialchars($row->email));
            $document->setValue('a1_grade#'.($index+1), htmlspecialchars($row->grade));
        }


        // save as a random file in temp file
        $file_name = uniqid().'_'.'Lampiran A1 - Laporan Penguatkuasaan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function a2_download(Request $request) {

        $filing = Enforcement::findOrFail($request->id);
                                                              // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [];

        $log = new LogSystem;
        $log->module_id = 29;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/enforcement/attachment_a2.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table leaving
        $rows = $filing->a2;
        $document->cloneRow('no', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('a2_designation#'.($index+1), $row->designation ? htmlspecialchars($row->designation->name) : '');
            $document->setValue('a2_name#'.($index+1), htmlspecialchars($row->name));
            $document->setValue('a2_address#'.($index+1), htmlspecialchars($row->address->address1).
                ($row->address->address2 ? ', '.htmlspecialchars($row->address->address2) : '').
                ($row->address->address3 ? ', '.htmlspecialchars($row->address->address3) : '').
                ', '.($row->address->postcode).
                ($row->address->district ? ' '.htmlspecialchars($row->address->district->name) : '').
                ($row->address->state ? ', '.htmlspecialchars($row->address->state->name) : ''));
            $document->setValue('a2_phone#'.($index+1), htmlspecialchars($row->phone));
            $document->setValue('a2_email#'.($index+1), htmlspecialchars($row->email));
            $document->setValue('a2_location#'.($index+1), htmlspecialchars($row->office_location));
            $document->setValue('a2_grade#'.($index+1), htmlspecialchars($row->grade));
        }


        // save as a random file in temp file
        $file_name = uniqid().'_'.'Lampiran A2 - Laporan Penguatkuasaan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function a3_download(Request $request) {

        $filing = Enforcement::findOrFail($request->id);
                                                              // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [];

        $log = new LogSystem;
        $log->module_id = 29;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/enforcement/attachment_a3.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table leaving
        $rows = $filing->a3;
        $document->cloneRow('a3_designation', count($rows));

        foreach($rows as $index => $row) {
            $allowance_list = '';
            $incentive_list = '';
            foreach ($row->allowances as $key => $allowance) {
               $allowance_list .= $allowance->name.' - RM'.$allowance->value;
            }
            foreach ($row->incentives as $key => $incentive) {
               $incentive_list .= $incentive->name.' - RM'.$incentive->value;
            }
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('a3_designation#'.($index+1), $row->designation ? htmlspecialchars($row->designation->name) : '');
            $document->setValue('a3_allowance#'.($index+1), htmlspecialchars(preg_replace('~\R~u', '<w:br/>', $allowance_list)));
            $document->setValue('a3_incentive#'.($index+1), htmlspecialchars(preg_replace('~\R~u', '<w:br/>', $incentive_list)));
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Lampiran A3 - Laporan Penguatkuasaan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function a4_download(Request $request) {

        $filing = Enforcement::findOrFail($request->id);
                                                              // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [];

        $log = new LogSystem;
        $log->module_id = 29;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/enforcement/attachment_a4.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table leaving
        $rows = $filing->a4;
        $document->cloneRow('a4_designation', count($rows));

        foreach($rows as $index => $row) {
            $allowance_list = '';
            $incentive_list = '';
            foreach ($row->allowances as $key => $allowance) {
               $allowance_list .= $allowance->name.' - RM'.$allowance->value;
            }
            foreach ($row->incentives as $key => $incentive) {
               $incentive_list .= $incentive->name.' - RM'.$incentive->value;
            }
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('a4_name#'.($index+1), htmlspecialchars($row->name));
            $document->setValue('a4_designation#'.($index+1), $row->designation ? htmlspecialchars($row->designation->name) : '');
            $document->setValue('a4_appointed_at#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row->appointed_at))));
            $document->setValue('a4_allowance#'.($index+1), htmlspecialchars(preg_replace('~\R~u', '<w:br/>', $allowance_list)));
            $document->setValue('a4_incentive#'.($index+1), htmlspecialchars(preg_replace('~\R~u', '<w:br/>', $incentive_list)));
        }


        // save as a random file in temp file
        $file_name = uniqid().'_'.'Lampiran A4 - Laporan Penguatkuasaan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function a5_download(Request $request) {

        $enforcement = Enforcement::findOrFail($request->id);
        $filing = $enforcement->a5->where('branch_id', $request->branch_id)->get();
                                                              // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [
            'branch_name' =>$filing->branch ?  htmlspecialchars($filing->branch->name) : htmlspecialchars($enforcement->entity->name),
            'membership_at' => htmlspecialchars($filing->membership_at),
            'total_rightful_male' => htmlspecialchars($filing->total_rightful_male),
            'total_registered_male' => htmlspecialchars($filing->total_registered_male),
            'total_chairman_male' => htmlspecialchars($filing->total_chairman_male),
            'total_vice_chairman_male' => htmlspecialchars($filing->total_vice_chairman_male),
            'total_secretary_male' => htmlspecialchars($filing->total_secretary_male),
            'total_treasurer_male' => htmlspecialchars($filing->total_treasurer_male),
            'total_committee_male' => htmlspecialchars($filing->total_committee_male),
            'total_race_malay_male' => htmlspecialchars($filing->total_race_malay_male),
            'total_race_chinese_male' => htmlspecialchars($filing->total_race_chinese_male),
            'total_race_indian_male' => htmlspecialchars($filing->total_race_indian_male),
            'total_race_others_male' => htmlspecialchars($filing->total_race_others_male),
            'total_race_bumiputera_male' => htmlspecialchars($filing->total_race_bumiputera_male),
            'total_allied_malay_male' => htmlspecialchars($filing->total_allied_malay_male),
            'total_allied_chinese_male' => htmlspecialchars($filing->total_allied_chinese_male),
            'total_allied_indian_male' => htmlspecialchars($filing->total_allied_indian_male),
            'total_allied_bumiputera_male' => htmlspecialchars($filing->total_allied_bumiputera_male),
            'total_allied_others_male' => htmlspecialchars($filing->total_allied_others_male),
            'total_indonesian_male' => htmlspecialchars($filing->total_indonesian_male),
            'total_vietnamese_male' => htmlspecialchars($filing->total_vietnamese_male),
            'total_philippines_male' => htmlspecialchars($filing->total_philippines_male),
            'total_myanmar_male' => htmlspecialchars($filing->total_myanmar_male),
            'total_cambodia_male' => htmlspecialchars($filing->total_cambodia_male),
            'total_bangladesh_male' => htmlspecialchars($filing->total_bangladesh_male),
            'total_india_male' => htmlspecialchars($filing->total_india_male),
            'total_others_male' => htmlspecialchars($filing->total_others_male),
            'total_nepal_male' => htmlspecialchars($filing->total_nepal_male),
            'total_rightful_male' => htmlspecialchars($filing->total_rightful_male),
            'total_registered_female' => htmlspecialchars($filing->total_registered_female),
            'total_chairman_female' => htmlspecialchars($filing->total_chairman_female),
            'total_vice_chairman_female' => htmlspecialchars($filing->total_vice_chairman_female),
            'total_secretary_female' => htmlspecialchars($filing->total_secretary_female),
            'total_treasurer_female' => htmlspecialchars($filing->total_treasurer_female),
            'total_committee_female' => htmlspecialchars($filing->total_committee_female),
            'total_race_malay_female' => htmlspecialchars($filing->total_race_malay_female),
            'total_race_chinese_female' => htmlspecialchars($filing->total_race_chinese_female),
            'total_race_indian_female' => htmlspecialchars($filing->total_race_indian_female),
            'total_race_others_female' => htmlspecialchars($filing->total_race_others_female),
            'total_race_bumiputera_female' => htmlspecialchars($filing->total_race_bumiputera_female),
            'total_allied_malay_female' => htmlspecialchars($filing->total_allied_malay_female),
            'total_allied_chinese_female' => htmlspecialchars($filing->total_allied_chinese_female),
            'total_allied_indian_female' => htmlspecialchars($filing->total_allied_indian_female),
            'total_allied_bumiputera_female' => htmlspecialchars($filing->total_allied_bumiputera_female),
            'total_allied_others_female' => htmlspecialchars($filing->total_allied_others_female),
            'total_indonesian_female' => htmlspecialchars($filing->total_indonesian_female),
            'total_vietnamese_female' => htmlspecialchars($filing->total_vietnamese_female),
            'total_philippines_female' => htmlspecialchars($filing->total_philippines_female),
            'total_myanmar_female' => htmlspecialchars($filing->total_myanmar_female),
            'total_cambodia_female' => htmlspecialchars($filing->total_cambodia_female),
            'total_bangladesh_female' => htmlspecialchars($filing->total_bangladesh_female),
            'total_india_female' => htmlspecialchars($filing->total_india_female),
            'total_others_male' => htmlspecialchars($filing->total_others_female),
            'total_nepal_female' => htmlspecialchars($filing->total_nepal_female),

        ];

        $log = new LogSystem;
        $log->module_id = 29;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/enforcement/attachment_a5.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Lampiran A5 - Laporan Penguatkuasaan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function a6_download(Request $request) {

        $filing = Enforcement::findOrFail($request->id);
                                                              // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [];

        $log = new LogSystem;
        $log->module_id = 29;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/enforcement/attachment_a6.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table leaving
        $rows = $filing->a6;
        $document->cloneRow('a6_company_name', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('a6_company_name#'.($index+1), htmlspecialchars($row->company_name));
            $document->setValue('a6_duration#'.($index+1), htmlspecialchars($row->duration));
        }


        // save as a random file in temp file
        $file_name = uniqid().'_'.'Lampiran A6 - Laporan Penguatkuasaan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function b1_download(Request $request) {

        $filing = Enforcement::findOrFail($request->id);
                                                              // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [];

        $log = new LogSystem;
        $log->module_id = 29;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/enforcement/attachment_b1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table leaving
        $rows = $filing->b1;
        $document->cloneRow('b1_asset', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('b1_asset#'.($index+1), htmlspecialchars($row->asset));
            $document->setValue('b1_year_obtained#'.($index+1), htmlspecialchars($row->year_obtained));
            $document->setValue('b1_current_value#'.($index+1), htmlspecialchars($row->current_value));
            $document->setValue('b1_location#'.($index+1), htmlspecialchars($row->location));
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Lampiran B1 - Laporan Penguatkuasaan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function c1_download(Request $request) {

        $enforcement = Enforcement::findOrFail($request->id);
                                       // Change here
        $filing = $enforcement->c1;
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [

            'cash_at_hand' => htmlspecialchars($filing->cash_at_hand),
            'cash_at_bank' => htmlspecialchars($filing->cash_at_bank),
            'entrance_fee' => htmlspecialchars($filing->entrance_fee),
            'monthly_fee' => htmlspecialchars($filing->monthly_fee),
            'union_office' => htmlspecialchars($filing->union_office),
            'volunteer_fund' => htmlspecialchars($filing->volunteer_fund),
            'special_collection' => htmlspecialchars($filing->special_collection),
            'bank_interest' => htmlspecialchars($filing->bank_interest),
            'total_income' => htmlspecialchars($filing->total_income),
            'officer_allowance' => htmlspecialchars($filing->officer_allowance),
            'post_shipping' => htmlspecialchars($filing->post_shipping),
            'phone' => htmlspecialchars($filing->phone),
            'stationary' => htmlspecialchars($filing->stationary),
            'wage' => htmlspecialchars($filing->wage),
            'meeting_expenses' => htmlspecialchars($filing->meeting_expenses),
            'deposit_payment' => htmlspecialchars($filing->deposit_payment),
            'social_paymant' => htmlspecialchars($filing->social_paymant),
            'fare' => htmlspecialchars($filing->fare),
            'tax' => htmlspecialchars($filing->tax),
            'rental' => htmlspecialchars($filing->rental),
            'electric_bill' => htmlspecialchars($filing->electric_bill),
            'welfare_aid' => htmlspecialchars($filing->welfare_aid),
            'union_payment' => htmlspecialchars($filing->union_payment),
            'seminar_course' => htmlspecialchars($filing->seminar_course),
            'total_at_hand' => htmlspecialchars($filing->total_at_hand),
            'cash_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->cash_at))),
            'total_at_bank' => htmlspecialchars($filing->total_at_bank),
            'bank_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->bank_at))),
            'total_liability' => htmlspecialchars($filing->total_liability),
        ];

        $log = new LogSystem;
        $log->module_id = 29;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/enforcement/attachment_c1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }


        // save as a random file in temp file
        $file_name = uniqid().'_'.'Lampiran C1 - Laporan Penguatkuasaan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function d1_download(Request $request) {

        $filing = Enforcement::findOrFail($request->id);
                                                              // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [];

        $log = new LogSystem;
        $log->module_id = 29;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/enforcement/attachment_d1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table leaving
        $rows = $filing->examiners;
        $document->cloneRow('examiner_name', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('examiner_name#'.($index+1), htmlspecialchars($row->examiner_name));
            $document->setValue('examiner_identification_no#'.($index+1), htmlspecialchars($row->identification_no));
            $document->setValue('examiner_appointed_at#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row->appointed_at))));
        }

         // Generate table leaving
        $rows = $filing->trustees;
        $document->cloneRow('trustee_name', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('trustee_name#'.($index+1), htmlspecialchars($row->trustee_name));
            $document->setValue('trustee_identification_no#'.($index+1), htmlspecialchars($row->identification_no));
            $document->setValue('trustee_dob#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row->date_of_birth))));
            $document->setValue('trustee_appointed_at#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row->appointed_at))));
        }

        // Generate table leaving
        $rows = $filing->arbitrators;
        $document->cloneRow('arbitrator_name', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('arbitrator_name#'.($index+1), htmlspecialchars($row->arbitrator_name));
            $document->setValue('arbitrator_identification_no#'.($index+1), htmlspecialchars($row->identification_no));
            $document->setValue('arbitrator_appointed_at#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row->appointed_at))));
        }


        // save as a random file in temp file
        $file_name = uniqid().'_'.'Lampiran D1 - Laporan Penguatkuasaan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
