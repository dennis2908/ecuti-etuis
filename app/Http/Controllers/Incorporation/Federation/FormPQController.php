<?php

namespace App\Http\Controllers\Incorporation\Federation;

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
use App\Mail\FormPQ\ApprovedKS;
use App\Mail\FormPQ\ApprovedPWN;
use App\Mail\FormPQ\Rejected;
use App\Mail\FormPQ\Sent;
use App\Mail\FormPQ\NotReceived;
use App\Mail\FormPQ\DocumentApproved;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\FormPQ;
use App\FilingModel\Query;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;

class FormPQController extends Controller
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
    public function index(Request $request) {

        $incorporation = FormPQ::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $error_list = $this->getErrors($incorporation);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan Borang PQ - Permohonan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('incorporation.federation.index', compact('incorporation','error_list'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $incorporation = FormPQ::findOrFail($request->id);

        $error_list = $this->getErrors($incorporation);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan (Kemaskini) Borang PQ - Permohonan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('incorporation.federation.index', compact('incorporation','error_list'));
    }

    private function getErrors($formpq) {

        $errors = [];

        if(!$formpq->formp) {
            $errors['p'] = [null,null,null,null];
        }
        else {
            $errors_p = [];

            $validate_formp = Validator::make($formpq->formp->toArray(), [
                'user_federation_id' => 'required|integer',
                'resolved_at' => 'required',
                'meeting_type_id' => 'required|integer',
                'applied_at' => 'required',
            ]);

            if ($validate_formp->fails())
                $errors_p = array_merge($errors_p, $validate_formp->errors()->toArray());

            $errors['p'] = $errors_p;
        }

        /////////////////////////////////////////////////////////////////////////////////////////

        if(!$formpq->formq) {
            $errors['q'] = [null,null,null,null,null];
        }
        else {
            $errors_q = [];

            $validate_formq = Validator::make($formpq->formq->toArray(), [
                'user_federation_id' => 'required|integer',
                'resolved_at' => 'required',
                'meeting_type_id' => 'required|integer',
                'applied_at' => 'required',
            ]);

            if ($validate_formq->fails())
                $errors_q = array_merge($errors_q, $validate_formq->errors()->toArray());

            if($formpq->formq->members->count() < 7)
                $errors_q = array_merge($errors_q, ['members' => ['Jumlah anggota kurang dari 7 orang.']]);

            $errors['q'] = $errors_q;
        }

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $formpq = FormPQ::findOrFail($request->id);

        $error_list = $this->getErrors($formpq);
        $errors = count($error_list['p']) + count($error_list['q']);

        // return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 11;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang PQ - Hantar Permohonan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formpq->filing_status_id = 2;
            $formpq->is_editable = 0;
            $formpq->save();

            $formpq->logs()->updateOrCreate(
                [
                    'module_id' => 11,
                    'activity_type_id' => 11,
                    'filing_status_id' => $formpq->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' =>  auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $formpq->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 11,
            ]);

            Mail::to($formpq->created_by->email)->send(new Sent($formpq, 'Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan anda telah dihantar.']);
        }
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
     public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 11;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang PQ";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $incorporations = FormPQ::with(['tenure.entity','status']);//->where('filing_status_id', '>', 1);

            if(auth()->user()->hasRole('ks')) {
                $incorporations = $incorporations->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $incorporations = $incorporations->where('filing_status_id', '>', 1)->where(function($incorporations) {
                    return $incorporations->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($incorporations){
                        if(auth()->user()->hasRole('ptw'))
                            return $incorporations->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $incorporations->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $incorporations = $incorporations->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }
            
            return datatables()->of($incorporations)
                 ->editColumn('applied_at', function ($incorporation) {
                    return $incorporation->created_at ? date('d/m/Y', strtotime($incorporation->created_at)) : '';
                })
                ->editColumn('status.name', function ($incorporation) {
                    if($incorporation->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$incorporation->status->name.'</span>';
                    else if($incorporation->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$incorporation->status->name.'</span>';
                    else if($incorporation->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$incorporation->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$incorporation->status->name.'</span>';
                })
                ->editColumn('letter', function($incorporation) {
                    $result = "";
                    if($incorporation->filing_status_id == 9)
                        $result .= letterButton(11, get_class($incorporation), $incorporation->id);
                    return $result;
                })
                ->editColumn('action', function ($incorporation) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($incorporation)).'\','.$incorporation->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $incorporation->is_editable)) && $incorporation->filing_status_id < 7 )
                        $button .= '<a href="'.route('federation.form', $incorporation->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';

                    if( ((auth()->user()->hasRole('ptw') && $incorporation->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $incorporation->distributions->count() == 3)) && $incorporation->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$incorporation->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg', 'kpks']) && $incorporation->filing_status_id < 8 )
                        $button .= '<a onclick="query('.$incorporation->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg']) && $incorporation->filing_status_id < 7 )
                        $button .= '<a onclick="recommend('.$incorporation->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';

                    if(auth()->user()->hasRole('kpks') && $incorporation->filing_status_id < 8 )
                        $button .= '<a onclick="process('.$incorporation->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    return $button;
                })
                ->make(true);

        }
        else {
            $log = new LogSystem;
            $log->module_id = 11;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang PQ";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('incorporation.federation.list');
    }


    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($formpq, $target) {

        $check = $formpq->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($formpq->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormPQ')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $formpq->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formpq->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($formpq->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormPQ')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $formpq->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formpq->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($formpq, 'Serahan Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        }
        else if($target == "pw") {
            if($formpq->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $formpq->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formpq->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($formpq, 'Serahan Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        }
        else if($target == "pthq") {
            if($formpq->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormPQ')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $formpq->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formpq->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($formpq->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormPQ')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $formpq->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formpq->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($formpq, 'Serahan Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        }
        else if($target == "pkpg") {
            if($formpq->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',12)->first();

            $formpq->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formpq->filing_status_id,
                    'assigned_to_user_id' => $pkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpg->user->email)->send(new Distributed($formpq, 'Serahan Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        }
        else if($target == "kpks") {
            if($formpq->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $formpq->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formpq->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($formpq, 'Serahan Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $formpq = FormPQ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang PQ - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('federation.process.document-receive', $formpq->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang PQ - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formpq = FormPQ::findOrFail($request->id);

        $formpq->filing_status_id = 3;
        $formpq->save();

        $formpq->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 11,
            ]
        );

        $formpq->logs()->updateOrCreate(
            [
                'module_id' => 11,
                'activity_type_id' => 12,
                'filing_status_id' => $formpq->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($formpq, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($formpq, 'ppw');
            Mail::to($formpq->created_by->email)->send(new Received(auth()->user(), $formpq, 'Pengesahan Penerimaan Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($formpq, 'pphq');
            Mail::to($formpq->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formpq, 'Pengesahan Penerimaan Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
            Mail::to($formpq->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formpq, 'Pengesahan Penerimaan Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $formpq = FormPQ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang PQ - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('federation.process.query.item', $formpq->id);
        $route2 = route('federation.process.query', $formpq->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $formpq = FormPQ::findOrFail($request->id);

        if(count($formpq->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang PQ - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formpq->filing_status_id = 5;
        $formpq->is_editable = 1;
        $formpq->save();

        $log2 = $formpq->logs()->updateOrCreate(
            [
                'module_id' => 11,
                'activity_type_id' => 13,
                'filing_status_id' => $formpq->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $formpq->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formpq, 'Kuiri Permohonan Borang PQ oleh PW'));
        } else if(auth()->user()->hasRole('pkpg')) {
            // Send to PPHQ
            $log = $formpq->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formpq, 'Kuiri Permohonan Borang PQ oleh PKPG'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to PKPG
            $log = $formpq->logs()->where('role_id', 12)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formpq, 'Kuiri Permohonan Borang PQ oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($formpq->created_by->email)->send(new Queried(auth()->user(), $formpq, 'Kuiri Permohonan Borang PQ'));
        }

        $formpq->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 11;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang PQ - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formpq = FormPQ::findOrFail($request->id);

            $queries = $formpq->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $formpq = FormPQ::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 11;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang PQ - Kuiri";
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
            $query = $formpq->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 11;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang PQ - Kuiri";
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
        $log->module_id = 11;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang PQ - Kuiri";
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

        $formpq = FormPQ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang PQ - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $formpq->logs()->where('activity_type_id',14)->where('filing_status_id', $formpq->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('federation.process.recommend', $formpq->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang PQ - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formpq = FormPQ::findOrFail($request->id);
        $formpq->filing_status_id = 6;
        $formpq->is_editable = 0;
        $formpq->save();

        $formpq->logs()->updateOrCreate(
            [
                'module_id' => 11,
                'activity_type_id' => 14,
                'filing_status_id' => $formpq->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($formpq, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($formpq, 'pkpg');
        else if(auth()->user()->hasRole('pkpg'))
            $this->distribute($formpq, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($formpq->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $formpq, 'Serahan Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $formpq = FormPQ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang PQ - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('federation.process.delay', $formpq->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang PQ - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formpq = FormPQ::findOrFail($request->id);
        $formpq->filing_status_id = 7;
        $formpq->is_editable = 0;
        $formpq->save();

        $formpq->logs()->updateOrCreate(
            [
                'module_id' => 11,
                'activity_type_id' => 15,
                'filing_status_id' => $formpq->filing_status_id,
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

        $form = $formpq = FormPQ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang PQ - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("federation.process.result.reject", $form->id);
        $route_approve = route("federation.process.result.approve", $form->id);
        $route_delay = route("federation.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $formpq = FormPQ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang PQ - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('federation.process.result.approve', $formpq->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang PQ - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formpq = FormPQ::findOrFail($request->id);
        $formpq->filing_status_id = 9;
        $formpq->is_editable = 0;
        $formpq->save();

        $formpq->logs()->updateOrCreate(
            [
                'module_id' => 11,
                'activity_type_id' => 16,
                'filing_status_id' => $formpq->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formpq->created_by->email)->send(new ApprovedKS($formpq, 'Status Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        Mail::to($formpq->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formpq, 'Status Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        Mail::to($formpq->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formpq, 'Status Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        Mail::to($formpq->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formpq, 'Status Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));
        Mail::to($formpq->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($formpq, 'Sedia Dokumen Kelulusan Penggabungan dengan Persekutuan Kesatuan Sekerja'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $formpq = FormPQ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang PQ - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('federation.process.result.reject', $formpq->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang PQ - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formpq = FormPQ::findOrFail($request->id);
        $formpq->filing_status_id = 8;
        $formpq->is_editable = 0;
        $formpq->save();

        $formpq->logs()->updateOrCreate(
            [
                'module_id' => 11,
                'activity_type_id' => 16,
                'filing_status_id' => $formpq->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formpq->created_by->email)->send(new Rejected($formpq, 'Status Permohonan Penggabungan dengan Persekutuan Kesatuan Sekerja'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }
}
