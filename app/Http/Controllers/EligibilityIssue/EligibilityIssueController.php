<?php

namespace App\Http\Controllers\EligibilityIssue;

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
use App\Mail\EligibilityIssue\ResultKPPPM;
use App\Mail\EligibilityIssue\Sent;
use App\Mail\EligibilityIssue\NotReceived;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\EligibilityIssue;
use App\FilingModel\FormA;
use App\OtherModel\Address;
use App\FilingModel\Query;
use App\User;
use App\UserUnion;
use App\UserFederation;
use App\UserStaff;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;

class EligibilityIssueController extends Controller
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
            $log->module_id = 34;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang Isu Kelayakan";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $eligibilities = EligibilityIssue::with(['entity','status']);//->where('filing_status_id', '>', 1);

            if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $eligibilities = $eligibilities->where('filing_status_id', '>', 1)->where(function($eligibility) {
                    return $eligibility->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($eligibility){
                        if(auth()->user()->hasRole('ptw'))
                            return $eligibility->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $eligibility->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                })->orWhere('created_by_user_id', auth()->id());
            }
            else {
                $eligibilities = $eligibilities->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }
            
            return datatables()->of($eligibilities)
                ->editColumn('entity.name', function ($eligibility) {
                    return $eligibility->entity ? $eligibility->entity->name : '';
                })
                ->editColumn('entity_type', function ($eligibility) {
                    return $eligibility->entity_type == "App\\UserUnion" ? 'Kesatuan' : 'Persekutuan';
                })
                ->editColumn('investigation_date', function ($eligibility) {
                    return '';
                })
                ->editColumn('status.name', function ($eligibility) {
                    if($eligibility->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$eligibility->status->name.'</span>';
                    else if($eligibility->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$eligibility->status->name.'</span>';
                    else if($eligibility->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$eligibility->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$eligibility->status->name.'</span>';
                })
                ->editColumn('letter', function($eligibility) {
                    $result = "";
                    if($eligibility->filing_status_id > 2  ){
                        $result .= letterButton(64, get_class($eligibility), $eligibility->id);
                        $result .= letterButton(68, get_class($eligibility), $eligibility->id);
                    }
                    if($eligibility->filing_status_id == 8 || $eligibility->filing_status_id == 9 )
                        $result .= letterButton(66, get_class($eligibility), $eligibility->id);
                    if($eligibility->filing_status_id == 9)
                        $result .= letterButton(62, get_class($eligibility), $eligibility->id);
                    if($eligibility->filing_status_id == 8)
                        $result .= letterButton(63, get_class($eligibility), $eligibility->id);
                    if($eligibility->filing_status_id > 7)
                        $result .= letterButton(78, get_class($eligibility), $eligibility->id);
                    return $result;
                })
                ->editColumn('action', function ($eligibility) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($eligibility)).'\','.$eligibility->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    // if(auth()->user()->hasRole('ks'))
                    //     $button .= '<a onclick="retractData(1)" href="javascript:;" class="btn btn-danger btn-xs mb-1"><i class="fa fa-times mr-1"></i> Tarik Balik</a><br>';

                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->id() == $eligibility->created_by_user_id && $eligibility->is_editable)) && $eligibility->filing_status_id < 7)
                        $button .= '<a href="'.route('eligibility-issue.form', $eligibility->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';

                    if( ((auth()->user()->hasRole('ptw') && $eligibility->distributions->count() == 1) || (auth()->user()->hasRole('pthq') && $eligibility->distributions->count() == 4)) && $eligibility->filing_status_id < 7 && $eligibility->filing_status_id > 1 )
                        $button .= '<a onclick="receive('.$eligibility->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';

                    if(auth()->user()->hasAnyRole(['pw','pkpg','kpks']) && $eligibility->filing_status_id < 8)
                        $button .= '<a onclick="query('.$eligibility->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';

                    if(auth()->user()->hasAnyRole(['pw','ppw']) && $eligibility->filing_status_id < 7)
                        $button .= '<a onclick="report('.$eligibility->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Laporan</a><br>';

                    if(auth()->user()->hasAnyRole(['pw','ppw','pphq', 'pkpg']) && $eligibility->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$eligibility->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';

                    if(auth()->user()->hasRole('kpks') && $eligibility->filing_status_id < 8)
                        $button .= '<a onclick="process('.$eligibility->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    // if(auth()->user()->hasRole('pthq'))
                    //  $button .= '<a onclick="jppmData('.$eligibility->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Syor JPPM</a><br>';
                    return $button;
                })
                ->make(true);

        }
        else {
            $log = new LogSystem;
            $log->module_id = 34;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang Isu Kelayakan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('eligibility-issue.list');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
        $eligibility = EligibilityIssue::create([
            'created_by_user_id' => auth()->id(),
        ]);

        $address = Address::create([]);

        $forma = FormA::create([
            'eligibility_issue_id' => $eligibility->id,
            'company_address_id' => $address->id,
            'applied_at' => Carbon::now(),
        ]);

        $letter = \App\OtherModel\Letter::create([
            'letter_type_id' => 64,
            'module_id' => 34,
            'filing_type' => get_class($eligibility),
            'filing_id' => $eligibility->id,
            'entity_type' => 'App\\UserStaff',
            'entity_id' => auth()->id(),
            'created_by_user_id' => auth()->id(),
        ]);

        $error_list = $this->getErrors($eligibility);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Isu Kelayakan";
        $log->data_new = json_encode($eligibility);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('eligibility-issue.index', compact('eligibility', 'error_list'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $error_list = $this->getErrors($eligibility);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan (Kemaskini) Borang Isu Kelayakan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('eligibility-issue.index', compact('eligibility','error_list'));
    }

    private function getErrors($eligibility) {

        $errors = [];

        if(!$eligibility->forma) {
            $errors['forma'] = [null,null,null,null,null,null,null,null];
        }
        else {
            $errors_a = [];

            $validate_forma = Validator::make($eligibility->forma->toArray(), [
                'company_name' => 'required',
                'applied_at' => 'required',
                'received_at' => 'required',
            ]);

            if ($validate_forma->fails())
                $errors_a = array_merge($errors_a, $validate_forma->errors()->toArray());

            $validate_forma_address = Validator::make($eligibility->forma->company_address->toArray(), [
                'address1' => 'required',
                'postcode' => 'required',
                'district_id' => 'required|integer',
                'state_id' => 'required|integer',
            ]);

            if ($validate_forma_address->fails())
                $errors_a = array_merge($errors_a, $validate_forma_address->errors()->toArray());

            if (!$eligibility->entity_id || !$eligibility->entity_type)
                $errors_a = array_merge($errors_a, ['user_id' => 'Sila pilih Kesatuan Sekerja yang berkenaan.']);

            $errors['forma'] = $errors_a;
        }

        /////////////////////////////////////////////////////////////////////////////////////////

        $memo = $eligibility->letters()->where('letter_type_id', 64)->first();

        if(!$memo) {
            $errors['memo'] = ['memo' => 'Sila sediakan memo siasatan terlebih dahulu.'];
        }
        else {
            if($memo->attachment)
                $errors['memo'] = [];
            else
                $errors['memo'] = ['memo' => 'Sila muat naik memo yang telah ditandatangani.'];
        }

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $error_list = $this->getErrors($eligibility);
        $errors = count($error_list['forma']) + count($error_list['memo']);

        // return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 34;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang Isu Kelayakan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $eligibility->filing_status_id = 2;
            $eligibility->is_editable = 0;
            $eligibility->save();

            $eligibility->logs()->updateOrCreate(
                [
                    'module_id' => 34,
                    'activity_type_id' => 11,
                    'filing_status_id' => $eligibility->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' =>  auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            if($eligibility->logs->count() == 1) {
                $this->distribute($eligibility, 'pphq');
            }

            $eligibility->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 34,
            ]);

            Mail::to($eligibility->created_by->email)->send(new Sent($eligibility, 'Laporan Isu Kelayakan'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Laporan anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($eligibility, $target) {

        $check = $eligibility->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "pphq") {
            if($eligibility->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\EligibilityIssue')->where('filing_status_id', 2)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $eligibility->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $eligibility->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($eligibility, 'Serahan Laporan Isu Kelayakan'));
        }
        else if($target == "ptw") {
            if($eligibility->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\EligibilityIssue')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $eligibility->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $eligibility->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($eligibility->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\EligibilityIssue')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $eligibility->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $eligibility->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($eligibility, 'Serahan Laporan Isu Kelayakan'));
        }
        else if($target == "pw") {
            if($eligibility->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $eligibility->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $eligibility->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($eligibility, 'Serahan Laporan Isu Kelayakan'));
        }
        else if($target == "pthq") {
            if($eligibility->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\EligibilityIssue')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $eligibility->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $eligibility->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pkpg") {
            if($eligibility->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',12)->first();

            $eligibility->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $eligibility->filing_status_id,
                    'assigned_to_user_id' => $pkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpg->user->email)->send(new Distributed($eligibility, 'Serahan Laporan Isu Kelayakan'));
        }
        else if($target == "kpks") {
            if($eligibility->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $eligibility->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $eligibility->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($eligibility, 'Serahan Laporan Isu Kelayakan'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Isu Kelayakan - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('eligibility-issue.process.document-receive', $eligibility->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Isu Kelayakan - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $eligibility->filing_status_id = 3;
        $eligibility->save();

        $eligibility->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 34,
            ]
        );

        $eligibility->logs()->updateOrCreate(
            [
                'module_id' => 34,
                'activity_type_id' => 12,
                'filing_status_id' => $eligibility->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($eligibility, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($eligibility, 'ppw');
            Mail::to($eligibility->created_by->email)->send(new Received(auth()->user(), $eligibility, 'Pengesahan Penerimaan Laporan Isu Kelayakan'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($eligibility, 'pphq');
            Mail::to($eligibility->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $eligibility, 'Pengesahan Penerimaan Laporan Isu Kelayakan'));
            Mail::to($eligibility->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $eligibility, 'Pengesahan Penerimaan Laporan Isu Kelayakan'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Isu Kelayakan - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('eligibility-issue.process.query.item', $eligibility->id);
        $route2 = route('eligibility-issue.process.query', $eligibility->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        if(count($eligibility->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Isu Kelayakan - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $eligibility->filing_status_id = 5;
        $eligibility->is_editable = 1;
        $eligibility->save();

        $log2 = $eligibility->logs()->updateOrCreate(
            [
                'module_id' => 34,
                'activity_type_id' => 13,
                'filing_status_id' => $eligibility->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $eligibility->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $eligibility, 'Kuiri Laporan Isu Kelayakan oleh PW'));
        } else if(auth()->user()->hasRole('pkpg')) {
            // Send to PPW
            $log = $eligibility->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $eligibility, 'Kuiri Laporan Isu Kelayakan oleh PKPG'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to PKPG
            $log = $eligibility->logs()->where('role_id', 12)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $eligibility, 'Kuiri Laporan Isu Kelayakan oleh KPKS'));
        }

        $eligibility->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 34;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Isu Kelayakan - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $eligibility = EligibilityIssue::findOrFail($request->id);

            $queries = $eligibility->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $eligibility = EligibilityIssue::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 34;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Isu Kelayakan - Kuiri";
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
            $query = $eligibility->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 34;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Isu Kelayakan - Kuiri";
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
        $log->module_id = 34;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Isu Kelayakan - Kuiri";
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

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Isu Kelayakan - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $eligibility->logs()->where('activity_type_id',14)->where('filing_status_id', $eligibility->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('eligibility-issue.process.recommend', $eligibility->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Isu Kelayakan - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $eligibility = EligibilityIssue::findOrFail($request->id);
        $eligibility->filing_status_id = 6;
        $eligibility->is_editable = 0;
        $eligibility->save();

        $eligibility->logs()->updateOrCreate(
            [
                'module_id' => 34,
                'activity_type_id' => 14,
                'filing_status_id' => $eligibility->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($eligibility, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($eligibility, 'pkpg');
        else if(auth()->user()->hasRole('pkpg'))
            $this->distribute($eligibility, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($eligibility->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $eligibility, 'Serahan Laporan Isu Kelayakan'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Isu Kelayakan - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('eligibility-issue.process.delay', $eligibility->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Isu Kelayakan - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $eligibility = EligibilityIssue::findOrFail($request->id);
        $eligibility->filing_status_id = 7;
        $eligibility->is_editable = 0;
        $eligibility->save();

        $eligibility->logs()->updateOrCreate(
            [
                'module_id' => 34,
                'activity_type_id' => 15,
                'filing_status_id' => $eligibility->filing_status_id,
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

        $form = $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Isu Kelayakan - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("eligibility-issue.process.result.reject", $form->id);
        $route_approve = route("eligibility-issue.process.result.approve", $form->id);
        $route_delay = route("eligibility-issue.process.delay", $form->id);

        return view('general.modal.result-eligibility', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Isu Kelayakan - Termasuk";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('eligibility-issue.process.result.approve', $eligibility->id);

        return view('general.modal.include', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Isu Kelayakan - Termasuk";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $eligibility = EligibilityIssue::findOrFail($request->id);
        $eligibility->filing_status_id = 9;
        $eligibility->is_editable = 0;
        $eligibility->save();

        $eligibility->logs()->updateOrCreate(
            [
                'module_id' => 34,
                'activity_type_id' => 16,
                'filing_status_id' => $eligibility->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Laporan Persekutuan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Isu Kelayakan - Tidak Termasuk";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('eligibility-issue.process.result.reject', $eligibility->id);

        return view('general.modal.not-include', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Isu Kelayakan - Tidak Termasuk";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $eligibility = EligibilityIssue::findOrFail($request->id);
        $eligibility->filing_status_id = 8;
        $eligibility->is_editable = 0;
        $eligibility->save();

        $eligibility->logs()->updateOrCreate(
            [
                'module_id' => 34,
                'activity_type_id' => 16,
                'filing_status_id' => $eligibility->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Laporan Persekutuan Kesatuan Sekerja ini telah ditolak. Persekutuan Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_report(Request $request) {

        $form = $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Laporan Isu Kelayakan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("eligibility-issue.process.report.reject", $form->id);
        $route_approve = route("eligibility-issue.process.report.approve", $form->id);

        return view('general.modal.report-eligibility', compact('route_reject','route_approve'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_report_approve_edit(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Laporan Isu Kelayakan - Termasuk";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('eligibility-issue.process.report.approve', $eligibility->id);

        return view('general.modal.include', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_report_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Laporan Isu Kelayakan - Termasuk";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $eligibility->logs()->updateOrCreate(
            [
                'module_id' => 34,
                'activity_type_id' => 17,
                'filing_status_id' => $eligibility->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Laporan telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_report_reject_edit(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Laporan Isu Kelayakan - Tidak Termasuk";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('eligibility-issue.process.report.reject', $eligibility->id);

        return view('general.modal.not-include', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_report_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Laporan Isu Kelayakan - Tidak Termasuk";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $eligibility->logs()->updateOrCreate(
            [
                'module_id' => 34,
                'activity_type_id' => 17,
                'filing_status_id' => $eligibility->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Laporan telah dikemaskini.']);
    }
    
}
