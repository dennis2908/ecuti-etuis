<?php

namespace App\Http\Controllers\DissolutionCancellation\Dissolution;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\FilingModel\Query;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\FormIEU\Sent;
use App\FilingModel\FormIEU;
use App\FilingModel\FormI;
use App\FilingModel\FormE;
use App\FilingModel\FormU;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\User;
use App\UserStaff;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;


class DissolutionController extends Controller
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

        $dissolution = FormIEU::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $formi = $dissolution->formi()->create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'secretary_user_id' => auth()->id(),
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $forme = $dissolution->forme()->create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'secretary_user_id' => auth()->id(),
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $formu = $dissolution->formu()->create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $error_list = $this->getErrors($dissolution);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan Borang IEU - Pembubaran Kesatuan Sekerja";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('dissolution-cancellation.dissolution.index', compact('dissolution', 'error_list'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $dissolution = FormIEU::findOrFail($request->id);

        $error_list = $this->getErrors($dissolution);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan (Kemaskini) Borang IEU - Pembubaran Kesatuan Sekerja";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('dissolution-cancellation.dissolution.index', compact('dissolution', 'error_list'));
    }

    public function praecipe(Request $request) {
        $pdf = PDF::loadView('dissolution-cancellation.dissolution.praecipe');
        return $pdf->setPaper('A4')->setOrientation('portrait')->download('praecipe.pdf');
    }


    /**
     * Show the list of data
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 27;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang IEU";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $dissolutions = FormIEU::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $dissolutions = $dissolutions->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $dissolutions = $dissolutions->where('filing_status_id', '>', 1)->where(function($dissolutions) {
                    return $dissolutions->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($dissolutions){
                        if(auth()->user()->hasRole('ptw'))
                            return $dissolutions->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $dissolutions->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $dissolutions = $dissolutions->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($dissolutions)
                ->editColumn('tenure.entity.name', function ($dissolution) {
                    return $dissolution->tenure->entity->name;
                })
                ->editColumn('tenure.entity.type', function ($dissolution) {
                    return $dissolution->tenure->entity_type == "App\\UserUnion" ? 'Kesatuan' : 'Persekutuan';
                })
                ->editColumn('applied_at', function ($dissolution) {
                    return $dissolution->created_at ? date('d/m/Y', strtotime($dissolution->created_at)) : '';
                })
                ->editColumn('status.name', function ($dissolution) {
                    if($dissolution->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$dissolution->status->name.'</span>';
                    else if($dissolution->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$dissolution->status->name.'</span>';
                    else if($dissolution->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$dissolution->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$dissolution->status->name.'</span>';
                })
                ->editColumn('letter', function($dissolution) {
                    $result = "";
                    if($dissolution->filing_status_id == 9){
                        $result .= letterButton(48, get_class($dissolution), $dissolution->id);
                        $result .= letterButton(47, get_class($dissolution), $dissolution->id);
                    }
                    return $result;
                    // return '<a href="'.url('files/dissolution_cancellation/memo.pdf').'" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Memo Pembubaran</a><br>';
                    // return '<a href="'.url('files/dissolution_cancellation/surat.pdf').'" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Kelulusan Pembubaran</a><br>';
                })
                ->editColumn('action', function ($dissolution) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($dissolution)).'\','.$dissolution->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $dissolution->is_editable)) && $dissolution->filing_status_id < 7 )
                        $button .= '<a href="'.route('dissolution.form', $dissolution->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';

                    if( ((auth()->user()->hasRole('ptw') && $dissolution->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $dissolution->distributions->count() == 3)) && $dissolution->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$dissolution->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg', 'kpks']) && $dissolution->filing_status_id < 8 )
                        $button .= '<a onclick="query('.$dissolution->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg', 'pkpp']) && $dissolution->filing_status_id < 7 )
                        $button .= '<a onclick="recommend('.$dissolution->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';

                    if(auth()->user()->hasRole('kpks') && $dissolution->filing_status_id < 8 )
                        $button .= '<a onclick="process('.$dissolution->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    return $button;
                })
                ->make(true);

        }
        else {
            $log = new LogSystem;
            $log->module_id = 27;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang IEU";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('dissolution-cancellation.dissolution.list');
    }

    private function getErrors($dissolution) {

        $errors = [];

        if(!$dissolution->formi) {
            $errors['i'] = [null,null,null,null,null];
        }
        else {
            $errors_i = [];

            $validate_formi = Validator::make($dissolution->formi->toArray(), [
                'concluded_at' => 'required',
                'resolved_at' => 'required',
                'meeting_type_id' => 'required|integer',
                'applied_at' => 'required',
            ]);

            if ($validate_formi->fails())
                $errors_i = array_merge($errors_i, $validate_formi->errors()->toArray());

            if($dissolution->formi->members->count() < 7)
                $errors_i = array_merge($errors_i, ['members' => ['Jumlah ahli kurang dari 7 orang.']]);

            $errors['i'] = $errors_i;
        }

        /////////////////////////////////////////////////////////////////////////////////////////

        if(!$dissolution->forme) {
            $errors['e'] = [null,null,null,null];
        }
        else {
            $errors_e = [];

            $validate_forme = Validator::make($dissolution->forme->toArray(), [
                'resolved_at' => 'required',
                'meeting_type_id' => 'required|integer',
                'applied_at' => 'required',
            ]);

            if ($validate_forme->fails())
                $errors_e = array_merge($errors_e, $validate_forme->errors()->toArray());

            if($dissolution->forme->members->count() < 7)
                $errors_e = array_merge($errors_e, ['members' => ['Jumlah ahli kurang dari 7 orang.']]);

            $errors['e'] = $errors_e;
        }

        /////////////////////////////////////////////////////////////////////////////////////////

        if(!$dissolution->formu) {
            $errors['u'] = [null,null,null,null,null,null,null];
        }
        else {
            $errors_u = [];
            $formu = $dissolution->formu;

            $validate_formu = Validator::make($formu->toArray(), [
                'setting' => 'required',
                'voted_at' => 'required',
                'total_voters' => 'required|integer',
                'total_slips' => 'required|integer',
                'total_supporting' => 'required|integer',
                'total_against' => 'required|integer',
                'is_supported' => 'required|integer',
            ]);

            if ($validate_formu->fails()) {
                $errors_u = array_merge($errors_u, $validate_formu->errors()->toArray());
            }

            $errors['u'] = $errors_u;
        }

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $dissolution = FormIEU::findOrFail($request->id);

        $error_list = $this->getErrors($dissolution);
        $errors = count($error_list['i']) + count($error_list['e']) + count($error_list['u']);

        // return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 27;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang IEU - Hantar Permohonan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $dissolution->filing_status_id = 2;
            $dissolution->is_editable = 0;
            $dissolution->save();

            $dissolution->logs()->updateOrCreate(
                [
                    'module_id' => 27,
                    'activity_type_id' => 11,
                    'filing_status_id' => $dissolution->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' =>  auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $dissolution->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 27,
            ]);

            Mail::to($dissolution->created_by->email)->send(new Sent($dissolution, 'Permohonan Pembubaran'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($dissolution, $target) {

        $check = $dissolution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($dissolution->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormIEU')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $dissolution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $dissolution->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($dissolution->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormIEU')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $dissolution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $dissolution->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($dissolution, 'Serahan Permohonan Pembubaran'));
        }
        else if($target == "pw") {
            if($dissolution->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $dissolution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $dissolution->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($dissolution, 'Serahan Permohonan Pembubaran'));
        }
        else if($target == "pthq") {
            if($dissolution->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormIEU')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $dissolution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $dissolution->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($dissolution->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormIEU')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $dissolution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $dissolution->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($dissolution, 'Serahan Permohonan Pembubaran'));
        }
        else if($target == "pkpg") {
            if($dissolution->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',12)->first();

            $dissolution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $dissolution->filing_status_id,
                    'assigned_to_user_id' => $pkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpg->user->email)->send(new Distributed($dissolution, 'Serahan Permohonan Pembubaran'));
        }
        else if($target == "kpks") {
            if($dissolution->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $dissolution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $dissolution->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($dissolution, 'Serahan Permohonan Pembubaran'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $dissolution = FormIEU::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang IEU - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('dissolution.process.document-receive', $dissolution->id);

        $this->distribute($dissolution, 'ptw');

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang IEU - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $dissolution = FormIEU::findOrFail($request->id);

        $dissolution->filing_status_id = 3;
        $dissolution->save();

        $dissolution->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 27,
            ]
        );

        $dissolution->logs()->updateOrCreate(
            [
                'module_id' => 27,
                'activity_type_id' => 12,
                'filing_status_id' => $dissolution->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($dissolution, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($dissolution, 'ppw');
            Mail::to($dissolution->created_by->email)->send(new Received(auth()->user(), $dissolution, 'Pengesahan Penerimaan Permohonan Pembubaran'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($dissolution, 'pphq');
            Mail::to($dissolution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $dissolution, 'Pengesahan Penerimaan Permohonan Pembubaran'));
            Mail::to($dissolution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $dissolution, 'Pengesahan Penerimaan Permohonan Pembubaran'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $dissolution = FormIEU::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang IEU - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('dissolution.process.query.item', $dissolution->id);
        $route2 = route('dissolution.process.query', $dissolution->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $dissolution = FormIEU::findOrFail($request->id);

        if(count($dissolution->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang IEU - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $dissolution->filing_status_id = 5;
        $dissolution->is_editable = 1;
        $dissolution->save();

        $log2 = $dissolution->logs()->updateOrCreate(
            [
                'module_id' => 27,
                'activity_type_id' => 13,
                'filing_status_id' => $dissolution->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $dissolution->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $dissolution, 'Kuiri notis Borang IEU oleh PW'));
        } else if(auth()->user()->hasRole('pkpg')) {
            // Send to PPHQ
            $log = $dissolution->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $dissolution, 'Kuiri notis Borang IEU oleh PKPG'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to PKPG
            $log = $dissolution->logs()->where('role_id', 12)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $dissolution, 'Kuiri notis Borang IEU oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($dissolution->created_by->email)->send(new Queried(auth()->user(), $dissolution, 'Kuiri notis Borang IEU'));
        }

        $dissolution->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 27;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang IEU - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $dissolution = FormIEU::findOrFail($request->id);

            $queries = $dissolution->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $dissolution = FormIEU::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 27;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang IEU - Kuiri";
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
            $query = $dissolution->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 27;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang IEU - Kuiri";
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
        $log->module_id = 27;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang IEU - Kuiri";
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

        $dissolution = FormIEU::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang IEU - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $dissolution->logs()->where('activity_type_id',14)->where('filing_status_id', $dissolution->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('dissolution.process.recommend', $dissolution->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang IEU - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $dissolution = FormIEU::findOrFail($request->id);
        $dissolution->filing_status_id = 6;
        $dissolution->is_editable = 0;
        $dissolution->save();

        $dissolution->logs()->updateOrCreate(
            [
                'module_id' => 27,
                'activity_type_id' => 14,
                'filing_status_id' => $dissolution->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($dissolution, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($dissolution, 'pkpg');
        else if(auth()->user()->hasRole('pkpg'))
            $this->distribute($dissolution, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($dissolution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $dissolution, 'Serahan Permohonan Pembubaran'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $dissolution = FormIEU::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang IEU - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('dissolution.process.delay', $dissolution->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang IEU - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $dissolution = FormIEU::findOrFail($request->id);
        $dissolution->filing_status_id = 7;
        $dissolution->is_editable = 0;
        $dissolution->save();

        $dissolution->logs()->updateOrCreate(
            [
                'module_id' => 27,
                'activity_type_id' => 15,
                'filing_status_id' => $dissolution->filing_status_id,
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

        $form = $dissolution = FormIEU::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang IEU - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("dissolution.process.result.reject", $form->id);
        $route_approve = route("dissolution.process.result.approve", $form->id);
        $route_delay = route("dissolution.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $dissolution = FormIEU::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang IEU - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('dissolution.process.result.approve', $dissolution->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang IEU - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $dissolution = FormIEU::findOrFail($request->id);
        $dissolution->filing_status_id = 9;
        $dissolution->is_editable = 0;
        $dissolution->save();

        $dissolution->logs()->updateOrCreate(
            [
                'module_id' => 27,
                'activity_type_id' => 16,
                'filing_status_id' => $dissolution->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $dissolution = FormIEU::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang IEU - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('dissolution.process.result.reject', $dissolution->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang IEU - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $dissolution = FormIEU::findOrFail($request->id);
        $dissolution->filing_status_id = 8;
        $dissolution->is_editable = 0;
        $dissolution->save();

        $dissolution->logs()->updateOrCreate(
            [
                'module_id' => 27,
                'activity_type_id' => 16,
                'filing_status_id' => $dissolution->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }
}
