<?php

namespace App\Http\Controllers\Investigation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\MasterModel\MasterComplaintClassification;
use App\FilingModel\ComplaintInternal;
use App\FilingModel\Query;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\Complaint\Sent;
use App\Mail\Complaint\ResultUpdated;
use App\Mail\Complaint\DistributedPKPP;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;

class ComplaintController extends Controller
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

        $complaint = ComplaintInternal::create([
            'created_by_user_id' => auth()->id(),
            'received_at' => Carbon::now(),
        ]);

        $errors_complaint = count(($this->getErrors($complaint))['complaint']);

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pengendalian Aduan";
        $log->data_new = json_encode($complaint);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('investigation.complaint.index', compact('complaint', 'errors_complaint'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $complaint = ComplaintInternal::findOrFail($request->id);
        $errors_complaint = count(($this->getErrors($complaint))['complaint']);

        return view('investigation.complaint.index', compact('complaint', 'errors_complaint'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 31;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengendalian Aduan";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $complaints = ComplaintInternal::with(['status']);

            if(auth()->user()->hasRole('ptw')) {
                $complaints = $complaints->where('created_by_user_id', auth()->user()->entity->id);
            }
            else if(auth()->user()->hasAnyRole(['pthq'])) {
                $complaints = $complaints->where('filing_status_id', '>', 1)->where(function($complaints) {
                    return $complaints->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($complaints){
                        if(auth()->user()->hasRole('ptw'))
                            return $complaints->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $complaints->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $complaints = $complaints->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($complaints)
                ->editColumn('received_at', function ($complaint) {
                    return $complaint->received_at ? date('d/m/Y', strtotime($complaint->received_at)) : '-';
                })
                ->editColumn('status.name', function ($complaint) {
                    if($complaint->filing_status_id == 9 || $complaint->filing_status_id == 10)
                        return '<span class="badge badge-success">'.$complaint->status->name.'</span>';
                    else if($complaint->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$complaint->status->name.'</span>';
                    else if($complaint->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$complaint->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$complaint->status->name.'</span>';
                })
                ->editColumn('letter', function($complaint) {
                    $result = "";
                    if($complaint->filing_status_id == 9  )
                        $result .= letterButton(58, get_class($complaint), $complaint->id);
                    return $result;
                    // return '<a href="{{ url('files/investigation/memo.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Memo Aduan</a>';
                })
                ->editColumn('action', function ($complaint) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($complaint)).'\','.$complaint->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ptw') && $complaint->is_editable)) && $complaint->filing_status_id < 7 )
                        $button .= '<a href="'.route('investigation.complaint.item.form', $complaint->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ptw','pthq']) && $complaint->filing_status_id > 1)
                        $button .= '<a onclick="status('.$complaint->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if(auth()->user()->hasRole('pthq') && $complaint->distributions->count() == 2 && $complaint->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$complaint->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['pw', 'pkpp', 'kpks']) && $complaint->filing_status_id < 8 )
                        $button .= '<a onclick="query('.$complaint->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw','pphq','pkpp']) && $complaint->filing_status_id < 7 )
                        $button .= '<a onclick="recommend('.$complaint->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $complaint->filing_status_id < 8 )
                        $button .= '<a onclick="process('.$complaint->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 31;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Pengendalian Aduan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('investigation.complaint.list');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Request $request) {

        $complaint = ComplaintInternal::findOrFail($request->id);
        $classifications = MasterComplaintClassification::all();

        return view('investigation.complaint.form', compact('complaint', 'classifications'));
    }

    private function getErrors($complaint) {

        $errors = [];

        if(!$complaint) {
            $errors['complaint'] = [null,null,null,null];
        }
        else {
            $validate_complaint = Validator::make($complaint->toArray(), [
                'complaint_classification_id' => 'required',
                'complaint_by' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'is_member' => 'required|integer',
                'title' => 'required',
                'complaint_against' => 'required',
                'received_at' => 'required',
            ]);

            $errors_complaint = [];

            if ($validate_complaint->fails())
                $errors_complaint = array_merge($errors_complaint, $validate_complaint->errors()->toArray());

            $errors['complaint'] = $errors_complaint;
        }

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $complaint = ComplaintInternal::findOrFail($request->id);

        $errors = ($this->getErrors($complaint))['complaint'];
        //return response()->json(['errors' => $errors], 422);

        if(count($errors) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 31;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Pengendalian Aduan - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $complaint->logs()->updateOrCreate(
                [
                    'module_id' => 31,
                    'activity_type_id' => 11,
                    'filing_status_id' => $complaint->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $complaint->filing_status_id = 3;
            $complaint->is_editable = 0;
            $complaint->save();

            $complaint->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 31,
            ]);

            if($complaint->logs->count() == 1)
                $this->distribute($complaint, 'ppw');

            Mail::to($complaint->created_by->email)->send(new Sent($complaint, 'Notis Aduan'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($complaint, $target) {

        $check = $complaint->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ppw") {
            if($complaint->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\ComplaintInternal')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $complaint->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $complaint->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($complaint, 'Serahan Notis Aduan'));
        }
        else if($target == "pw") {
            if($complaint->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $complaint->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $complaint->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($complaint, 'Serahan Notis Aduan'));
        }
        else if($target == "pthq") {
            if($complaint->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\ComplaintInternal')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $complaint->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $complaint->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($complaint->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\ComplaintInternal')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $complaint->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $complaint->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($complaint, 'Serahan Notis Aduan'));
        }
        else if($target == "pkpp") {
            if($complaint->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $complaint->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $complaint->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new DistributedPKPP($complaint, 'Serahan Notis Aduan'));
        }
        else if($target == "kpks") {
            if($complaint->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $complaint->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $complaint->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($complaint, 'Serahan Notis Aduan'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_status_edit(Request $request) {

        $complaint = ComplaintInternal::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Aduan - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('investigation.complaint.item.process.status', $complaint->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Aduan - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $complaint = ComplaintInternal::findOrFail($request->id);

        $log = $complaint->logs()->create([
                'module_id' => 31,
                'activity_type_id' => 20,
                'filing_status_id' => $complaint->filing_status_id,
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
    public function process_documentReceive_edit(Request $request) {

        $complaint = ComplaintInternal::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Aduan - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('investigation.complaint.item.process.document-receive', $complaint->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Aduan - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $complaint = ComplaintInternal::findOrFail($request->id);

        $complaint->filing_status_id = 3;
        $complaint->save();

        $complaint->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 31,
            ]
        );

        $complaint->logs()->updateOrCreate(
            [
                'module_id' => 31,
                'activity_type_id' => 12,
                'filing_status_id' => $complaint->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($complaint, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($complaint, 'ppw');
            Mail::to($complaint->created_by->email)->send(new Received(auth()->user(), $complaint, 'Pengesahan Penerimaan Notis Aduan'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($complaint, 'pphq');
            Mail::to($complaint->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $complaint, 'Pengesahan Penerimaan Notis Aduan'));
            Mail::to($complaint->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $complaint, 'Pengesahan Penerimaan Notis Aduan'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $complaint = ComplaintInternal::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Aduan - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('investigation.complaint.item.process.query.item', $complaint->id);
        $route2 = route('investigation.complaint.item.process.query', $complaint->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $complaint = ComplaintInternal::findOrFail($request->id);

        if(count($complaint->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Aduan - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $complaint->filing_status_id = 5;
        $complaint->is_editable = 1;
        $complaint->save();

        $log2 = $complaint->logs()->updateOrCreate(
            [
                'module_id' => 31,
                'activity_type_id' => 13,
                'filing_status_id' => $complaint->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $complaint->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $complaint, 'Kuiri Notis Aduan oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $complaint->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $complaint, 'Kuiri Notis Aduan oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $complaint->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $complaint, 'Kuiri Notis Aduan oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($complaint->created_by->email)->send(new Queried(auth()->user(), $complaint, 'Kuiri Notis Aduan'));
        }

        $complaint->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 31;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Aduan - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $complaint = ComplaintInternal::findOrFail($request->id);

            $queries = $complaint->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $complaint = ComplaintInternal::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 31;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Aduan - Kuiri";
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
            $query = $complaint->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 31;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Aduan - Kuiri";
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
        $log->module_id = 31;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Aduan - Kuiri";
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

        $complaint = ComplaintInternal::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Aduan - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $complaint->logs()->where('activity_type_id',14)->where('filing_status_id', $complaint->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('investigation.complaint.item.process.recommend', $complaint->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Aduan - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $complaint = ComplaintInternal::findOrFail($request->id);
        $complaint->filing_status_id = 6;
        $complaint->is_editable = 0;
        $complaint->save();

        $complaint->logs()->updateOrCreate(
            [
                'module_id' => 31,
                'activity_type_id' => 14,
                'filing_status_id' => $complaint->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($complaint, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($complaint, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($complaint, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($complaint->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $complaint, 'Serahan Notis Aduan'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_edit(Request $request) {

        $complaint = ComplaintInternal::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Aduan - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $result = $complaint->logs()->where('activity_type_id',16)->where('filing_status_id', $complaint->filing_status_id)->where('created_by_user_id', auth()->id());

        if($result->count() > 0)
            $result = $result->first();
        else
            $result = new LogFiling;

        $route = route('investigation.complaint.item.process.result', $complaint->id);

        return view('general.modal.result-single', compact('route', 'result'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 31;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Aduan - Keputusan";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $complaint = ComplaintInternal::findOrFail($request->id);
        $complaint->filing_status_id = 10;
        $complaint->is_editable = 0;
        $complaint->save();

        $complaint->logs()->updateOrCreate(
            [
                'module_id' => 31,
                'activity_type_id' => 16,
                'filing_status_id' => $complaint->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($complaint->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new ResultUpdated($complaint, 'Sedia Dokumen Keputusan Aduan'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Keputusan KPKS telah disimpan.']);
    }
}
