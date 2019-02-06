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
use App\Mail\FormJL1\ApprovedKS;
use App\Mail\FormJL1\ApprovedPWN;
use App\Mail\FormJL1\Rejected;
use App\Mail\FormJL1\Sent;
use App\Mail\FormJL1\NotReceived;
use App\Mail\FormJL1\DocumentApproved;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\Query;
use App\FilingModel\FormJL1;
use App\FilingModel\FormJL1FormN;
use App\FilingModel\FormN;
use App\MasterModel\MasterState;
use App\OtherModel\Address;
use App\UserStaff;
use App\User;
use Validator;
use Carbon\Carbon;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class FormJL1Controller extends Controller
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
            $log->module_id = 25;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang Juruaudit Luar";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $auditors = FormJL1::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $auditors = $auditors->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $auditors = $auditors->where('filing_status_id', '>', 1)->where(function($auditors) {
                    return $auditors->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($auditors){
                        if(auth()->user()->hasRole('ptw'))
                            return $auditors->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $auditors->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $auditors = $auditors->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($auditors)
                ->editColumn('tenure.entity.name', function ($auditor) {
                    return $auditor->tenure->entity->name;
                })
                ->editColumn('entity_type', function ($auditor) {
                    return $auditor->tenure->entity_type == "App\\UserUnion" ? 'Kesatuan' : 'Persekutuan';
                })
                ->editColumn('applied_at', function ($auditor) {
                    return $auditor->applied_at ? date('d/m/Y', strtotime($auditor->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($auditor) {
                    if($auditor->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$auditor->status->name.'</span>';
                    else if($auditor->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$auditor->status->name.'</span>';
                    else if($auditor->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$auditor->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$auditor->status->name.'</span>';
                })
                ->editColumn('letter', function($auditor) {
                    $result = "";
                    if($auditor->filing_status_id == 9){
                        $result .= letterButton(43, get_class($auditor), $auditor->id);
                        $result .= letterButton(45, get_class($auditor), $auditor->id);
                    }
                    elseif($auditor->filing_status_id == 8){
                        $result .= letterButton(44, get_class($auditor), $auditor->id);
                        $result .= letterButton(46, get_class($auditor), $auditor->id);
                    }
                    return $result;
                })
                ->editColumn('action', function ($auditor) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($auditor)).'\','.$auditor->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $auditor->is_editable)) && $auditor->filing_status_id < 7)
                        $button .= '<a href="'.route('statement.audit.form', $auditor->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    // if(auth()->user()->hasRole('ptw') && $auditor->filing_status_id < 7)
                    //     $button .= '<a onclick="uploadData(1)" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-upload mr-1"></i> Muat Naik Dokumen</a><br>';
                    
                    if( ((auth()->user()->hasRole('ptw') && $auditor->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $auditor->distributions->count() == 3)) && $auditor->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$auditor->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp','pkpg','kpks']) && $auditor->filing_status_id < 8)
                        $button .= '<a onclick="query('.$auditor->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pphq', 'pkpg', 'pkpp']) && $auditor->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$auditor->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('pw') && $auditor->filing_status_id < 8)
                        $button .= '<a onclick="pw_process('.$auditor->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $auditor->filing_status_id < 8)
                        $button .= '<a onclick="process('.$auditor->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 25;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang Juruaudit Luar";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }
        return view('finance.statement.audit.list');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $address = Address::create([]);
        $auditor = FormJL1::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'firm_address_id' => $address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $errors_jl1 = count(($this->getErrors($auditor))['jl1']);

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Juruaudit Luar";
        $log->data_new = json_encode($auditor);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('finance.statement.audit.index', compact('auditor','errors_jl1'));
    }

    public function pdf(Request $request) {
        
        $formjl1 = FormJL1::findOrFail($request->id);
        $formjl1_formn = FormJL1FormN::where('formjl1_id', $request->id)->get();
        $data = [
            'formjl1' => $formjl1,
            'formjl1_formn' => $formjl1_formn,
        ];

        if($request->form == 'formjl1'){
            $pdf = PDF::loadView('pdf.finance-statement.formjl1', $data);  
            return $pdf->setPaper('A4')->setOrientation('portrait')->download('formjl1.pdf');
        }

        else return 'ddd';        

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $auditor = FormJL1::findOrFail($request->id);

        $errors_jl1 = count(($this->getErrors($auditor))['jl1']);

        return view('finance.statement.audit.index', compact('auditor','errors_jl1'));
    }

    private function getErrors($auditor) {

        $errors = [];

        if(!$auditor) {
            $errors['jl1'] = [null,null,null,null,null,null,null,null];
        }
        else {
            $errors_jl1 = [];

            $validate_jl1 = Validator::make($auditor->toArray(), [
                'firm_name' => 'required|string',
                'firm_registration_no' => 'required|string',
                'auditor_name' => 'required|string',
                'auditor_identification_no' => 'required|string',
            ]);

            if ($validate_jl1->fails())
                $errors_jl1 = array_merge($errors_jl1, $validate_jl1->errors()->toArray());

            $validate_address = Validator::make($auditor->firm_address->toArray(), [
                'address1' => 'required|string',
                'postcode' => 'required|digits:5',
                'district_id' => 'required|integer',
                'state_id' => 'required|integer',
            ]);

            if ($validate_address->fails())
                $errors_jl1 = array_merge($errors_jl1, $validate_address->errors()->toArray());

            $errors['jl1'] = $errors_jl1;
        }

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $auditor = FormJL1::findOrFail($request->id);

        $error_list = $this->getErrors($auditor);
        $errors = count($error_list['jl1']);

        // return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 25;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang Juruaudit Luar";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $auditor->filing_status_id = 2;
            $auditor->is_editable = 0;
            $auditor->save();

            $auditor->logs()->updateOrCreate(
                [
                    'module_id' => 25,
                    'activity_type_id' => 11,
                    'filing_status_id' => $auditor->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' =>  auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $auditor->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 25,
            ]);

            Mail::to($auditor->created_by->email)->send(new Sent($auditor, 'Penyata Kewangan (Juruaudit Luar)'));

            // if($auditor->logs->count() == 1)
            //     $this->distribute($auditor, 'ptw');

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan anda telah dihantar.']);
        }
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function formjl1_index(Request $request) {

        $auditor = FormJL1::findOrFail($request->id);
        $states = MasterState::all();
        $prior_formns = FormN::whereHas('tenure', function($tenure) {
            return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
        });

        $prior_formns = $prior_formns->get();

        return view('finance.statement.audit.formjl1', compact('auditor', 'states','prior_formns'));
    }
    
    //// START LOAN CRUD //////////////////////////////////

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function formn_index(Request $request) {

        $old_formns = FormJL1FormN::where('formjl1_id', $request->id);

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang Juruaudit Luar - Butiran Borang N Lepas";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return datatables()->of($old_formns)
        ->editColumn('year', function ($old_formn) {
            return $old_formn->formn->tenure->formjl1->last()->year ;
        })
        ->editColumn('auditor_name', function ($old_formn) {
            return $old_formn->formn->tenure->formjl1->last()->auditor_name ;
        })
        ->editColumn('action', function ($old_formn) {
            $button = "";

            $button .= '<a onclick="edit('.$old_formn->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="remove('.$old_formn->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function formn_insert(Request $request) {

        $formjl1 = FormJL1::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'formn_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['formjl1_id' => $formjl1->id]);
        $old_formn = FormJL1FormN::create($request->all());

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 4;
        $log->description = "Tambah Juruaudit Luar - Butiran Borang N Lepas";
        $log->data_new = json_encode($old_formn);
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
    public function formn_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang Juruaudit Luar - Butiran Borang N Lepas";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $old_formn = FormJL1FormN::findOrFail($request->formn_id);

        return view('finance.statement.audit.year.edit', compact('old_formn'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function formn_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'formn_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $old_formn = FormJL1FormN::findOrFail($request->formn_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang Juruaudit Luar - Butiran Borang N Lepas";
        $log->data_old = json_encode($old_formn);

        $old_formn->update($request->all());

        $log->data_new = json_encode($old_formn);
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
    public function formn_delete(Request $request) {

        $old_formn = FormJL1FormN::findOrFail($request->formn_id);

        $log = new LogSystem;
        $log->module_id = 26;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang Juruaudit Luarorang Juruaudit Luar - Butiran Borang N Lepas";
        $log->data_old = json_encode($old_formn);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $old_formn->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($auditor, $target) {

        $check = $auditor->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($auditor->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormJL1')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $auditor->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $auditor->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($auditor->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormJL1')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $auditor->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $auditor->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($auditor, 'Serahan Penyata Kewangan (Juruaudit Luar)'));
        }
        else if($target == "pw") {
            if($auditor->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $auditor->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $auditor->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($auditor, 'Serahan Penyata Kewangan (Juruaudit Luar)'));
        }
        else if($target == "pthq") {
            if($auditor->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormJL1')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $auditor->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $auditor->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($auditor->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormJL1')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $auditor->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $auditor->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($auditor, 'Serahan Penyata Kewangan (Juruaudit Luar)'));
        }
        else if($target == "pkpp") {
            if($auditor->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $auditor->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $auditor->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($auditor, 'Serahan Penyata Kewangan (Juruaudit Luar)'));
        }
        else if($target == "kpks") {
            if($auditor->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $auditor->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $auditor->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($auditor, 'Serahan Penyata Kewangan (Juruaudit Luar)'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $auditor = FormJL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang Juruaudit Luar - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.audit.process.document-receive', $auditor->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang Juruaudit Luar - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $auditor = FormJL1::findOrFail($request->id);

        $auditor->filing_status_id = 3;
        $auditor->save();

        $auditor->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 25,
            ]
        );

        $auditor->logs()->updateOrCreate(
            [
                'module_id' => 25,
                'activity_type_id' => 12,
                'filing_status_id' => $auditor->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($auditor, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($auditor, 'ppw');
            Mail::to($auditor->created_by->email)->send(new Received(auth()->user(), $auditor, 'Pengesahan Penerimaan Penyata Kewangan (Juruaudit Luar)'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($auditor, 'pphq');
            Mail::to($auditor->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $auditor, 'Pengesahan Penerimaan Penyata Kewangan (Juruaudit Luar)'));
            Mail::to($auditor->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $auditor, 'Pengesahan Penerimaan Penyata Kewangan (Juruaudit Luar)'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $auditor = FormJL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang Juruaudit Luar - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.audit.process.query.item', $auditor->id);
        $route2 = route('statement.audit.process.query', $auditor->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $auditor = FormJL1::findOrFail($request->id);

        if(count($auditor->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang Juruaudit Luar - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $auditor->filing_status_id = 5;
        $auditor->is_editable = 1;
        $auditor->save();

        $log2 = $auditor->logs()->updateOrCreate(
            [
                'module_id' => 25,
                'activity_type_id' => 13,
                'filing_status_id' => $auditor->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $auditor->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $auditor, 'Kuiri Penyata Kewangan (Juruaudit Luar) oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $auditor->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $auditor, 'Kuiri Penyata Kewangan (Juruaudit Luar) oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $auditor->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $auditor, 'Kuiri Penyata Kewangan (Juruaudit Luar) oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($auditor->created_by->email)->send(new Queried(auth()->user(), $auditor, 'Kuiri Penyata Kewangan (Juruaudit Luar)'));
        }

        $auditor->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 25;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang Juruaudit Luar - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $auditor = FormJL1::findOrFail($request->id);

            $queries = $auditor->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $auditor = FormJL1::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 25;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang Juruaudit Luar - Kuiri";
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
            $query = $auditor->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 25;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang Juruaudit Luar - Kuiri";
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
        $log->module_id = 25;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang Juruaudit Luar - Kuiri";
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

        $auditor = FormJL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang Juruaudit Luar - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $auditor->logs()->where('activity_type_id',14)->where('filing_status_id', $auditor->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('statement.audit.process.recommend', $auditor->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang Juruaudit Luar - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $auditor = FormJL1::findOrFail($request->id);
        $auditor->filing_status_id = 6;
        $auditor->is_editable = 0;
        $auditor->save();

        $auditor->logs()->updateOrCreate(
            [
                'module_id' => 25,
                'activity_type_id' => 14,
                'filing_status_id' => $auditor->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($auditor, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($auditor, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($auditor, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($auditor->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $auditor, 'Serahan Penyata Kewangan (Juruaudit Luar)'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $auditor = FormJL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang Juruaudit Luar - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.audit.process.delay', $auditor->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang Juruaudit Luar - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $auditor = FormJL1::findOrFail($request->id);
        $auditor->filing_status_id = 7;
        $auditor->is_editable = 0;
        $auditor->save();

        $auditor->logs()->updateOrCreate(
            [
                'module_id' => 25,
                'activity_type_id' => 15,
                'filing_status_id' => $auditor->filing_status_id,
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
    public function process_result(Request $request) {

        $form = $auditor = FormJL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang Juruaudit Luar - Keputusan KPKS";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("statement.audit.process.result.reject", $form->id);
        $route_approve = route("statement.audit.process.result.approve", $form->id);
        $route_delay = route("statement.audit.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $auditor = FormJL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang Juruaudit Luar - KPKS Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.audit.process.result.approve', $auditor->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang Juruaudit Luar - KPKS Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $auditor = FormJL1::findOrFail($request->id);
        $auditor->filing_status_id = 9;
        $auditor->is_editable = 0;
        $auditor->save();

        $auditor->logs()->updateOrCreate(
            [
                'module_id' => 25,
                'activity_type_id' => 16,
                'filing_status_id' => $auditor->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($auditor->created_by->email)->send(new ApprovedKS($auditor, 'Status Penyata Kewangan (Juruaudit Luar)'));

        if(auth()->user()->entity->role->name != 'pw') {
            Mail::to($auditor->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($auditor, 'Status Penyata Kewangan (Juruaudit Luar)'));
            Mail::to($auditor->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($auditor, 'Status Penyata Kewangan (Juruaudit Luar)'));
            Mail::to($auditor->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($auditor, 'Status Penyata Kewangan (Juruaudit Luar)'));
            Mail::to($auditor->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($auditor, 'Sedia Dokumen Kelulusan Penyata Kewangan (Juruaudit Luar)'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $auditor = FormJL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang Juruaudit Luar - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('statement.audit.process.result.reject', $auditor->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang Juruaudit Luar - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $auditor = FormJL1::findOrFail($request->id);
        $auditor->filing_status_id = 8;
        $auditor->is_editable = 0;
        $auditor->save();

        $auditor->logs()->updateOrCreate(
            [
                'module_id' => 25,
                'activity_type_id' => 16,
                'filing_status_id' => $auditor->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($auditor->created_by->email)->send(new Rejected($auditor, 'Status Penyata Kewangan (Juruaudit Luar)'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_pw_result(Request $request) {

        $form = $auditor = FormJL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 25;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang Juruaudit Luar - Keputusan PW";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("statement.audit.process.result.reject", $form->id);
        $route_approve = route("statement.audit.process.result.approve", $form->id);
        $route_recommend = route("statement.audit.process.recommend", $form->id);

        return view('general.modal.result-jl1', compact('route_reject','route_approve','route_recommend'));
    }

    public function download(Request $request) {

        $filing = FormJL1::findOrFail($request->id); 
                                                             // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->tenure->entity->name),
            'registration_no' => htmlspecialchars($filing->tenure->entity->registration_no),
            'firm_name' => htmlspecialchars($filing->firm_name),
            'firm_registration_no' => htmlspecialchars($filing->firm_registration_no),
            'firm_address' => $filing->firm_address ?
                (htmlspecialchars(ucwords($filing->firm_address->address1)).
                ($filing->firm_address->address2 ? ', '.htmlspecialchars(ucwords($filing->firm_address->address2)) : '').
                ($filing->firm_address->address3 ? ', '.htmlspecialchars(ucwords($filing->firm_address->address3)) : '').
                ', '.htmlspecialchars($filing->firm_address->postcode).
                ($filing->firm_address->district ? ' '.htmlspecialchars(ucwords($filing->firm_address->district->name)) : '').
                ($filing->firm_address->state ? ', '.htmlspecialchars(ucwords($filing->firm_address->state->name)) : '')): '',
            'auditor_name' => htmlspecialchars(ucwords($filing->auditor_name)),
            'identification_no' => htmlspecialchars($filing->auditor_identification_no), 
        ];

        $log = new LogSystem;
        $log->module_id = 25;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/finance/jl1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table requester
        $rows = FormJL1FormN::where('formjl1_id', $request->id)->get();
        $document->cloneRow('audit_year', count($rows));

        foreach($rows as $index => $row) {
            if($index == 0)
                $document->setValue('label#'.($index+1), 'TAHUN AUDIT:');
            else
                $document->setValue('label#'.($index+1), '');

            $document->setValue('audit_year#'.($index+1), htmlspecialchars(strtoupper($row->year)));
        }
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang JL1';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
