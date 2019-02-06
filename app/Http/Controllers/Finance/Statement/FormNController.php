<?php

namespace App\Http\Controllers\Finance\Statement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\FormN\ApprovedKS;
use App\Mail\FormN\ApprovedPWN;
use App\Mail\FormN\Rejected;
use App\Mail\FormN\Sent;
use App\Mail\FormN\NotReceived;
use App\Mail\FormN\DocumentApproved;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\Query;
use App\FilingModel\FormN;
use App\FilingModel\FormNSalary;
use App\FilingModel\FormNExpenditure;
use App\FilingModel\FormNDebt;
use App\FilingModel\FormNLoan;
use App\FilingModel\FormNLent;
use App\FilingModel\FormNCash;
use App\FilingModel\FormNBank;
use App\FilingModel\FormNLiability;
use App\FilingModel\FormNLeaving;
use App\FilingModel\FormNAppointed;
use App\FilingModel\FormNSecurity;
use App\MasterModel\MasterState;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterDesignation;
use App\OtherModel\Attachment;
use App\OtherModel\Address;
use App\UserStaff;
use App\User;
use Validator;
use Carbon\Carbon;
use Mail;
use PDF;
use Auth;
use Storage;
use App\Custom\PhpWord;

class FormNController extends Controller
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
     * Show the list of data
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 26;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang Penyata Kewangan Kesatuan";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $statements = FormN::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $statements = $statements->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $statements = $statements->where('filing_status_id', '>', 1)->where(function($statements) {
                    return $statements->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($statements){
                        if(auth()->user()->hasRole('ptw'))
                            return $statements->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $statements->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $statements = $statements->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($statements)
                ->editColumn('tenure.entity.name', function ($statement) {
                    return $statement->tenure->entity->name;
                })
                ->editColumn('entity_type', function ($statement) {
                    return $statement->tenure->entity_type == "App\\UserUnion" ? 'Kesatuan' : 'Persekutuan';
                })
                ->editColumn('applied_at', function ($statement) {
                    return $statement->applied_at ? date('d/m/Y', strtotime($statement->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($statement) {
                    if($statement->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$statement->status->name.'</span>';
                    else if($statement->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$statement->status->name.'</span>';
                    else if($statement->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$statement->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$statement->status->name.'</span>';
                })
                ->editColumn('letter', function($statement) {
                    if($statement->filing_status_id == 1)
                        return 
                            '<a href="'.url('files/finance/statement/bn2.pdf').'" class="btn btn-xs btn-default mb-1 text-capitalize pull-right"><i class="fa fa-download mr-1"></i> Laporan Borang N dan Penyata Kewangan</a>';
                })
                ->editColumn('action', function ($statement) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($statement)).'\','.$statement->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status('.$statement->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $statement->is_editable)) && $statement->filing_status_id < 7)
                        $button .= '<a href="'.route('statement.ks.form', $statement->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    // if(auth()->user()->hasRole('ptw'))
                    //     $button .= '<a onclick="uploadData(1)" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-upload mr-1"></i> Muat Naik Dokumen</a><br>';
                    
                    if( ((auth()->user()->hasRole('ptw') && $statement->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $statement->distributions->count() == 3)) && $statement->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$statement->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp','ppp', 'pkpg','kpks']) && $statement->filing_status_id < 8)
                        $button .= '<a onclick="query('.$statement->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg', 'pkpp', 'ppp']) && $statement->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$statement->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 26;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang Penyata Kewangan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }
        return view('finance.statement.ks.list');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $statement = FormN::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'signed_by_user_id' => auth()->user()->entity->tenures->last()->officers()->where('designation_id', 5)->first()->id,
            'applied_at' => Carbon::now(),
        ]);

        $errors_formn = count(($this->getErrors($statement))['formn']);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Penyata Kewangan Kesatuan";
        $log->data_new = json_encode($statement);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('finance.statement.ks.index', compact('statement', 'errors_formn'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $errors_formn = count(($this->getErrors($statement))['formn']);

        return view('finance.statement.ks.index', compact('statement','errors_formn'));
    }

    private function getErrors($statement) {

        $errors = [];

        if(!$statement) {
            $errors['formn'] = range(1,46);
        }
        else {
            $validate_formn = Validator::make($statement->toArray(), [
                'year' => 'required|integer',
                'total_member_start' => 'required|integer',
                'total_member_accepted' => 'required|integer',
                'total_member_leave' => 'required|integer',
                'total_member_end' => 'required|integer',
                'total_male' => 'required|integer',
                'total_female' => 'required|integer',
                'male_malay' => 'required|integer',
                'male_chinese' => 'required|integer',
                'male_indian' => 'required|integer',
                'male_others' => 'required|integer',
                'female_malay' => 'required|integer',
                'female_chinese' => 'required|integer',
                'female_indian' => 'required|integer',
                'female_others' => 'required|integer',
                'duration' => 'required|string',
                'accept_balance_start' => 'required|numeric',
                'accept_entrance_fee' => 'required|numeric',
                'accept_membership_fee' => 'required|numeric',
                'accept_sponsorship' => 'required|numeric',
                'accept_sales' => 'required|numeric',
                'accept_interest' => 'required|numeric',
                'accept_membership_fee' => 'required|numeric',
                'pay_officer_salary' => 'required|numeric',
                'pay_organization_salary' => 'required|numeric',
                'pay_auditor_fee' => 'required|numeric',
                'pay_attorney_expenditure' => 'required|numeric',
                'pay_tred_expenditure' => 'required|numeric',
                'pay_compensation' => 'required|numeric',
                'pay_sick_benefit' => 'required|numeric',
                'pay_study_benefit' => 'required|numeric',
                'pay_publication_cost' => 'required|numeric',
                'pay_rental' => 'required|numeric',
                'pay_stationary' => 'required|numeric',
                'pay_balance_end' => 'required|numeric',
                'liability_fund' => 'required|numeric',
                'asset_security' => 'required|numeric',
                'asset_property' => 'required|string',
                'asset_property_total' => 'required|numeric',
                'asset_furniture' => 'required|numeric',
                'other_asset' => 'required|string',
                'other_asset_total' => 'required|numeric',
                'signed_district_id' => 'required|integer',
                'signed_state_id' => 'required|integer',
                'signed_at' => 'required',
            ]);

            $errors_formn = [];

            if ($validate_formn->fails())
                $errors_formn = array_merge($errors_formn, $validate_formn->errors()->toArray());

            $errors['formn'] = $errors_formn;
        }

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $salary = $statement->salaries()->sum('total');
        $loan = $statement->loans()->sum('total');
        $lent = $statement->lents()->sum('total');
        $bank = $statement->banks()->sum('total');
        $cash = $statement->cash()->sum('total');
        $debt = $statement->debts()->sum('total');
        $liability = $statement->liabilities()->sum('total');
        $expenditure = $statement->expenditures()->sum('total');

        $total_accept = $statement->accept_balance_start + $statement->accept_entrance_fee + $statement->accept_membership_fee + $statement->accept_sponsorship + $statement->accept_sales + $statement->accept_interest + $salary;

        $total_pay = $statement->pay_officer_salary + $statement->pay_organization_salary + $statement->pay_auditor_fee + $statement->pay_attorney_expenditure + $statement->pay_tred_expenditure + $statement->pay_compensation + $statement->pay_sick_benefit + $statement->pay_study_benefit + $statement->pay_publication_cost + $statement->pay_rental + $statement->pay_stationary + $statement->pay_balance_end + $expenditure;

        $total_liability = $statement->liability_fund + $lent + $debt + $liability;

        $total_asset = $statement->asset_security + $statement->asset_property_total + $statement->asset_furniture + $statement->other_asset_total + $cash + $bank + $lent;

        $statement->total_pay = $total_pay;
        $statement->total_asset = $total_asset;
        $statement->total_liability = $total_liability;
        $statement->total_accept = $total_accept;
        $statement->save();

        $error_list = $this->getErrors($statement);
        $errors = count($error_list['formn']);

        // return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 26;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang Penyata Kewangan Kesatuan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $statement->filing_status_id = 2;
            $statement->is_editable = 0;
            $statement->save();

            $statement->logs()->updateOrCreate(
                [
                    'module_id' => 26,
                    'activity_type_id' => 11,
                    'filing_status_id' => $statement->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' =>  auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $statement->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 26,
            ]);

            Mail::to($statement->created_by->email)->send(new Sent($statement, 'Penyata Tahunan Kesatuan'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan anda telah dihantar.']);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function formn_index(Request $request) {

        $statement = FormN::findOrFail($request->id);
        $states = MasterState::all();
        $districts = MasterDistrict::all();
        $designations = MasterDesignation::all();

        return view('finance.statement.ks.formn.index', compact('statement','states','districts','designations'));
    }

    //// START SALARY CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function salary_index(Request $request) {

        $salaries = FormNSalary::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang Penyata Kewangan Kesatuan - Butiran Pendapatan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($salaries)
        ->editColumn('action', function ($salary) {
            $button = "";

            $button .= '<a onclick="editSalary('.$salary->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeSalary('.$salary->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function salary_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['formn_id' => $statement->id]);
        $salary = FormNSalary::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Penyata Kewangan Kesatuan - Butiran Pendapatan";
        $log->data_new = json_encode($salary);
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
    public function salary_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang Penyata Kewangan Kesatuan - Butiran Pendapatan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $salary = FormNSalary::findOrFail($request->salary_id);

        return view('finance.statement.ks.formn.salary.edit', compact('salary'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function salary_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $salary = FormNSalary::findOrFail($request->salary_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang Penyata Kewangan Kesatuan - Butiran Pendapatan";
        $log->data_old = json_encode($salary);

        $salary->update($request->all());

        $log->data_new = json_encode($salary);
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
    public function salary_delete(Request $request) {

        $salary = FormNSalary::findOrFail($request->salary_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang Penyata Kewangan Kesatuan - Butiran Pendapatan";
        $log->data_old = json_encode($salary);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $salary->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //// START EXPENDITURE CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function expenditure_index(Request $request) {

        $expenditures = FormNExpenditure::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang Penyata Kewangan Kesatuan - Butiran Perbelanjaan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($expenditures)
        ->editColumn('action', function ($expenditure) {
            $button = "";

            $button .= '<a onclick="editExpenditure('.$expenditure->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeExpenditure('.$expenditure->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function expenditure_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['formn_id' => $statement->id]);
        $expenditure = FormNExpenditure::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Penyata Kewangan Kesatuan - Butiran Perbelanjaan";
        $log->data_new = json_encode($expenditure);
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
    public function expenditure_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang Penyata Kewangan Kesatuan - Butiran Perbelanjaan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $expenditure = FormNExpenditure::findOrFail($request->expenditure_id);

        return view('finance.statement.ks.formn.expenditure.edit', compact('expenditure'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function expenditure_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $expenditure = FormNExpenditure::findOrFail($request->expenditure_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang Penyata Kewangan Kesatuan - Butiran Perbelanjaan";
        $log->data_old = json_encode($expenditure);

        $expenditure->update($request->all());

        $log->data_new = json_encode($expenditure);
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
    public function expenditure_delete(Request $request) {

        $expenditure = FormNExpenditure::findOrFail($request->expenditure_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang Penyata Kewangan Kesatuan - Butiran Perbelanjaan";
        $log->data_old = json_encode($expenditure);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $expenditure->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //// START LOAN CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function loan_index(Request $request) {

        $loans = FormNLoan::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang Penyata Kewangan Kesatuan - Butiran Pinjaman Daripada";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($loans)
        ->editColumn('action', function ($loan) {
            $button = "";

            $button .= '<a onclick="editLoan('.$loan->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeLoan('.$loan->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function loan_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['formn_id' => $statement->id]);
        $loan = FormNLoan::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Penyata Kewangan Kesatuan - Butiran Pinjaman Daripada";
        $log->data_new = json_encode($loan);
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
    public function loan_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang Penyata Kewangan Kesatuan - Butiran Pinjaman Daripada";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $loan = FormNLoan::findOrFail($request->loan_id);

        return view('finance.statement.ks.formn.loan.edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function loan_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loan = FormNLoan::findOrFail($request->loan_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang Penyata Kewangan Kesatuan - Butiran Pinjaman Daripada";
        $log->data_old = json_encode($loan);

        $loan->update($request->all());

        $log->data_new = json_encode($loan);
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
    public function loan_delete(Request $request) {

        $loan = FormNLoan::findOrFail($request->loan_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang Penyata Kewangan Kesatuan - Butiran Perbelanjaan";
        $log->data_old = json_encode($loan);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $loan->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //// START DEBT CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function debt_index(Request $request) {

        $debts = FormNDebt::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang Penyata Kewangan Kesatuan - Butiran Hutang Terakru";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($debts)
        ->editColumn('action', function ($debt) {
            $button = "";

            $button .= '<a onclick="editDebt('.$debt->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeDebt('.$debt->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function debt_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['formn_id' => $statement->id]);
        $debt = FormNDebt::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Penyata Kewangan Kesatuan - Butiran Hutang Terakru";
        $log->data_new = json_encode($debt);
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
    public function debt_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang Penyata Kewangan Kesatuan - Butiran Hutang Terakru";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $debt = FormNDebt::findOrFail($request->debt_id);

        return view('finance.statement.ks.formn.debt.edit', compact('debt'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function debt_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $debt = FormNDebt::findOrFail($request->debt_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang Penyata Kewangan Kesatuan - Butiran Hutang Terakru";
        $log->data_old = json_encode($debt);

        $debt->update($request->all());

        $log->data_new = json_encode($debt);
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
    public function debt_delete(Request $request) {

        $debt = FormNDebt::findOrFail($request->debt_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang Penyata Kewangan Kesatuan - Butiran Hutang Terakru";
        $log->data_old = json_encode($debt);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $debt->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //// START LIABILITY CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function liability_index(Request $request) {

        $liabilities = FormNLiability::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang Penyata Kewangan Kesatuan - Butiran Liabliti Lain";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($liabilities)
        ->editColumn('action', function ($liability) {
            $button = "";

            $button .= '<a onclick="editLiability('.$liability->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeLiability('.$liability->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function liability_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['formn_id' => $statement->id]);
        $liability = FormNLiability::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Penyata Kewangan Kesatuan - Butiran Liabliti Lain";
        $log->data_new = json_encode($liability);
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
    public function liability_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang Penyata Kewangan Kesatuan - Butiran Liabliti Lain";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $liability = FormNLiability::findOrFail($request->liability_id);

        return view('finance.statement.ks.formn.liability.edit', compact('liability'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function liability_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $liability = FormNLiability::findOrFail($request->liability_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang Penyata Kewangan Kesatuan - Butiran Liabliti Lain";
        $log->data_old = json_encode($liability);

        $liability->update($request->all());

        $log->data_new = json_encode($liability);
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
    public function liability_delete(Request $request) {

        $liability = FormNLiability::findOrFail($request->liability_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang Penyata Kewangan Kesatuan - Butiran Liabliti Lain";
        $log->data_old = json_encode($liability);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $liability->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //// START CASH CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cash_index(Request $request) {

        $cash = FormNCash::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang Penyata Kewangan Kesatuan - Butiran Dalam Tangan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($cash)
        ->editColumn('action', function ($cash) {
            $button = "";

            $button .= '<a onclick="editCash('.$cash->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeCash('.$cash->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function cash_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['formn_id' => $statement->id]);
        $cash = FormNCash::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Penyata Kewangan Kesatuan - Butiran Dalam Tangan";
        $log->data_new = json_encode($cash);
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
    public function cash_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang Penyata Kewangan Kesatuan - Butiran Dalam Tangan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $cash = FormNCash::findOrFail($request->cash_id);

        return view('finance.statement.ks.formn.cash.edit', compact('cash'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function cash_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cash = FormNCash::findOrFail($request->cash_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang Penyata Kewangan Kesatuan - Butiran Dalam Tangan";
        $log->data_old = json_encode($cash);

        $cash->update($request->all());

        $log->data_new = json_encode($cash);
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
    public function cash_delete(Request $request) {

        $cash = FormNCash::findOrFail($request->cash_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang Penyata Kewangan Kesatuan - Butiran Dalam Tangan";
        $log->data_old = json_encode($cash);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $cash->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //// START BANK CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function bank_index(Request $request) {

        $bank = FormNBank::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang Penyata Kewangan Kesatuan - Butiran Dalam Bank";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($bank)
        ->editColumn('action', function ($bank) {
            $button = "";

            $button .= '<a onclick="editBank('.$bank->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeBank('.$bank->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function bank_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['formn_id' => $statement->id]);
        $bank = FormNBank::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Penyata Kewangan Kesatuan - Butiran Dalam Bank";
        $log->data_new = json_encode($bank);
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
    public function bank_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang Penyata Kewangan Kesatuan - Butiran Dalam Bank";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $bank = FormNBank::findOrFail($request->bank_id);

        return view('finance.statement.ks.formn.bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function bank_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $bank = FormNBank::findOrFail($request->bank_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang Penyata Kewangan Kesatuan - Butiran Dalam Bank";
        $log->data_old = json_encode($bank);

        $bank->update($request->all());

        $log->data_new = json_encode($bank);
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
    public function bank_delete(Request $request) {

        $bank = FormNBank::findOrFail($request->bank_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang Penyata Kewangan Kesatuan - Butiran Dalam Bank";
        $log->data_old = json_encode($bank);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $bank->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //// START LENT CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function lent_index(Request $request) {

        $lent = FormNLent::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang Penyata Kewangan Kesatuan - Butiran Hutang Terakru";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($lent)
        ->editColumn('action', function ($lent) {
            $button = "";

            $button .= '<a onclick="editLent('.$lent->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeLent('.$lent->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function lent_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['formn_id' => $statement->id]);
        $lent = FormNLent::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Penyata Kewangan Kesatuan - Butiran Hutang Terakru";
        $log->data_new = json_encode($lent);
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
    public function lent_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang Penyata Kewangan Kesatuan - Butiran Hutang Terakru";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $lent = FormNLent::findOrFail($request->lent_id);

        return view('finance.statement.ks.formn.lent.edit', compact('lent'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function lent_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lent = FormNLent::findOrFail($request->lent_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang Penyata Kewangan Kesatuan - Butiran Hutang Terakru";
        $log->data_old = json_encode($lent);

        $lent->update($request->all());

        $log->data_new = json_encode($lent);
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
    public function lent_delete(Request $request) {

        $lent = FormNLent::findOrFail($request->lent_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang Penyata Kewangan Kesatuan - Butiran Hutang Terakru";
        $log->data_old = json_encode($lent);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $lent->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //// START OFFICER LEAVING CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function leaving_index(Request $request) {

        $leaving_officers = FormNLeaving::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Pegawai yang Melepaskan Jawatan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($leaving_officers)
        ->editColumn('designation.name', function ($leaving_officer) {
            return $leaving_officer->designation ? $leaving_officer->designation->name : '';
        })
        ->editColumn('left_at', function ($leaving_officer) {
            return $leaving_officer->left_at ? date('d/m/Y', strtotime($leaving_officer->left_at)) : '-';
        })
        ->editColumn('action', function ($leaving_officer) {
            $button = "";

            $button .= '<a onclick="editLeaving('.$leaving_officer->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeLeaving('.$leaving_officer->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function leaving_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'left_date' => 'required',
            'designation_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $request->request->add(['created_by_user_id' => auth()->id()]);
        $request->request->add(['formn_id' => $statement->id]);
        $request->request->add(['left_at' => Carbon::createFromFormat('d/m/Y', $request->left_date)->toDateString()]);
        $leaving_officer = FormNLeaving::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pegawai yang Melepaskan Jawatan";
        $log->data_new = json_encode($leaving_officer);
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
    public function leaving_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Pegawai yang Melepaskan Jawatan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $leaving_officer = FormNLeaving::findOrFail($request->leaving_id);
        $designations = MasterDesignation::all();

        return view('finance.statement.ks.formn.tab4.edit', compact('leaving_officer','designations'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function leaving_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'left_date' => 'required',
            'designation_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $request->request->add(['left_at' => Carbon::createFromFormat('d/m/Y', $request->left_date)->toDateString()]);
        $leaving_officer = FormNLeaving::findOrFail($request->leaving_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pegawai yang Melepaskan Jawatan";
        $log->data_old = json_encode($leaving_officer);

        $leaving_officer->update($request->all());

        $log->data_new = json_encode($leaving_officer);
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
    public function leaving_delete(Request $request) {

        $leaving_officer = FormNLeaving::findOrFail($request->leaving_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Pegawai yang Melepaskan Jawatan";
        $log->data_old = json_encode($leaving_officer);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $leaving_officer->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //// START OFFICER APPOINTED CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function appointed_index(Request $request) {

        $officers = FormNAppointed::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Pegawai yang Dilantik";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($officers)
        ->editColumn('designation.name', function ($officer) {
            return $officer->designation ? $officer->designation->name : '';
        })
        ->editColumn('appointed_at', function ($officer) {
            return $officer->appointed_at ? date('d/m/Y', strtotime($officer->appointed_at)) : '-';
        })
        ->editColumn('action', function ($officer) {
            $button = "";

            $button .= '<a onclick="editAppointed('.$officer->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeAppointed('.$officer->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function appointed_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'occupation' => 'required|string',
            'designation_id' => 'required|integer',
            'birth_date' => 'required',
            'appointed_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create($request->all());
        $request->request->add(['address_id' => $address->id]);
        $request->request->add(['created_by_user_id' => auth()->id()]);
        $request->request->add(['formn_id' => $statement->id]);
        $request->request->add(['appointed_at' => Carbon::createFromFormat('d/m/Y', $request->appointed_date)->toDateString()]);        
        $request->request->add(['date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->birth_date)->toDateString()]);
        $officer = FormNAppointed::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pegawai yang Dilantik";
        $log->data_new = json_encode($officer);
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
    public function appointed_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Pegawai yang Dilantik";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $officer = FormNAppointed::findOrFail($request->appointed_id);
        $states = MasterState::all();
        $districts = MasterDistrict::all();
        $designations = MasterDesignation::all();

        return view('finance.statement.ks.formn.tab5.edit', compact('officer','states','designations','districts'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function appointed_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'occupation' => 'required|string',
            'designation_id' => 'required|integer',
            'birth_date' => 'required',
            'appointed_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $request->request->add(['appointed_at' => Carbon::createFromFormat('d/m/Y', $request->appointed_date)->toDateString()]);
        $request->request->add(['date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->birth_date)->toDateString()]);
        $officer = FormNAppointed::findOrFail($request->appointed_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pegawai yang Dilantik";
        $log->data_old = json_encode($officer);

        $officer->address()->update($request->all());
        $officer->update($request->all());

        $log->data_new = json_encode($officer);
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
    public function appointed_delete(Request $request) {

        $officer = FormNAppointed::findOrFail($request->appointed_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Pegawai yang Dilantik";
        $log->data_old = json_encode($officer);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $officer->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    //// START SEKURITI CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function security_index(Request $request) {

        $securities = FormNSecurity::where('formn_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Sekuriti";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($securities)
        ->editColumn('action', function ($security) {
            $button = "";

            $button .= '<a onclick="editSecurity('.$security->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeSecurity('.$security->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function security_insert(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
            'external_value' => 'required|numeric',
            'cost_value' => 'required|numeric',
            'market_value' => 'required|numeric',
            'cash' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['created_by_user_id' => auth()->id()]);
        $request->request->add(['formn_id' => $statement->id]);
        $security = FormNSecurity::create($request->all());

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 4;
        $log->description = "Tambah Security";
        $log->data_new = json_encode($security);
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
    public function security_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Sekuriti";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $security = FormNSecurity::findOrFail($request->security_id);

        return view('finance.statement.ks.formn.tab6.edit', compact('security'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function security_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
            'external_value' => 'required|numeric',
            'cost_value' => 'required|numeric',
            'market_value' => 'required|numeric',
            'cash' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $security = FormNSecurity::findOrFail($request->security_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Sekuriti";
        $log->data_old = json_encode($security);

        $security->update($request->all());

        $log->data_new = json_encode($security);
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
    public function security_delete(Request $request) {

        $security = FormNSecurity::findOrFail($request->security_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Sekuriti";
        $log->data_old = json_encode($security);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $security->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_index(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai (Lampiran) Penyata Kewangan Kesatuan - Dokumen Sokongan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attachments = [];

        foreach($statement->attachments as $attachment) {
            array_push($attachments, [
                'id' => $attachment->id,
                'name' => $attachment->name,
                'url' => route('general.getAttachment', ['attachment_id' => $attachment->id, 'filename' => $attachment->name]),
                'size' => Storage::disk('uploads')->size($attachment->url)
            ]);
        }

        return response()->json($attachments);
    }

    /**
     * Store resources into storage
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_insert(Request $request) {
        if($request->file('file')->isValid()) {
            $path = Storage::disk('uploads')->putFileAs(
                'formn',
                $request->file('file'),
                uniqid().'_'.$request->file('file')->getClientOriginalName()
            );

            $statement = FormN::findOrFail($request->id);

            $attachment = $statement->attachments()->create([
                'name' => $request->file('file')->getClientOriginalName(),
                'url' => $path,
                'created_by_user_id' => auth()->id()
            ]);

            $log = new LogSystem;
            $log->module_id = 26;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Lampiran) Penyata Kewangan Kesatuan - Dokumen Sokongan";
            $log->data_old = json_encode($request->input());
            $log->data_new = json_encode($attachment);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah disimpan.', 'id' => $attachment->id]);
        }
    }

    /**
     * Delete resources from storage
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_delete(Request $request) {
        $attachment = Attachment::findOrFail($request->attachment_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam (Lampiran) Penyata Kewangan Kesatuan - Dokumen Sokongan";
        $log->data_old = json_encode($attachment);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        Storage::disk('uploads')->delete($attachment->url);
        $attachment->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($statement, $target) {

        $check = $statement->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($statement->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormN')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $statement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $statement->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($statement->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormN')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $statement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $statement->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($statement, 'Serahan Penyata Tahunan Kesatuan'));
        }
        else if($target == "pw") {
            if($statement->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $statement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $statement->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($statement, 'Serahan Penyata Tahunan Kesatuan'));
        }
        else if($target == "pthq") {
            if($statement->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormN')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $statement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $statement->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($statement->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormN')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $statement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $statement->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($statement, 'Serahan Penyata Tahunan Kesatuan'));
        }
        else if($target == "pkpp") {
            if($statement->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $statement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $statement->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($statement, 'Serahan Penyata Tahunan Kesatuan'));
        }
        else if($target == "kpks") {
            if($statement->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $statement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $statement->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($statement, 'Serahan Penyata Tahunan Kesatuan'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Penyata Kewangan Kesatuan - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.ks.process.document-receive', $statement->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Penyata Kewangan Kesatuan - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $statement = FormN::findOrFail($request->id);

        $statement->filing_status_id = 3;
        $statement->save();

        $statement->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 26,
            ]
        );

        $statement->logs()->updateOrCreate(
            [
                'module_id' => 26,
                'activity_type_id' => 12,
                'filing_status_id' => $statement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($statement, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($statement, 'ppw');
            Mail::to($statement->created_by->email)->send(new Received(auth()->user(), $statement, 'Pengesahan Penerimaan Penyata Tahunan Kesatuan'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($statement, 'pphq');
            Mail::to($statement->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $statement, 'Pengesahan Penerimaan Penyata Tahunan Kesatuan'));
            Mail::to($statement->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $statement, 'Pengesahan Penerimaan Penyata Tahunan Kesatuan'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Penyata Kewangan Kesatuan - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.ks.process.query.item', $statement->id);
        $route2 = route('statement.ks.process.query', $statement->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $statement = FormN::findOrFail($request->id);

        if(count($statement->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Penyata Kewangan Kesatuan - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $statement->filing_status_id = 5;
        $statement->is_editable = 1;
        $statement->save();

        $log2 = $statement->logs()->updateOrCreate(
            [
                'module_id' => 26,
                'activity_type_id' => 13,
                'filing_status_id' => $statement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $statement->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $statement, 'Kuiri Permohonan Penyata Kewangan Kesatuan oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $statement->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $statement, 'Kuiri Permohonan Penyata Kewangan Kesatuan oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $statement->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $statement, 'Kuiri Permohonan Penyata Kewangan Kesatuan oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($statement->created_by->email)->send(new Queried(auth()->user(), $statement, 'Kuiri Permohonan Penyata Kewangan Kesatuan'));
        }

        $statement->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function process_query_item_list(Request $request) {
        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 26;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Penyata Kewangan Kesatuan - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $statement = FormN::findOrFail($request->id);

            $queries = $statement->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

            return datatables()->of($queries)
                ->editColumn('action', function ($query) {
                    $button = "";
                    $button .= '<a href="javascript:;" onclick="edit(this,'.$query->id.')" class="btn btn-success btn-xs" data-toggle="tooltip" title="Kemaskini"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a href="javascript:;" onclick="remove('.$query->id.')" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Padam"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->make(true);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_item_update(Request $request) {

        $statement = FormN::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 26;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Penyata Kewangan Kesatuan - Kuiri";
            $log->data_old = json_encode($query);

            $query->update([
                'content' => $request->content
            ]);

            $log->data_new = json_encode($query);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
        }
        else {
            $query = $statement->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 26;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Penyata Kewangan Kesatuan - Kuiri";
            $log->data_new = json_encode($query);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah disimpan.']);
        }


    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_item_delete(Request $request) {
        $query = Query::findOrFail($request->query_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Penyata Kewangan Kesatuan - Kuiri";
        $log->data_old = json_encode($query);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $query->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_edit(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Penyata Kewangan Kesatuan - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $statement->logs()->where('activity_type_id',14)->where('filing_status_id', $statement->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('statement.ks.process.recommend', $statement->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Penyata Kewangan Kesatuan - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $statement = FormN::findOrFail($request->id);
        $statement->filing_status_id = 6;
        $statement->is_editable = 0;
        $statement->save();

        $statement->logs()->updateOrCreate(
            [
                'module_id' => 26,
                'activity_type_id' => 14,
                'filing_status_id' => $statement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($statement, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($statement, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($statement, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($statement->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $statement, 'Serahan Penyata Tahunan Kesatuan'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Penyata Kewangan Kesatuan - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.ks.process.delay', $statement->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Penyata Kewangan Kesatuan - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $statement = FormN::findOrFail($request->id);
        $statement->filing_status_id = 7;
        $statement->is_editable = 0;
        $statement->save();

        $statement->logs()->updateOrCreate(
            [
                'module_id' => 26,
                'activity_type_id' => 15,
                'filing_status_id' => $statement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_status_edit(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Penyata Kewangan Kesatuan - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.ks.process.status', $statement->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Penyata Kewangan Kesatuan - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $statement = FormN::findOrFail($request->id);

        $log = $statement->logs()->create([
                'module_id' => 26,
                'activity_type_id' => 20,
                'filing_status_id' => $statement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id,
                'data' => $request->status_data,
        ]);

        $log->created_at = Carbon::createFromFormat('d/m/Y', $request->status_date)->toDateTimeString();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result(Request $request) {

        $form = $statement = FormN::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Penyata Kewangan Kesatuan - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("statement.ks.process.result.reject", $form->id);
        $route_approve = route("statement.ks.process.result.approve", $form->id);
        $route_delay = route("statement.ks.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Penyata Kewangan Kesatuan - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.ks.process.result.approve', $statement->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Penyata Kewangan Kesatuan - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $statement = FormN::findOrFail($request->id);
        $statement->filing_status_id = 9;
        $statement->is_editable = 0;
        $statement->save();

        $statement->logs()->updateOrCreate(
            [
                'module_id' => 26,
                'activity_type_id' => 16,
                'filing_status_id' => $statement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($statement->created_by->email)->send(new ApprovedKS($statement, 'Status Penyata Tahunan Kesatuan'));

        Mail::to($statement->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($statement, 'Status Penyata Tahunan Kesatuan'));
        Mail::to($statement->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($statement, 'Status Penyata Tahunan Kesatuan'));
        Mail::to($statement->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($statement, 'Status Penyata Tahunan Kesatuan'));
        Mail::to($statement->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($statement, 'Sedia Dokumen Kelulusan Penyata Tahunan Kesatuan'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $statement = FormN::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Penyata Kewangan Kesatuan - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.ks.process.result.reject', $statement->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Penyata Kewangan Kesatuan - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $statement = FormN::findOrFail($request->id);
        $statement->filing_status_id = 8;
        $statement->is_editable = 0;
        $statement->save();

        $statement->logs()->updateOrCreate(
            [
                'module_id' => 26,
                'activity_type_id' => 16,
                'filing_status_id' => $statement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($statement->created_by->email)->send(new Rejected($statement, 'Status Penyata Tahunan Kesatuan'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function download(Request $request) {

        $filing = FormN::findOrFail($request->id); 
        $male = $filing->male_malay + $filing->male_chinese + $filing->male_indian + $filing->male_others;
        $female = $filing->female_malay + $filing->female_chinese + $filing->female_indian + $filing->female_others;
        $signed_by = $filing->tenure->officers()->where('designation_id', 5)->first();

        $salary = $filing->salaries()->sum('total');
        $loan = $filing->loans()->sum('total');
        $lent = $filing->lents()->sum('total');
        $bank = $filing->banks()->sum('total');
        $cash = $filing->cash()->sum('total');
        $debt = $filing->debts()->sum('total');
        $liability = $filing->liabilities()->sum('total');
        $expenditure = $filing->expenditures()->sum('total');

        $total_accept = $filing->accept_balance_start + $filing->accept_entrance_fee + $filing->accept_membership_fee + $filing->accept_sponsorship + $filing->accept_sales + $filing->accept_interest + $salary;

        $total_pay = $filing->pay_officer_salary + $filing->pay_organization_salary + $filing->pay_auditor_fee + $filing->pay_attorney_expenditure + $filing->pay_tred_expenditure + $filing->pay_compensation + $filing->pay_sick_benefit + $filing->pay_study_benefit + $filing->pay_publication_cost + $filing->pay_rental + $filing->pay_stationary + $filing->pay_balance_end + $expenditure;

        $total_liability = $filing->liability_fund + $lent + $debt + $liability;

        $total_asset = $filing->asset_security + $filing->asset_property_total + $filing->asset_furniture + $filing->other_asset_total + $cash + $bank + $lent;

        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->tenure->entity->name),
            'entity_address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ', '.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars($filing->address->address3) : '').
                ', '.($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars($filing->address->district->name) : '').
                ($filing->address->state ? ', '.htmlspecialchars($filing->address->state->name) : ''),
            'registration_no' => htmlspecialchars($filing->tenure->entity->registration_no),
            'year' => htmlspecialchars($filing->year),
            'total_member_start' => htmlspecialchars($filing->total_member_start),
            'total_member_accepted' => htmlspecialchars($filing->total_member_accepted),
            'total_member_leave' => htmlspecialchars($filing->total_member_leave), 
            'total_member_end' => htmlspecialchars($filing->total_member_end),
            'total_male' => htmlspecialchars($filing->total_male), 
            'total_female' => htmlspecialchars($filing->total_female),
            'male_malay' => htmlspecialchars($filing->male_malay),
            'male_chinese' => htmlspecialchars($filing->male_chinese), 
            'male_indian' => htmlspecialchars($filing->male_indian),
            'male_others' => htmlspecialchars($filing->male_others),
            'male' => htmlspecialchars($male), 
            'female_malay' => htmlspecialchars($filing->female_malay),
            'female_chinese' => htmlspecialchars($filing->female_chinese), 
            'female_indian' => htmlspecialchars($filing->female_indian),
            'female_others' => htmlspecialchars($filing->female_others),
            'female' => htmlspecialchars($female),             
            'duration' => htmlspecialchars($filing->duration),
            'today_day' => htmlspecialchars(strftime('%e')), 
            'today_month_year' => htmlspecialchars(strftime('%B %Y')),
            'accept_balance_start' => htmlspecialchars($filing->accept_balance_start),
            'accept_entrance_fee' => htmlspecialchars($filing->accept_entrance_fee), 
            'accept_membership_fee' => htmlspecialchars($filing->accept_membership_fee),
            'accept_sponsorship' => htmlspecialchars($filing->accept_sponsorship),
            'accept_sales' => htmlspecialchars($filing->accept_sales),
            'accept_interest' => htmlspecialchars($filing->accept_interest), 
            'total_accept' => htmlspecialchars($total_accept),
            'pay_officer_salary' => htmlspecialchars($filing->pay_officer_salary),
            'pay_organization_salary' => htmlspecialchars($filing->pay_organization_salary),
            'pay_auditor_fee' => htmlspecialchars($filing->pay_auditor_fee),
            'pay_attorney_expenditure' => htmlspecialchars($filing->pay_attorney_expenditure), 
            'pay_tred_expenditure' => htmlspecialchars($filing->pay_tred_expenditure),
            'pay_compensation' => htmlspecialchars($filing->pay_compensation),
            'pay_sick_benefit' => htmlspecialchars($filing->pay_sick_benefit),
            'pay_study_benefit' => htmlspecialchars($filing->pay_study_benefit),
            'pay_publication_cost' => htmlspecialchars($filing->pay_publication_cost),
            'pay_rental' => htmlspecialchars($filing->pay_rental), 
            'pay_stationary' => htmlspecialchars($filing->pay_stationary),
            'pay_balance_end' => htmlspecialchars($filing->pay_balance_end),
            'total_pay' => htmlspecialchars($total_pay),
            'liability_fund' => htmlspecialchars($filing->liability_fund),
            'total_liability' => htmlspecialchars($total_liability),
            'asset_security' => htmlspecialchars($filing->asset_security), 
            'asset_property' => htmlspecialchars($filing->asset_property),
            'property_total' => htmlspecialchars($filing->asset_property_total),
            'asset_furniture' => htmlspecialchars($filing->asset_furniture),
            'other_asset' => htmlspecialchars($filing->other_asset), 
            'other_asset_total' => htmlspecialchars($filing->other_asset_total),
            'total_asset' => htmlspecialchars($total_asset),
            'signed_name' => $signed_by ? htmlspecialchars($signed_by->name) : '',
            'designation_signed' => htmlspecialchars('Bendahari'),
            'signed_state' => $filing->state ? htmlspecialchars($filing->state->name) : '', 
            'signed_district' => $filing->district ? htmlspecialchars($filing->district->name) : '',
            'signed_day' => htmlspecialchars(strftime('%e', strtotime($filing->signed_at))), 
            'signed_month_year' => htmlspecialchars(strftime('%B %Y', strtotime($filing->signed_at))),
        ];

        $log = new LogSystem;
        $log->module_id = 26;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/finance/bn1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

         // Generate table debt
        $rows10 = $filing->banks;
        $document->cloneRow('bank_name', count($rows10));

        foreach($rows10 as $index => $row10) {

            $document->setValue('bank_name#'.($index+1), htmlspecialchars(strtoupper($row10->name)));
            $document->setValue('bank_total#'.($index+1), htmlspecialchars($row10->total));
        }

         // Generate table cash
        $rows9 = $filing->cash;
        $document->cloneRow('hand_name', count($rows9));

        foreach($rows9 as $index => $row9) {

            $document->setValue('hand_name#'.($index+1), htmlspecialchars(strtoupper($row9->name)));
            $document->setValue('hand_total#'.($index+1), htmlspecialchars($row9->total));
        }

        // Generate table debt
        $rows8 = $filing->debts;
        $document->cloneRow('debt_name', count($rows8));

        foreach($rows8 as $index => $row8) {

            $document->setValue('debt_name#'.($index+1), htmlspecialchars(strtoupper($row8->name)));
            $document->setValue('debt_total#'.($index+1), htmlspecialchars($row8->total));
        }

        // Generate table liability
        $rows7 = $filing->liabilities;
        $document->cloneRow('liability_name', count($rows7));

        foreach($rows7 as $index => $row7) {

            $document->setValue('liability_name#'.($index+1), htmlspecialchars(strtoupper($row7->name)));
            $document->setValue('liability_total#'.($index+1), htmlspecialchars($row7->total));
        }

        // Generate table loan
        $rows7 = $filing->loans;
        $document->cloneRow('loan_name', count($rows7));

        foreach($rows7 as $index => $row7) {

            $document->setValue('loan_name#'.($index+1), htmlspecialchars(strtoupper($row7->name)));
            $document->setValue('loan_total#'.($index+1), htmlspecialchars($row7->total));
        }

        // Generate table lent
        $rows6 = $filing->lents;
        $document->cloneRow('lent_name', count($rows6));

        foreach($rows6 as $index => $row6) {

            $document->setValue('lent_name#'.($index+1), htmlspecialchars(strtoupper($row6->name)));
            $document->setValue('lent_total#'.($index+1), htmlspecialchars($row6->total));
        }

        // Generate table salary
        $rows5 = $filing->salaries;
        $document->cloneRow('salary_name', count($rows5));

        foreach($rows5 as $index => $row5) {

            $document->setValue('salary_name#'.($index+1), htmlspecialchars(strtoupper($row5->name)));
            $document->setValue('salary_total#'.($index+1), htmlspecialchars($row5->total));
        }

        // Generate table expenditure
        $rows4 = $filing->expenditures;
        $document->cloneRow('expenditure_name', count($rows4));

        foreach($rows4 as $index => $row4) {

            $document->setValue('expenditure_name#'.($index+1), htmlspecialchars(strtoupper($row4->name)));
            $document->setValue('expenditure_total#'.($index+1), htmlspecialchars($row4->total));
        }

         // Generate table leaving officer
        $rows3 = $filing->officers;
        $document->cloneRow('officer_name', count($rows3));

        foreach($rows3 as $index => $row3) {
        $address = htmlspecialchars($row3->address->address1).
                ($row3->address->address2 ? ', '.htmlspecialchars($row3->address->address2) : '').
                ($row3->address->address3 ? ', '.htmlspecialchars($row3->address->address3) : '').
                ', '.($row3->address->postcode).
                ($row3->address->district ? ' '.htmlspecialchars($row3->address->district->name) : '').
                ($row3->address->state ? ', '.htmlspecialchars($row3->address->state->name) : '');

            $document->setValue('officer_name#'.($index+1), htmlspecialchars(strtoupper($row3->name)));
            $document->setValue('officer_address#'.($index+1), htmlspecialchars(strtoupper($address)));
            $document->setValue('officer_designation#'.($index+1), $row3->designation ? htmlspecialchars(strtoupper($row3->designation->name)): '');
            $document->setValue('officer_dob#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row3->date_of_birth))));
            $document->setValue('officer_occupation#'.($index+1), htmlspecialchars(strtoupper($row3->occupation)));
            $document->setValue('officer_appointed_at#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row3->appointed_at))));
        }

         // Generate table leaving officer
        $rows2 = $filing->leaving_officers;
        $document->cloneRow('leaving_name', count($rows2));

        foreach($rows2 as $index => $row2) {

            $document->setValue('leaving_name#'.($index+1), htmlspecialchars(strtoupper($row2->name)));
            $document->setValue('leaving_designation#'.($index+1), $row2->designation ? htmlspecialchars(strtoupper($row2->designation->name)): '');
            $document->setValue('leaving_at#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row2->left_at))));
        }

        // Generate table security
        $rows = $filing->securities;
        $document->cloneRow('description', count($rows));

        foreach($rows as $index => $row) {

            $document->setValue('description#'.($index+1), htmlspecialchars(strtoupper($row->description)));
            $document->setValue('external_value#'.($index+1), htmlspecialchars(strtoupper($row->external_value)));
            $document->setValue('market_value#'.($index+1), htmlspecialchars(strtoupper($row->market_value)));
            $document->setValue('cost_value#'.($index+1), htmlspecialchars(strtoupper($row->cost_value)));
            $document->setValue('cash#'.($index+1), htmlspecialchars(strtoupper($row->cash)));
        }
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang BN1';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
