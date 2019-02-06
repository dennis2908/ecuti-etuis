<?php

namespace App\Http\Controllers\DissolutionCancellation\Cancellation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\OtherModel\Attachment;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\FormF\Approved;
use App\Mail\FormF\Rejected;
use App\Mail\FormF\ResponseRequired;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\FormF;
use App\FilingModel\Query;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;

class CancellationController extends Controller
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

        $cancellation = FormF::create([
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $users = User::whereIn('user_type_id', [3,4])->where('user_status_id', 1)->get();

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan Borang F - Pembatalan Kesatuan Sekerja";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('dissolution-cancellation.cancellation.index', compact('cancellation', 'users'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $cancellation = FormF::findOrFail($request->id);

        $users = User::whereIn('user_type_id', [3,4])->where('user_status_id', 1)->get()->filter(function($user) {
            return $user->hasAnyRole(['union','federation']);
        });

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan (Kemaskini) Borang F - Pembatalan Kesatuan Sekerja";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('dissolution-cancellation.cancellation.index', compact('cancellation', 'users'));
    }

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

            $cancellations = FormF::with(['status']);

            if(auth()->user()->hasRole('pw')) {
                $cancellations = $cancellations->where('created_by_user_id', auth()->id());
            }
            else if(auth()->user()->hasAnyRole(['pthq'])) {
                $cancellations = $cancellations->where('filing_status_id', '>', 1)->where(function($cancellation) {
                    return $cancellation->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhereDoesntHave('logs', function($logs) {
                        return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                    });
                });
            }
            else {
                $cancellations = $cancellations->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($cancellations)
                ->editColumn('entity.name', function ($cancellation) {
                    if($cancellation->entity)
                        return $cancellation->entity->name;
                })
                ->editColumn('entity.type', function ($cancellation) {
                    if($cancellation->entity)
                        return $cancellation->entity_type == "App\\UserUnion" ? 'Kesatuan' : 'Persekutuan';
                })
                ->editColumn('applied_at', function ($cancellation) {
                    return $cancellation->applied_at ? date('d/m/Y', strtotime($cancellation->applied_at)) : '';
                })
                ->editColumn('status.name', function ($cancellation) {
                    if($cancellation->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$cancellation->status->name.'</span>';
                    else if($cancellation->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$cancellation->status->name.'</span>';
                    else if($cancellation->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$cancellation->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$cancellation->status->name.'</span>';
                })
                ->editColumn('letter', function($cancellation) {
                    return '';
                    // return '<a href="{{ url('files/dissolution_cancellation/formf.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Borang F</a><br>';
                })
                ->editColumn('action', function ($cancellation) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($cancellation)).'\','.$cancellation->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if(auth()->user()->hasRole('pw') && $cancellation->is_editable && $cancellation->filing_status_id < 7 )
                        $button .= '<a href="'.route('cancellation.form', $cancellation->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if( auth()->user()->hasRole('pthq') && $cancellation->distributions->count() == 0 && $cancellation->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$cancellation->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['pphq', 'pkpg', 'kpks']) && $cancellation->filing_status_id < 8 )
                        $button .= '<a onclick="query('.$cancellation->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['pphq', 'pkpg']) && $cancellation->filing_status_id < 7 )
                        $button .= '<a onclick="recommend('.$cancellation->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $cancellation->filing_status_id < 7 )
                        $button .= '<a onclick="process('.$cancellation->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    if(auth()->user()->hasRole('pthq') && $cancellation->filing_status_id < 8 )
                        $button .= '<a onclick="response('.$cancellation->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Maklumbalas</a><br>';

                    return $button;
                })
                ->make(true);

        }
        else {
            $log = new LogSystem;
            $log->module_id = 28;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang F";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('dissolution-cancellation.cancellation.list');
    }

    private function getErrors($cancellation_id) {

        $cancellation = FormF::findOrFail($cancellation_id);

        $errors = [];

        $validate_formf = Validator::make($cancellation->toArray(), [
            'entity_type' => 'required',
            'entity_id' => 'required',
            'applied_at' => 'required',
        ]);

        if ($validate_formf->fails())
            $errors = array_merge($errors, $validate_formf->errors()->toArray());

        if ($cancellation->attachments->count() == 0 )
            $errors = array_merge($errors, ['document' => 'Sila muat naik dokumen fizikal laporan.']);

        $errors = ['f' => $errors];

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $errors = ($this->getErrors($request->id))['f'];

        //return response()->json(['errors' => $errors], 422);

        if(count($errors) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 28;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang F - Hantar Permohonan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $cancellation = FormF::findOrFail($request->id);
            $cancellation->address_id = $cancellation->entity->addresses->last()->address->id;
            $cancellation->filing_status_id = 2;
            $cancellation->is_editable = 0;
            $cancellation->save();

            $cancellation->logs()->updateOrCreate(
                [
                    'module_id' => 28,
                    'activity_type_id' => 11,
                    'filing_status_id' => $cancellation->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $cancellation->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 28,
            ]);

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan anda telah dihantar.']);
        }
    }

    /**
     * Show the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_index(Request $request) {

        $cancellation = FormF::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang F - Dokumen Sokongan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attachments = [];

        foreach($cancellation->attachments as $attachment) {
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
                'formf',
                $request->file('file'),
                uniqid().'_'.$request->file('file')->getClientOriginalName()
            );

            $cancellation = FormF::findOrFail($request->id);

            $attachment = $cancellation->attachments()->create([
                'name' => $request->file('file')->getClientOriginalName(),
                'url' => $path,
                'created_by_user_id' => auth()->id()
            ]);

            $log = new LogSystem;
            $log->module_id = 28;
            $log->activity_type_id = 4;
            $log->description = "Tambah Borang F - Dokumen Sokongan";
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
        $log->module_id = 28;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang F - Dokumen Sokongan";
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
    private function distribute($cancellation, $target) {

        $check = $cancellation->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($cancellation->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormF')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $cancellation->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $cancellation->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($cancellation->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormF')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $cancellation->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $cancellation->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($cancellation, 'Serahan Permohonan Pembatalan'));
        }
        else if($target == "pw") {
            if($cancellation->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $cancellation->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $cancellation->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($cancellation, 'Serahan Permohonan Pembatalan'));
        }
        else if($target == "pthq") {
            if($cancellation->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormF')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $cancellation->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $cancellation->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($cancellation->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormF')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $cancellation->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $cancellation->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($cancellation, 'Serahan Permohonan Pembatalan'));
        }
        else if($target == "pkpg") {
            if($cancellation->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',12)->first();

            $cancellation->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $cancellation->filing_status_id,
                    'assigned_to_user_id' => $pkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpg->user->email)->send(new Distributed($cancellation, 'Serahan Permohonan Pembatalan'));
        }
        else if($target == "kpks") {
            if($cancellation->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $cancellation->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $cancellation->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($cancellation, 'Serahan Permohonan Pembatalan'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $cancellation = FormF::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang F - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('cancellation.process.document-receive', $cancellation->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang F - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $cancellation = FormF::findOrFail($request->id);

        $cancellation->filing_status_id = 3;
        $cancellation->save();

        $cancellation->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 28,
            ]
        );

        $cancellation->logs()->updateOrCreate(
            [
                'module_id' => 28,
                'activity_type_id' => 12,
                'filing_status_id' => $cancellation->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($cancellation, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($cancellation, 'ppw');
            Mail::to($cancellation->created_by->email)->send(new Received(auth()->user(), $cancellation, 'Pengesahan Penerimaan Permohonan Pembatalan'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($cancellation, 'pphq');
            Mail::to($cancellation->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $cancellation, 'Pengesahan Penerimaan Permohonan Pembatalan'));
            Mail::to($cancellation->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $cancellation, 'Pengesahan Penerimaan Permohonan Pembatalan'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_responseReceive_edit(Request $request) {

        $cancellation = FormF::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang F - Terima Maklum Balas";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('cancellation.process.response-receive', $cancellation->id);

        return view('general.modal.response-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_responseReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang F - Terima Maklum Balas";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $cancellation = FormF::findOrFail($request->id);
        $cancellation->filing_status_id = 3;
        $cancellation->save();

        $cancellation->logs()->updateOrCreate(
            [
                'module_id' => 28,
                'activity_type_id' => 22,
                'filing_status_id' => $cancellation->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $cancellation = FormF::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang F - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('cancellation.process.query.item', $cancellation->id);
        $route2 = route('cancellation.process.query', $cancellation->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $cancellation = FormF::findOrFail($request->id);

        if(count($cancellation->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang F - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $cancellation->filing_status_id = 5;
        $cancellation->is_editable = 1;
        $cancellation->save();

        $log2 = $cancellation->logs()->updateOrCreate(
            [
                'module_id' => 28,
                'activity_type_id' => 13,
                'filing_status_id' => $cancellation->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $cancellation->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $cancellation, 'Kuiri Permohonan Borang F oleh PW'));
        } else if(auth()->user()->hasRole('pkpg')) {
            // Send to PPHQ
            $log = $cancellation->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $cancellation, 'Kuiri Permohonan Borang F oleh PKPG'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to PKPG
            $log = $cancellation->logs()->where('role_id', 12)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $cancellation, 'Kuiri Permohonan Borang F oleh KPKS'));
        }
        else {
            // Send to PW
            Mail::to($cancellation->created_by->email)->send(new Queried(auth()->user(), $cancellation, 'Kuiri Permohonan Borang F'));
        }

        $cancellation->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 28;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang F - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $cancellation = FormF::findOrFail($request->id);

            $queries = $cancellation->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $cancellation = FormF::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 28;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang F - Kuiri";
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
            $query = $cancellation->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 28;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang F - Kuiri";
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
        $log->module_id = 28;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang F - Kuiri";
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

        $cancellation = FormF::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang F - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $cancellation->logs()->where('activity_type_id',14)->where('filing_status_id', $cancellation->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('cancellation.process.recommend', $cancellation->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang F - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $cancellation = FormF::findOrFail($request->id);
        $cancellation->filing_status_id = 6;
        $cancellation->is_editable = 0;
        $cancellation->save();

        $cancellation->logs()->updateOrCreate(
            [
                'module_id' => 28,
                'activity_type_id' => 14,
                'filing_status_id' => $cancellation->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($cancellation, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($cancellation, 'pkpg');
        else if(auth()->user()->hasRole('pkpg'))
            $this->distribute($cancellation, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($cancellation->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $cancellation, 'Serahan Permohonan Pembatalan'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $cancellation = FormF::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang F - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('cancellation.process.delay', $cancellation->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang F - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $cancellation = FormF::findOrFail($request->id);
        $cancellation->filing_status_id = 7;
        $cancellation->is_editable = 0;
        $cancellation->save();

        $cancellation->logs()->updateOrCreate(
            [
                'module_id' => 28,
                'activity_type_id' => 15,
                'filing_status_id' => $cancellation->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($cancellation->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new Rejected($cancellation, 'Penolakan / Penangguhan Pembatalan'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result(Request $request) {

        $form = $cancellation = FormF::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang F - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_approve = route("cancellation.process.result.approve", $form->id);
        $route_delay = route("cancellation.process.delay", $form->id);

        return view('general.modal.result-formf', compact('route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $cancellation = FormF::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang F - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('cancellation.process.result.approve', $cancellation->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 28;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang F - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $cancellation = FormF::findOrFail($request->id);
        $cancellation->filing_status_id = 9;
        $cancellation->is_editable = 0;
        $cancellation->save();

        $cancellation->logs()->updateOrCreate(
            [
                'module_id' => 28,
                'activity_type_id' => 16,
                'filing_status_id' => $cancellation->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($cancellation->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new Approved($cancellation, 'Kelulusan Pembatalan'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }
}
