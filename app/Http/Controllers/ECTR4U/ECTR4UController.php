<?php

namespace App\Http\Controllers\ECTR4U;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\MasterModel\MasterProgrammeType;
use App\MasterModel\MasterSector;
use App\OtherModel\Attachment;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\Received;
use App\Mail\Ectr4u\Approved;
use App\Mail\Ectr4u\Incompleted;
use App\Mail\Ectr4u\Rejected;
use App\Mail\Ectr4u\ToBeProcessed;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\Ectr4u;
use App\FilingModel\Query;
use App\UserFederation;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;

class ECTR4UController extends Controller
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

        $types = MasterProgrammeType::all();
        $sectors = MasterSector::all();
        $federations = UserFederation::all();

        $ectr4u = Ectr4u::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'created_by_user_id' => auth()->id(),
        ]);

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan borang eCTR4U";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('ectr4u.index', compact('ectr4u','types','sectors','federations'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $types = MasterProgrammeType::all();
        $sectors = MasterSector::all();
        $federations = UserFederation::all();

        $ectr4u = Ectr4u::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 5;
        $log->description = "Buka paparan (Kemaskini) borang eCTR4U";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('ectr4u.index', compact('ectr4u','types','sectors','federations'));
    }
    
    /**
     * Show the list of data
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 15;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai eCTR4U";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $ectr4u = Ectr4u::with(['programme_type','sector']);

            if(auth()->user()->hasRole('ks')) {
                $ectr4u = $ectr4u->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['pthq'])) {
                $ectr4u = $ectr4u->where('filing_status_id', '>', 1)->where('filing_status_id', '>', 1)->where(function($ectr4u) {
                    return $ectr4u->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhereDoesntHave('logs', function($logs) {
                        return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                    });
                });
            }
            else {
                $ectr4u = $ectr4u->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($ectr4u)
                ->editColumn('name', function ($ectr4u) {
                    return $ectr4u->name ? $ectr4u->name : '';
                })
                ->editColumn('programme_type.name', function ($ectr4u) {
                    return $ectr4u->programme_type_id ? $ectr4u->programme_type->name : '';
                })
                 ->editColumn('created_at', function ($ectr4u) {
                    return date('d/m/Y', strtotime($ectr4u->created_at));
                })
                ->editColumn('status.name', function ($ectr4u) {
                    if($ectr4u->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$ectr4u->status->name.'</span>';
                    else if($ectr4u->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$ectr4u->status->name.'</span>';
                    else if($ectr4u->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$ectr4u->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$ectr4u->status->name.'</span>';
                })
                ->editColumn('letter', function($ectr4u) {
                    $result = "";
                    if($ectr4u->filing_status_id == 8 && $ectr4u->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pkpg'); })->count() == 0)
                         $result .= letterButton(14, get_class($ectr4u), $ectr4u->id);

                     elseif($ectr4u->filing_status_id == 9){
                        $result .= letterButton(15, get_class($ectr4u), $ectr4u->id);
                        $result .= letterButton(16, get_class($ectr4u), $ectr4u->id);
                        $result .= letterButton(17, get_class($ectr4u), $ectr4u->id);
                    }

                    elseif($ectr4u->filing_status_id == 8){
                        $result .= letterButton(18, get_class($ectr4u), $ectr4u->id);
                        $result .= letterButton(19, get_class($ectr4u), $ectr4u->id);
                        $result .= letterButton(20, get_class($ectr4u), $ectr4u->id);
                    }
                    return $result;

                })
                ->editColumn('action', function ($ectr4u) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($ectr4u)).'\','.$ectr4u->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if(((auth()->user()->hasRole('pthq') && $ectr4u->distributions->count() == 0) || (auth()->user()->hasRole('ppkpg') && $ectr4u->distributions->count() == 2)) && $ectr4u->filing_status_id < 7)
                        $button .= '<a onclick="check('.$ectr4u->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    if(auth()->user()->hasRole('ks') && $ectr4u->is_editable && $ectr4u->filing_status_id < 7)
                        $button .= '<a href="'.route('ectr4u.form', $ectr4u->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if(auth()->user()->hasRole('pthq') && $ectr4u->logs()->where('activity_type_id', 12)->count() == 0)
                        $button .= '<a onclick="receive('.$ectr4u->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasRole('pkpg') && $ectr4u->filing_status_id < 8)
                        $button .= '<a onclick="query('.$ectr4u->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasRole('pkpg') && $ectr4u->filing_status_id < 8)
                        $button .= '<a onclick="process('.$ectr4u->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 15;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan senarai eCTR4U";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('ectr4u.list');
    }

    private function getErrors($ectr4u_id) {

        $ectr4u = Ectr4u::findOrFail($ectr4u_id);

        $errors = [];

        $validate_ectr4u = Validator::make($ectr4u->toArray(), [
            'sector_id' => 'required|integer',
            'is_abroad' => 'required|integer',
            'name' => 'required|string',
            'programme_type_id' => 'required|integer',
            'objective' => 'required|string',
            'location' => 'required|string',
            'organizer' => 'required|string',
            'organizer_name' => 'required|string',
            'total_participant' => 'required|integer',
        ]);

        if ($validate_ectr4u->fails())
            $errors = array_merge($errors, $validate_ectr4u->errors()->toArray());

        $errors = ['ectr4u' => $errors];

        return $errors;
    }

    public function complete(Request $request) {
        $ectr4u = Ectr4u::findOrFail($request->id);

        if(auth()->user()->hasRole('ppkpg')) {
            $this->distribute($ectr4u, 'pkpg');
            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan telah diserahkan kepada PKPG.']);
        }
        else {
            $this->distribute($ectr4u, 'ppkpg');
            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan telah diserahkan kepada PPKPG.']);
        }
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $errors = ($this->getErrors($request->id))['ectr4u'];

        //return response()->json(['errors' => $errors], 422);

        if(count($errors) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 15;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini eCTR4U - Hantar Permohonan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $ectr4u = Ectr4u::findOrFail($request->id);
            $ectr4u->filing_status_id = 2;
            $ectr4u->is_editable = 0;
            $ectr4u->save();

            $ectr4u->logs()->updateOrCreate(
                [
                    'module_id' => 15,
                    'activity_type_id' => 11,
                    'filing_status_id' => $ectr4u->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $ectr4u->references()->create([
                'reference_no' => uniqid(),
                'reference_type_id' => 2,
                'module_id' => 15,
            ]);

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($ectr4u, $target) {

        $check = $ectr4u->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "pthq") {
            if($ectr4u->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\Ectr4u')->where('filing_status_id', 2)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $ectr4u->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $ectr4u->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppkpg") {
            if($ectr4u->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',13)->first();

            $ectr4u->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $ectr4u->filing_status_id,
                    'assigned_to_user_id' => $ppkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppkpg->user->email)->send(new Distributed($ectr4u, 'Serahan Permohonan eCTR4U'));
        }
        else if($target == "pkpg") {
            if($ectr4u->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',12)->first();

            $ectr4u->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $ectr4u->filing_status_id,
                    'assigned_to_user_id' => $pkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpg->user->email)->send(new ToBeProcessed($ectr4u, 'Perakuan Permohonan eCTR4U'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $ectr4u = Ectr4u::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) eCTR4U - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('ectr4u.process.document-receive', $ectr4u->id);

        $this->distribute($ectr4u, 'ppkpg');

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) eCTR4U - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $ectr4u = Ectr4u::findOrFail($request->id);
        
        $ectr4u->filing_status_id = 3;
        $ectr4u->save();

        $ectr4u->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 15,
            ]
        );

        $ectr4u->logs()->updateOrCreate(
            [
                'module_id' => 15,
                'activity_type_id' => 12,
                'filing_status_id' => $ectr4u->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($ectr4u, auth()->user()->entity->role->name);
        Mail::to($ectr4u->created_by->email)->send(new Received(auth()->user(), $ectr4u, 'Pengesahan Penerimaan Permohonan eCTR4U'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $ectr4u = Ectr4u::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) eCTR4U - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('ectr4u.process.query.item', $ectr4u->id);
        $route2 = route('ectr4u.process.query', $ectr4u->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $ectr4u = Ectr4u::findOrFail($request->id);

        if(count($ectr4u->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) eCTR4U - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $ectr4u->filing_status_id = 5;
        $ectr4u->is_editable = 1;
        $ectr4u->save();

        $log2 = $ectr4u->logs()->updateOrCreate(
            [
                'module_id' => 15,
                'activity_type_id' => 13,
                'filing_status_id' => $ectr4u->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pkpg')) {
            // Send to PPKPG
            $log = $ectr4u->logs()->where('role_id', 13)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $ectr4u, 'Kuiri Permohonan eCTR4U oleh PKPG'));
        } else {
            // Send to KS
            Mail::to($ectr4u->created_by->email)->send(new Queried(auth()->user(), $ectr4u, 'Kuiri Permohonan eCTR4U'));
        }

        $ectr4u->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 15;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) eCTR4U - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $ectr4u = Ectr4u::findOrFail($request->id);

            $queries = $ectr4u->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $ectr4u = Ectr4u::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 15;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) eCTR4U - Kuiri";
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
            $query = $ectr4u->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 15;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) eCTR4U - Kuiri";
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
        $log->module_id = 15;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) eCTR4U - Kuiri";
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

        $ectr4u = Ectr4u::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) eCTR4U - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $ectr4u->logs()->where('activity_type_id',14)->where('filing_status_id', $ectr4u->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('ectr4u.process.recommend', $ectr4u->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) eCTR4U - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $ectr4u = Ectr4u::findOrFail($request->id);
        $ectr4u->filing_status_id = 6;
        $ectr4u->is_editable = 0;
        $ectr4u->save();

        $ectr4u->logs()->updateOrCreate(
            [
                'module_id' => 15,
                'activity_type_id' => 14,
                'filing_status_id' => $ectr4u->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppkpg'))
            $this->distribute($ectr4u, 'pkpg');

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_status_edit(Request $request) {

        $ectr4u = Ectr4u::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) eCTR4U - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('ectr4u.process.status', $ectr4u->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini eCTR4U - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $ectr4u = Ectr4u::findOrFail($request->id);
        $ectr4u->filing_status_id = 8;
        $ectr4u->save();

        $log = $ectr4u->logs()->create([
                'module_id' => 15,
                'activity_type_id' => 16,
                'filing_status_id' => $ectr4u->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id,
                'data' => $request->status_data,
        ]);
        
        $log->created_at = Carbon::createFromFormat('d/m/Y', $request->status_date)->toDateTimeString();
        $log->save();

        Mail::to($ectr4u->created_by->email)->send(new Incompleted($ectr4u, 'Status Permohonan eCTR4U'));

        if(!auth()->user()->hasRole('pthq'))
            Mail::to($ectr4u->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new Incompleted($ectr4u, 'Status Permohonan eCTR4U'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result(Request $request) {

        $form = $ectr4u = Ectr4u::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) eCTR4U - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("ectr4u.process.result.reject", $form->id);
        $route_approve = route("ectr4u.process.result.approve", $form->id);

        return view('general.modal.result-ctr', compact('route_reject','route_approve'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $ectr4u = Ectr4u::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) eCTR4U - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('ectr4u.process.result.approve', $ectr4u->id);

        return view('general.modal.acknowledge', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) eCTR4U - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $ectr4u = Ectr4u::findOrFail($request->id);
        $ectr4u->filing_status_id = 9;
        $ectr4u->is_editable = 0;
        $ectr4u->save();

        $ectr4u->logs()->updateOrCreate(
            [
                'module_id' => 15,
                'activity_type_id' => 16,
                'filing_status_id' => $ectr4u->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($ectr4u->created_by->email)->send(new Approved($ectr4u, 'Status Permohonan eCTR4U'));
        Mail::to($ectr4u->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new Approved($ectr4u, 'Status Permohonan eCTR4U'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $ectr4u = Ectr4u::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) eCTR4U - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('ectr4u.process.result.reject', $ectr4u->id);

        return view('general.modal.not-acknowledge', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) eCTR4U - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $ectr4u = Ectr4u::findOrFail($request->id);
        $ectr4u->filing_status_id = 8;
        $ectr4u->is_editable = 0;
        $ectr4u->save();

        $ectr4u->logs()->updateOrCreate(
            [
                'module_id' => 15,
                'activity_type_id' => 16,
                'filing_status_id' => $ectr4u->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($ectr4u->created_by->email)->send(new Rejected($ectr4u, 'Status Permohonan eCTR4U'));
        Mail::to($ectr4u->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new Rejected($ectr4u, 'Status Permohonan eCTR4U'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_index(Request $request) {

        $ectr4u = Ectr4u::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 15;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai eCTR4U - Dokumen Sokongan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attachments = [];

        foreach($ectr4u->attachments as $attachment) {
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
                'ectr4u',
                $request->file('file'),
                uniqid().'_'.$request->file('file')->getClientOriginalName()
            );

            $ectr4u = Ectr4u::findOrFail($request->id);

            $attachment = $ectr4u->attachments()->create([
                'name' => $request->file('file')->getClientOriginalName(),
                'url' => $path,
                'created_by_user_id' => auth()->id()
            ]);

            $log = new LogSystem;
            $log->module_id = 15;
            $log->activity_type_id = 4;
            $log->description = "Tambah eCTR4U - Dokumen Sokongan";
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
        $log->module_id = 15;
        $log->activity_type_id = 6;
        $log->description = "Padam eCTR4U - Dokumen Sokongan";
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
}
