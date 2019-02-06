<?php

namespace App\Http\Controllers\Exception;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\FilingModel\ExceptionPP68;
use App\FilingModel\Query;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\Received;
use App\Mail\PP68\Approved;
use App\Mail\PP68\Rejected;
use App\Mail\PP68\Sent;
use App\Mail\PP68\NotReceived;
use App\Mail\PP68\DocumentApproved;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class ExceptionPP68Controller extends Controller
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

        $exception = ExceptionPP68::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $errors_exception = count(($this->getErrors($exception))['exception']);

    	return view('exception.pp68.index', compact('exception', 'errors_exception'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $exception = ExceptionPP68::findOrFail($request->id);

        $errors_exception = count(($this->getErrors($exception))['exception']);

        return view('exception.pp68.index', compact('exception', 'errors_exception'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 36;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengecualian Peraturan 68";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $exception = ExceptionPP68::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $exception = $exception->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $exception = $exception->where('filing_status_id', '>', 1)->where(function($exception) {
                    return $exception->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhereDoesntHave('logs', function($logs) {
                        return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                    });
                });
            }
            else {
                $exception = $exception->whereHas('distributions', function($distributions) {
                    return $distributions->where('filing_status_id', '>', 1)->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($exception)
                ->editColumn('tenure.entity.name', function ($exception) {
                    return $exception->tenure->entity->name;
                })
                ->editColumn('applied_at', function ($exception) {
                    return $exception->applied_at ? date('d/m/Y', strtotime($exception->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($exception) {
                    if($exception->filing_status_id == 9 || $exception->filing_status_id == 10)
                        return '<span class="badge badge-success">'.$exception->status->name.'</span>';
                    else if($exception->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$exception->status->name.'</span>';
                    else if($exception->filing_status_id == 7 || $exception->filing_status_id == 11)
                        return '<span class="badge badge-warning">'.$exception->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$exception->status->name.'</span>';
                })
                ->editColumn('letter', function($exception) {
                    $result = "";
                    if($exception->filing_status_id == 9){
                        $result .= letterButton(72, get_class($exception), $exception->id);
                        $result .= letterButton(73, get_class($exception), $exception->id);
                        $result .= letterButton(74, get_class($exception), $exception->id);
                    }
                    elseif($exception->filing_status_id == 8){
                        $result .= letterButton(76, get_class($exception), $exception->id);
                    }
                    elseif($exception->filing_status_id == 11){
                        $result .= letterButton(75, get_class($exception), $exception->id);
                    }
                    return $result;
                    // return '<a href="{{ url('files/pp68/pp_68_02.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Kelulusan Bersyarat (PP-68-02)</a><br>';
                    // return '<a href="{{ url('files/pp68/pp_68_03.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Pengecualian (PP-68-03)</a><br>';
                    // return '<a href="{{ url('files/pp68/pp_68_04.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Kelulusan (PP-68-04)</a><br>';
                    // return '<a href="{{ url('files/pp68/pp_68_05.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Lulus + Tidak Lulus (PP-68-05)</a><br>';
                    // return '<a href="{{ url('files/pp68/pp_68_06.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Penolakan (PP-68-06)</a><br>';
                })
                ->editColumn('action', function ($exception) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($exception)).'\','.$exception->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['ppw']) || (auth()->user()->hasRole('ks') && $exception->is_editable)) && $exception->filing_status_id < 7)
                        $button .= '<a href="'.route('pp68.form', $exception->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status('.$exception->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if(auth()->user()->hasRole('ptw') && $exception->distributions->count() == 0 && $exception->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$exception->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw']) && $exception->filing_status_id < 8 )
                        $button .= '<a onclick="query('.$exception->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasRole('ppw') && $exception->filing_status_id < 7 )
                        $button .= '<a onclick="recommend('.$exception->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('pw') && $exception->filing_status_id < 8 )
                        $button .= '<a onclick="process('.$exception->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 36;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Pengecualian Peraturan 68";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('exception.pp68.list');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Request $request) {

        $exception = ExceptionPP68::findOrFail($request->id);

        return view('exception.pp68.form', compact('exception'));
    }
    private function getErrors($exception) {

        $errors = [];

        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        $rules = ['applied_at' => 'required'];

        if($exception->is_fee_excepted)
            $rules['justification_fee'] = 'required';

        if($exception->is_receipt_excepted)
            $rules['justification_receipt'] = 'required';

        if($exception->is_computer_excepted)
            $rules['justification_computer'] = 'required';

        if($exception->is_system_excepted)
            $rules['justification_system'] = 'required';

        $validate_exception = Validator::make($exception->toArray(), $rules);

        $errors_exception = [];

        if($validate_exception->fails())
            $errors_exception = array_merge($errors_exception, $validate_exception->errors()->toArray());

        if(!$exception->is_fee_excepted && !$exception->is_receipt_excepted && !$exception->is_computer_excepted && !$exception->is_system_excepted)
            $errors_exception = array_merge($errors_exception, ['exception' => 'Sila pilih sekurang-kurangnya satu jenis pengecualian.']);

        $errors['exception'] = $errors_exception;

        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $exception = ExceptionPP68::findOrFail($request->id);

        $error_list = $this->getErrors($exception);
        $errors = count($error_list['exception']);
        //return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 36;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Pengecualian Peraturan 68 - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $exception->logs()->updateOrCreate(
                [
                    'module_id' => 36,
                    'activity_type_id' => 11,
                    'filing_status_id' => $exception->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $exception->filing_status_id = 2;
            $exception->is_editable = 0;
            $exception->save();

            $exception->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 36,
            ]);

            Mail::to($exception->created_by->email)->send(new Sent($exception, 'Permohonan Pengecualian Peraturan 68'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($exception, $target) {

        $check = $exception->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($exception->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\ExceptionPP68')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $exception->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $exception->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($exception->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\ExceptionPP68')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $exception->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $exception->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($exception, 'Serahan Permohonan Pengecualian Peraturan 68'));
        }
        else if($target == "pw") {
            if($exception->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $exception->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $exception->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($exception, 'Serahan Permohonan Pengecualian Peraturan 68'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $exception = ExceptionPP68::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 36;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pengecualian Peraturan 68 - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('pp68.process.document-receive', $exception->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 36;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pengecualian Peraturan 68 - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception = ExceptionPP68::findOrFail($request->id);

        $exception->filing_status_id = 3;
        $exception->save();

        $exception->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 36,
            ]
        );

        $exception->logs()->updateOrCreate(
            [
                'module_id' => 36,
                'activity_type_id' => 12,
                'filing_status_id' => $exception->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($exception, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($exception, 'ppw');
            Mail::to($exception->created_by->email)->send(new Received(auth()->user(), $exception, 'Pengesahan Penerimaan Permohonan Pengecualian Peraturan 68'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($exception, 'pphq');
            Mail::to($exception->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $exception, 'Pengesahan Penerimaan Permohonan Pengecualian Peraturan 68'));
            Mail::to($exception->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $exception, 'Pengesahan Penerimaan Permohonan Pengecualian Peraturan 68'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $exception = ExceptionPP68::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 36;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pengecualian Peraturan 68 - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('pp68.process.query.item', $exception->id);
        $route2 = route('pp68.process.query', $exception->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $exception = ExceptionPP68::findOrFail($request->id);

        if(count($exception->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 36;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pengecualian Peraturan 68 - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception->filing_status_id = 5;
        $exception->is_editable = 1;
        $exception->save();

        $log2 = $exception->logs()->updateOrCreate(
            [
                'module_id' => 36,
                'activity_type_id' => 13,
                'filing_status_id' => $exception->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $exception->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $exception, 'Kuiri Permohonan Pengecualian Peraturan 68 oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $exception->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $exception, 'Kuiri Permohonan Pengecualian Peraturan 68 oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $exception->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $exception, 'Kuiri Permohonan Pengecualian Peraturan 68 oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($exception->created_by->email)->send(new Queried(auth()->user(), $exception, 'Kuiri Permohonan Pengecualian Peraturan 68'));
        }

        $exception->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 36;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Pengecualian Peraturan 68 - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $exception = ExceptionPP68::findOrFail($request->id);

            $queries = $exception->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $exception = ExceptionPP68::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 36;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Pengecualian Peraturan 68 - Kuiri";
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
            $query = $exception->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 36;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Pengecualian Peraturan 68 - Kuiri";
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
        $log->module_id = 36;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Pengecualian Peraturan 68 - Kuiri";
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

        $exception = ExceptionPP68::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 36;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pengecualian Peraturan 68 - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $exception->logs()->where('activity_type_id',14)->where('filing_status_id', $exception->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('pp68.process.recommend', $exception->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 36;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pengecualian Peraturan 68 - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception = ExceptionPP68::findOrFail($request->id);
        $exception->filing_status_id = 6;
        $exception->is_editable = 0;
        $exception->save();

        $exception->logs()->updateOrCreate(
            [
                'module_id' => 36,
                'activity_type_id' => 14,
                'filing_status_id' => $exception->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($exception, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($exception, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($exception, 'kpks');

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_status_edit(Request $request) {

        $exception = ExceptionPP68::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 36;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Pengecualian Peraturan 68 - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('pp68.process.status', $exception->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 36;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengecualian Peraturan 68 - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception = ExceptionPP68::findOrFail($request->id);

        $log = $exception->logs()->create([
                'module_id' => 36,
                'activity_type_id' => 20,
                'filing_status_id' => $exception->filing_status_id,
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
    public function process_result_edit(Request $request) {

        $exception = ExceptionPP68::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 36;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Pengecualian Seksyen 68 - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('pp68.process.result', $exception->id);

        return view('general.modal.result-pp68', compact('route', 'exception'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_update(Request $request) {

        $rules = [
            'is_fee_approved' => 'required|integer',
            'is_receipt_approved' => 'required|integer',
            'is_computer_approved' => 'required|integer',
            'is_system_approved' => 'required|integer',
        ];

        if($request->is_fee_approved == 0)
            $rules['justification_fee_approved'] = 'required';

        if($request->is_receipt_approved == 0)
            $rules['justification_receipt_approved'] = 'required';

        if($request->is_computer_approved == 0)
            $rules['justification_computer_approved'] = 'required';

        if($request->is_system_approved == 0)
            $rules['justification_system_approved'] = 'required';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $log = new LogSystem;
        $log->module_id = 36;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengecualian Seksyen 68 - Keputusan";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception = ExceptionPP68::findOrFail($request->id);
        $exception->is_editable = 0;
        $exception->save();

        // Checking
        if($request->is_fee_approved == 1 && $request->is_receipt_approved == 1 && $request->is_computer_approved == 1 && $request->is_system_approved == 1)
            $exception->filing_status_id = 9;
        else if($request->is_fee_approved == 0 && $request->is_receipt_approved == 0 && $request->is_computer_approved == 0 && $request->is_system_approved == 0) 
            $exception->filing_status_id = 8;
        else
            $exception->filing_status_id = 11;

        $exception->update($request->all());

        $exception->logs()->updateOrCreate(
            [
                'module_id' => 36,
                'activity_type_id' => 16,
                'filing_status_id' => $exception->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => '1. Pengecualian daripada menyelenggarakan buku daftar yuran mengikut format AP 3 - '.$this->checkResult($request->is_fee_approved).'
'.
                '2. Pengecualian mengeluarkan resit rasmi kepada ahli yang membayar yuran bulanan melalu potongan gaji - '.$this->checkResult($request->is_receipt_approved).'
'.
                '3. Pengecualian daripada menyelenggarakan buku tunai mengikut format AP. 1 secara manual kepada berkomputer - '.$this->checkResult($request->is_system_approved).'
'.
                '4. Pengecualian daripada menyelenggarakan buku tunai mengikut format AP. 1 digantikan dengan sistem perakaunan - '.$this->checkResult($request->is_system_approved)
            ]
        );

        if($request->is_fee_approved == 0 && $request->is_receipt_approved == 0 && $request->is_computer_approved == 0 && $request->is_system_approved == 0)
            Mail::to($exception->created_by->email)->send(new Rejected($exception, 'Status Permohonan Pengecualian Peraturan 68'));
        else
            Mail::to($exception->created_by->email)->send(new Approved($exception, 'Status Permohonan Pengecualian Peraturan 68'));

        Mail::to($exception->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new DocumentApproved($exception, 'Sedia Dokumen Kelulusan Pengecualian Peraturan 68'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Keputusan PW telah disimpan.']);
    }

    private function checkResult($result) {
        return $result ? 'Diluluskan' : 'Tidak Diluluskan';
    }

    public function download(Request $request) {

        $filing = ExceptionPP68::findOrFail($request->id); 
                                                             // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->tenure->entity->name),
            'registration_no' => htmlspecialchars($filing->tenure->entity->registration_no),
            'entity_address' => htmlspecialchars(ucwords($filing->address->address1)).
                ($filing->address->address2 ? ', '.htmlspecialchars(ucwords($filing->address->address2)) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars(ucwords($filing->address->address3)) : '').
                ', '.htmlspecialchars($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars(ucwords($filing->address->district->name)) : '').
                ($filing->address->state ? ', '.htmlspecialchars(ucwords($filing->address->state->name)) : ''),
            'is_fee' => $filing->is_fee_excepted == '1' ? htmlspecialchars('/') : '',
            'justification_fee' => htmlspecialchars($filing->justification_fee),
            'is_receipt' => $filing->is_receipt_excepted == '1' ? htmlspecialchars('/') : '',
            'justification_receipt' => htmlspecialchars($filing->justification_receipt), 
            'is_computer' => $filing->is_computer_excepted == '1' ? htmlspecialchars('/') : '', 
            'justification_computer' => htmlspecialchars($filing->justification_computer),
            'is_system' => $filing->is_system_excepted == '1' ? htmlspecialchars('/') : '', 
            'justification_system' => htmlspecialchars($filing->justification_system),
        ];

        $log = new LogSystem;
        $log->module_id = 36;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/exception/pp68.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang PP68';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
