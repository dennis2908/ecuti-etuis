<?php

namespace App\Http\Controllers\Exception;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\FilingModel\ExceptionPP30Officer;
use App\FilingModel\ExceptionPP30;
use App\FilingModel\Officer;
use App\FilingModel\Query;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\Received;
use App\Mail\PP30\Sent;
use App\Mail\PP30\NotReceived;
use App\Mail\PP30\ResultUpdated;
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

class ExceptionPP30Controller extends Controller
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

        $exception = ExceptionPP30::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $errors_exception = count(($this->getErrors($exception))['exception']);

    	return view('exception.pp30.index', compact('exception', 'errors_exception'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $exception = ExceptionPP30::findOrFail($request->id);

        $errors_exception = count(($this->getErrors($exception))['exception']);

        return view('exception.pp30.index', compact('exception', 'errors_exception'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 35;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengecualian Seksyen 30(b)";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $exception = ExceptionPP30::with(['tenure.entity','status']);

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
                $exception = $exception->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
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
                    else if($exception->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$exception->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$exception->status->name.'</span>';
                })
                ->editColumn('letter', function($exception) {
                    $result = "";
                    if($exception->filing_status_id > 1){
                        $result .= letterButton(72, get_class($exception), $exception->id);
                    }
                    if($exception->filing_status_id == 9){
                        $result .= letterButton(69, get_class($exception), $exception->id);                        
                        $result .= letterButton(70, get_class($exception), $exception->id);
                        $result .= letterButton(71, get_class($exception), $exception->id);
                    }
                    return $result;
                    // return '<a href="{{ url('files/pp30/pp_30_02.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Kelulusan (PP-30-02)</a><br>';
                    // return '<a href="{{ url('files/pp30/pp_30_03.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Kelulusan (PP-30-03)</a><br>';
                    // return '<a href="{{ url('files/pp30/pp_30_04.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Kelulusan (PP-30-04)</a><br>';
                    // return '<a href="{{ url('files/pp30/pp_30_05.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Kelulusan (PP-30-05)</a><br>';
                })
                ->editColumn('action', function ($exception) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($exception)).'\','.$exception->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['pphq']) || (auth()->user()->hasRole('ks') && $exception->is_editable)) && $exception->filing_status_id < 7)
                        $button .= '<a href="'.route('pp30.item', $exception->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status('.$exception->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if(auth()->user()->hasRole('pthq') && $exception->distributions->count() == 0 && $exception->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$exception->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['pphq', 'pkpp', 'kpks']) && $exception->filing_status_id < 8 )
                        $button .= '<a onclick="query('.$exception->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['pphq', 'pkpp']) && $exception->filing_status_id < 7 )
                        $button .= '<a onclick="recommend('.$exception->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $exception->filing_status_id < 8 )
                        $button .= '<a onclick="process('.$exception->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    if(auth()->user()->hasRole('pkpp') && $exception->filing_status_id < 10 )
                        $button .= '<a onclick="minister('.$exception->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Keputusan Menteri</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 35;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Pengecualian Seksyen 30(b)";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('exception.pp30.list');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Request $request) {

        $exception = ExceptionPP30::findOrFail($request->id);
        $tenures = auth()->user()->entity->tenures;
        $officers = $exception->tenure->officers;

        return view('exception.pp30.form', compact('exception', 'tenures', 'officers'));
    }

    // ExceptionPP30Officer CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function officer_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Pengecualian Seksyen 30(b) - Pegawai";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception = ExceptionPP30::findOrFail($request->id);
        $officers = Officer::whereHas('exception_pp30_officer.exception', function($exception) use($request) {
                                return $exception->where('exception_pp30_id', $request->id);
                            });

        return datatables()->of($officers)
            ->editColumn('officer.name', function ($officer) {
                return $officer->name;
            })
            ->editColumn('officer.identification_no', function ($officer) {
                return $officer->identification_no;
            })
            ->editColumn('officer.country.name', function ($officer) {
                return $officer->nationality->name;
            })
            ->editColumn('officer.designation.name', function ($officer) {
                return $officer->designation->name;
            })
            ->editColumn('action', function ($officer) {
                $button = "";

                $button .= '<a onclick="removeOfficer('.$officer->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function officer_insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'officer_id' => 'unique:exception_pp30_officer,officer_id,null,null,exception_pp30_id,'.$request->id,
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $exception = ExceptionPP30::findOrFail($request->id);
        $officer = $exception->officers()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pengecualian Seksyen 30(b) - Pegawai";
        $log->data_new = json_encode($officer);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.']);
    }

    /**
     * Remove the specified resource from storage.
     * @param  Request $request
     * @return Response
     */
    public function officer_delete(Request $request) {

        $officer = ExceptionPP30Officer::where('officer_id', $request->officer_id)->firstOrFail();

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 6;
        $log->description = "Padam Pengecualian Seksyen 30(b) - Pegawai";
        $log->data_old = json_encode($officer);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $officer->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    // ExceptionPP30Officer CRUD END

    private function getErrors($exception) {

        $errors = [];

        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        $validate_exception = Validator::make($exception->toArray(), [
            'requested_at' => 'required',
            'requested_tenure_id' => 'required|integer',
            'total_citizen' => 'required|integer',
            'total_non_citizen' => 'required|integer',
            'applied_at' => 'required',
        ]);

        $errors_exception = [];

        if ($validate_exception->fails())
            $errors_exception = array_merge($errors_exception, $validate_exception->errors()->toArray());

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

        $exception = ExceptionPP30::findOrFail($request->id);

        $error_list = $this->getErrors($exception);
        $errors = count($error_list['exception']);
        //return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 35;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Pengecualian Seksyen 30(b) - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $exception->logs()->updateOrCreate(
                [
                    'module_id' => 35,
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

            $exception->references()->create([
                'reference_no' => uniqid(),
                'reference_type_id' => 2,
                'module_id' => 35,
            ]);

            Mail::to($exception->created_by->email)->send(new Sent($exception, 'Permohonan Pengecualian Peraturan Seksyen 30(b)'));

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

        if($target == "pthq") {
            if($exception->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\ExceptionPP30')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

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
        else if($target == "pphq") {
            if($exception->distributions()->where('filing_status_id', 3)->count() > 1)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\ExceptionPP30')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $exception->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $exception->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($exception, 'Serahan Permohonan Pengecualian Peraturan Seksyen 30(b)'));
        }
        else if($target == "pkpp") {
            if($exception->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $exception->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $exception->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($exception, 'Serahan Permohonan Pengecualian Peraturan Seksyen 30(b)'));
        }
        else if($target == "kpks") {
            if($exception->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $exception->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $exception->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($exception, 'Serahan Permohonan Pengecualian Peraturan Seksyen 30(b)'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_status_edit(Request $request) {

        $exception = ExceptionPP30::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Pengecualian Seksyen 30(b) - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('pp30.process.status', $exception->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengecualian Seksyen 30(b) - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception = ExceptionPP30::findOrFail($request->id);

        $log = $exception->logs()->create([
                'module_id' => 35,
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
    public function process_documentReceive_edit(Request $request) {

        $exception = ExceptionPP30::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pengecualian Seksyen 30(b) - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('pp30.process.document-receive', $exception->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pengecualian Seksyen 30(b) - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception = ExceptionPP30::findOrFail($request->id);

        $exception->filing_status_id = 3;
        $exception->save();

        $exception->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 35,
            ]
        );

        $exception->logs()->updateOrCreate(
            [
                'module_id' => 35,
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
            Mail::to($exception->created_by->email)->send(new Received(auth()->user(), $exception, 'Pengesahan Penerimaan Permohonan Pengecualian Peraturan Seksyen 30(b)'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($exception, 'pphq');
            Mail::to($exception->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $exception, 'Pengesahan Penerimaan Permohonan Pengecualian Peraturan Seksyen 30(b)'));
            Mail::to($exception->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $exception, 'Pengesahan Penerimaan Permohonan Pengecualian Peraturan Seksyen 30(b)'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $exception = ExceptionPP30::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pengecualian Seksyen 30(b) - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('pp30.process.query.item', $exception->id);
        $route2 = route('pp30.process.query', $exception->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $exception = ExceptionPP30::findOrFail($request->id);

        if(count($exception->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pengecualian Seksyen 30(b) - Kuiri";
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
                'module_id' => 35,
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
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $exception, 'Kuiri Permohonan Pengecualian Seksyen 30(b) oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $exception->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $exception, 'Kuiri Permohonan Pengecualian Seksyen 30(b) oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $exception->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $exception, 'Kuiri Permohonan Pengecualian Seksyen 30(b) oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($exception->created_by->email)->send(new Queried(auth()->user(), $exception, 'Kuiri Permohonan Pengecualian Seksyen 30(b)'));
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
            $log->module_id = 35;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Pengecualian Seksyen 30(b) - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $exception = ExceptionPP30::findOrFail($request->id);

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

        $exception = ExceptionPP30::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 35;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Pengecualian Seksyen 30(b) - Kuiri";
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
            $log->module_id = 35;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Pengecualian Seksyen 30(b) - Kuiri";
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
        $log->module_id = 35;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Pengecualian Seksyen 30(b) - Kuiri";
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

        $exception = ExceptionPP30::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pengecualian Seksyen 30(b) - Ulasan / Syor";
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

        $route = route('pp30.process.recommend', $exception->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pengecualian Seksyen 30(b) - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception = ExceptionPP30::findOrFail($request->id);
        $exception->filing_status_id = 6;
        $exception->is_editable = 0;
        $exception->save();

        $exception->logs()->updateOrCreate(
            [
                'module_id' => 35,
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
    public function process_result_edit(Request $request) {

        $exception = ExceptionPP30::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Pengecualian Seksyen 30(b) - Keputusan KPKS";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $result = $exception->logs()->where('activity_type_id',16)->where('filing_status_id', $exception->filing_status_id)->where('created_by_user_id', auth()->id());

        if($result->count() > 0)
            $result = $result->first();
        else
            $result = new LogFiling;

        $route = route('pp30.process.result', $exception->id);

        return view('general.modal.result-single', compact('route', 'result'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengecualian Seksyen 30(b) - Keputusan KPKS";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception = ExceptionPP30::findOrFail($request->id);
        $exception->filing_status_id = 10;
        $exception->is_editable = 0;
        $exception->save();

        $exception->logs()->updateOrCreate(
            [
                'module_id' => 35,
                'activity_type_id' => 16,
                'filing_status_id' => $exception->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($exception->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new ResultUpdated($exception, 'Sedia Dokumen Kelulusan Pengecualian Peraturan Seksyen 30(b)'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Keputusan KPKS telah disimpan.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_minister_edit(Request $request) {

        $exception = ExceptionPP30::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Pengecualian Seksyen 30(b) - Keputusan Menteri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $result = $exception->logs()->where('activity_type_id',21)->where('filing_status_id', $exception->filing_status_id)->where('created_by_user_id', auth()->id());

        if($result->count() > 0)
            $result = $result->first();
        else
            $result = new LogFiling;

        $route = route('pp30.process.minister', $exception->id);

        return view('general.modal.result-minister', compact('route', 'result'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_minister_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 35;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengecualian Seksyen 30(b) - Keputusan Menteri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $exception = ExceptionPP30::findOrFail($request->id);
        $exception->filing_status_id = 10;
        $exception->is_editable = 0;
        $exception->save();

        $exception->logs()->updateOrCreate(
            [
                'module_id' => 35,
                'activity_type_id' => 21,
                'filing_status_id' => $exception->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Keputusan Menteri telah disimpan.']);
    }

    public function download(Request $request) {

        $filing = ExceptionPP30::findOrFail($request->id); 
                                                             // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->tenure->entity->name),
            'registration_no' => htmlspecialchars($filing->tenure->entity->registration_no),
            'address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ',<w:br/>'.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ',<w:br/>'.htmlspecialchars($filing->address->address3) : ''),
            'postcode' => htmlspecialchars($filing->address->postcode),
            'district' => $filing->address->district ? htmlspecialchars($filing->address->district->name) : '',
            'state' => $filing->address->state ? htmlspecialchars($filing->address->state->name) : '',
            'today_date' => htmlspecialchars(strftime('%e %B %Y')),
            'filing_applied_at' => htmlspecialchars(strftime('%e %B %Y', strtotime($filing->applied_at))),
            'tenure' => htmlspecialchars($filing->tenure->start_year).' - '.htmlspecialchars($filing->tenure->end_year),
            'citizen' => htmlspecialchars($filing->total_citizen),
            'non_citizen' => htmlspecialchars($filing->total_non_citizen),
            'president_name' => htmlspecialchars($filing->tenure->officers()->where('designation_id', 1)->first()->name),
        ];

        $log = new LogSystem;
        $log->module_id = 35;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/exception/pp30.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table officer
        $rows2 = $filing->officers;
        $document->cloneRow('no', count($rows2));

        foreach($rows2 as $index => $row2) {

            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('designation#'.($index+1), ($row2->officer->designation ? htmlspecialchars(strtoupper($row2->officer->designation->name)) : ''));
            $document->setValue('officer_name#'.($index+1), htmlspecialchars(strtoupper($row2->officer->name)));
            $document->setValue('identificationno#'.($index+1), htmlspecialchars(strtoupper($row2->officer->identification_no)));
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang PP30';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

}
