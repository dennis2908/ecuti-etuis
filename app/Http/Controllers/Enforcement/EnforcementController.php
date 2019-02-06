<?php

namespace App\Http\Controllers\Enforcement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FilingModel\Enforcement;
use App\MasterModel\MasterUserType;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterState;
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
use App\Mail\Enforcement\Sent;
use App\Mail\Enforcement\ResultUpdated;
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

class EnforcementController extends Controller
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

        $types = MasterUserType::whereIn('id', [3,4])->get();
        $states = MasterState::all();
        $districts = MasterDistrict::all();
        $users = User::whereIn('user_type_id', [3,4])->get()->filter(function($user) {
            return $user->hasAnyRole(['union','federation']);
        });

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang Pemeriksaan Berkanun";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $enforcement = Enforcement::with(['state','district','entity']);

            if(auth()->user()->hasRole('ppw')) {
                $enforcement = $enforcement->where('created_by_user_id', auth()->id());
            }
            else if(auth()->user()->hasAnyRole(['pthq'])) {
                $enforcement = $enforcement->where(function($enforcement) {
                    return $enforcement->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($enforcement){
                        return $enforcement->whereHas('logs', function($logs) {
                            return $logs->where('role_id', 8)->where('activity_type_id', 14);
                        });
                    });
                });
            }
            else {
                $enforcement = $enforcement->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }
            
            return datatables()->of($enforcement)
                ->editColumn('start_date', function ($enforcement) {
                    return $enforcement->start_date ? date('d/m/Y', strtotime($enforcement->start_date)) : date('d/m/Y');
                })
                ->editColumn('location', function ($enforcement) {
                    return $enforcement->district->name.', '.$enforcement->state->name;
                })
                ->editColumn('status.name', function ($enforcement) {
                    if($enforcement->filing_status_id == 10)
                        return '<span class="badge badge-success">'.$enforcement->status->name.'</span>';
                    else if($enforcement->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$enforcement->status->name.'</span>';
                    else if($enforcement->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$enforcement->status->name.'</span>';
                    else if($enforcement->filing_status_id == 1)
                        return '<span class="badge badge-default">Perlu Pengesahan</span>';
                    else if($enforcement->filing_status_id == 2)
                        return '<span class="badge badge-default">Penyediaan Laporan</span>';
                    else
                        return '<span class="badge badge-default">'.$enforcement->status->name.'</span>';
                })
                ->editColumn('letter', function($enforcement) {
                    $result = "";
                    if($enforcement->filing_status_id > 1 )
                        $result .= letterButton(49, get_class($enforcement), $enforcement->id);
                    if($enforcement->filing_status_id == 3 )
                        $result .= letterButton(50, get_class($enforcement), $enforcement->id);
                    if($enforcement->filing_status_id == 10)
                        $result .= letterButton(51, get_class($enforcement), $enforcement->id);
                    return $result;
                })
                ->editColumn('action', function ($enforcement) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($enforcement)).'\','.$enforcement->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if( $letter = $enforcement->letters()->where('letter_type_id', 49)->first() )
                        if( $letter->attachment ) {
                            if(auth()->user()->hasAnyRole(['ppw','pphq']) && $enforcement->is_editable && $enforcement->filing_status_id < 7)  
                                $button .= '<a href="'.route('enforcement.form', $enforcement->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';

                            if(auth()->user()->hasRole('pthq') && $enforcement->distributions->count() == 2 && $enforcement->filing_status_id > 1 && $enforcement->filing_status_id < 7)
                                $button .= '<a onclick="receive('.$enforcement->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                            
                            if(auth()->user()->hasAnyRole(['pw','kpks']) && $enforcement->filing_status_id > 1 && $enforcement->filing_status_id < 8)   
                                $button .= '<a onclick="query('.$enforcement->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                            
                            if(auth()->user()->hasAnyRole(['pw','pphq', 'pkpp']) && $enforcement->filing_status_id > 1 && $enforcement->filing_status_id < 7)
                                $button .= '<a onclick="recommend('.$enforcement->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                            
                            if(auth()->user()->hasAnyRole(['pthq']) && $enforcement->filing_status_id > 1)
                                $button .= '<a onclick="status('.$enforcement->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';

                            if(auth()->user()->hasRole('kpks') && $enforcement->filing_status_id > 1 && $enforcement->filing_status_id < 8)
                                $button .= '<a onclick="process('.$enforcement->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                        }
                    
                    if(auth()->user()->hasRole('pw') && $enforcement->filing_status_id < 2)
                        $button .= '<a onclick="process_pw('.$enforcement->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    return $button;
                })
                ->make(true);

        }
        else {
            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang Pemeriksaan Berkanun";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('enforcement.list', compact('users','states','districts','types'));
    }

    public function insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'start_at' => 'required',
            'end_at' => 'required',
            'district_id' => 'required|integer',
            'state_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($request->user_id);

        $request->request->add([
            'entity_type' => $user->entity_type,
            'entity_id' => $user->entity_id,
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_at)->toDateString(),
            'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_at)->toDateString(),
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
            'is_editable' => 0,
            'filing_status_id' => 1,
        ]);

        $enforcement = Enforcement::create($request->all());

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Pemeriksaan Berkanun - Sesi Pemeriksaan";
        $log->data_new = json_encode($enforcement);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $enforcement->logs()->updateOrCreate(
            [
                'module_id' => 29,
                'activity_type_id' => 4,
                'filing_status_id' => $enforcement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->roles->last()->id,
            ],
            [
                'data' => json_encode($enforcement)
            ]
        );

        $enforcement->distributions()->updateOrCreate(
            [
                'filing_status_id' => $enforcement->filing_status_id,
                'assigned_to_user_id' => auth()->id(),
            ],
            [
                'updated_at' => Carbon::now()
            ]
        );

        $this->distribute($enforcement, 'pw');

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.']);
    }

    public function index(Request $request){

        $enforcement = Enforcement::findOrFail($request->id);
        $error_list = $this->getErrors($enforcement);   
        return view('enforcement.index', compact('enforcement','error_list'));
    }

    private function getErrors($enforcement) {

        $errors = [];

        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        $errors_enforcement = [];

        if($enforcement->pbp2) {
            $validate_enforcement = Validator::make($enforcement->pbp2->toArray(), [
                'investigation_date' => 'required',
                'comment' => 'required|string',
                'location' => 'required|string',
                'is_monthly_maintained' => 'required',
                'province_office_id' => 'required|integer',
                'last_meeting_at' => 'required',
                'tenure_start' => 'required',
                'tenure_end' => 'required',
                'last_election_at' => 'required',
                'address_type_id' => 'required|integer',
                'total_examiner' => 'required|integer',
            ]);

            if($validate_enforcement->fails())
                $errors_enforcement = array_merge_recursive($errors_enforcement, $validate_enforcement->errors()->toArray());
        }
        else {
            $errors_enforcement = array_merge_recursive($errors_enforcement, range(1,5));
        }
        // If has branch
        if($enforcement->a5->count() != $enforcement->entity->branches->count())
            $errors_enforcement = array_merge_recursive($errors_enforcement, ['a5' => 'Sila isi lampiran A5.']);


        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        $errors['enforcement'] = $errors_enforcement;
        // dd($enforcement->a5->count());
        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $enforcement = Enforcement::findOrFail($request->id);
        $error_list = $this->getErrors($enforcement);

        if(count($error_list['enforcement']) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Pemeriksaan Berkanun - Hantar Borang";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $enforcement->logs()->updateOrCreate(
                [
                    'module_id' => 29,
                    'activity_type_id' => 11,
                    'filing_status_id' => $enforcement->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $enforcement->filing_status_id = 3;
            $enforcement->is_editable = 0;
            $enforcement->save();

            $enforcement->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 29,
            ]);

            Mail::to($enforcement->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new Sent($enforcement, 'Serahan Laporan Pemeriksaan Berkanun'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Laporan anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($enforcement, $target) {

        $check = $enforcement->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "pw") {
            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $enforcement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $enforcement->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($enforcement, 'Cadangan Tarikh Pemeriksaan Berkanun'));
        }
        else if($target == "pthq") {
            if($enforcement->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\Enforcement')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $enforcement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $enforcement->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($enforcement->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Enforcement')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $enforcement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $enforcement->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($enforcement, 'Serahan Laporan Pemeriksaan Berkanun'));
        }
        else if($target == "pkpp") {
            if($enforcement->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $enforcement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $enforcement->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($enforcement, 'Serahan Laporan Pemeriksaan Berkanun'));
        }
        else if($target == "kpks") {
            if($enforcement->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $enforcement->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $enforcement->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($enforcement, 'Serahan Laporan Pemeriksaan Berkanun'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $enforcement = Enforcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pemeriksaan Berkanun - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('enforcement.process.document-receive', $enforcement->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pemeriksaan Berkanun - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $enforcement = Enforcement::findOrFail($request->id);

        $enforcement->filing_status_id = 3;
        $enforcement->save();

        $enforcement->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 29,
            ]
        );

        $enforcement->logs()->updateOrCreate(
            [
                'module_id' => 29,
                'activity_type_id' => 12,
                'filing_status_id' => $enforcement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($enforcement, auth()->user()->entity->role->name);

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $enforcement = Enforcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pemeriksaan Berkanun - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('enforcement.process.query.item', $enforcement->id);
        $route2 = route('enforcement.process.query', $enforcement->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $enforcement = Enforcement::findOrFail($request->id);

        if(count($enforcement->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pemeriksaan Berkanun - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $enforcement->filing_status_id = 5;
        $enforcement->is_editable = 1;
        $enforcement->save();

        $log2 = $enforcement->logs()->updateOrCreate(
            [
                'module_id' => 29,
                'activity_type_id' => 13,
                'filing_status_id' => $enforcement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $enforcement->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $enforcement, 'Kuiri Permohonan Pemeriksaan Berkanun oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $enforcement->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $enforcement, 'Kuiri Permohonan Pemeriksaan Berkanun oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $enforcement->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $enforcement, 'Kuiri Permohonan Pemeriksaan Berkanun oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($enforcement->created_by->email)->send(new Queried(auth()->user(), $enforcement, 'Kuiri Permohonan Pemeriksaan Berkanun'));
        }

        $enforcement->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 29;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Pemeriksaan Berkanun - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $enforcement = Enforcement::findOrFail($request->id);

            $queries = $enforcement->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $enforcement = Enforcement::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Pemeriksaan Berkanun - Kuiri";
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
            $query = $enforcement->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 29;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Pemeriksaan Berkanun - Kuiri";
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
        $log->module_id = 29;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Pemeriksaan Berkanun - Kuiri";
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

        $enforcement = Enforcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pemeriksaan Berkanun - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $enforcement->logs()->where('activity_type_id',14)->where('filing_status_id', $enforcement->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('enforcement.process.recommend', $enforcement->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pemeriksaan Berkanun - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $enforcement = Enforcement::findOrFail($request->id);
        $enforcement->filing_status_id = 6;
        $enforcement->is_editable = 0;
        $enforcement->save();

        $enforcement->logs()->updateOrCreate(
            [
                'module_id' => 29,
                'activity_type_id' => 14,
                'filing_status_id' => $enforcement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('pphq'))
            $this->distribute($enforcement, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($enforcement, 'kpks');

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $enforcement = Enforcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pemeriksaan Berkanun - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('enforcement.process.delay', $enforcement->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pemeriksaan Berkanun - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $enforcement = Enforcement::findOrFail($request->id);
        $enforcement->filing_status_id = 7;
        $enforcement->is_editable = 0;
        $enforcement->save();

        $enforcement->logs()->updateOrCreate(
            [
                'module_id' => 29,
                'activity_type_id' => 15,
                'filing_status_id' => $enforcement->filing_status_id,
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

        $enforcement = Enforcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Pemeriksaan Berkanun - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('enforcement.process.status', $enforcement->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pemeriksaan Berkanun - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $enforcement = Enforcement::findOrFail($request->id);
        $enforcement->filing_status_id = 10;
        $enforcement->is_editable = 0;
        $enforcement->save();

        $log = $enforcement->logs()->create([
                'module_id' => 29,
                'activity_type_id' => 20,
                'filing_status_id' => $enforcement->filing_status_id,
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

        $form = $enforcement = Enforcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pemeriksaan Berkanun - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_result = route("enforcement.process.result-kpks", $form->id);
        $route_delay = route("enforcement.process.delay", $form->id);

        return view('general.modal.result-enforcement', compact('route_result','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_edit(Request $request) {

        $enforcement = Enforcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Pemeriksaan Berkanun - Keputusan KPKS";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $result = $enforcement->logs()->where('activity_type_id',16)->where('filing_status_id', $enforcement->filing_status_id)->where('created_by_user_id', auth()->id());

        if($result->count() > 0)
            $result = $result->first();
        else
            $result = new LogFiling;

        $route = route('enforcement.process.result-kpks', $enforcement->id);

        return view('general.modal.result-single', compact('route', 'result'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pemeriksaan Berkanun - Keputusan";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $enforcement = Enforcement::findOrFail($request->id);
        $enforcement->filing_status_id = 10;
        $enforcement->is_editable = 0;
        $enforcement->save();

        $enforcement->logs()->updateOrCreate(
            [
                'module_id' => 29,
                'activity_type_id' => 16,
                'filing_status_id' => $enforcement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );
        
        Mail::to($enforcement->entity->user->email)->send(new ResultUpdated($enforcement, 'Notis Pematuhan Pemeriksaan Berkanun'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Keputusan KPKS telah disimpan.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_pw(Request $request) {

        $form = $enforcement = Enforcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pemeriksaan Berkanun - Keputusan PW";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("enforcement.process.result-pw.reject", $form->id);
        $route_approve = route("enforcement.process.result-pw.approve", $form->id);

        return view('general.modal.result-only', compact('route_reject','route_approve'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_pw_approve_edit(Request $request) {

        $enforcement = Enforcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pemeriksaan Berkanun - Keputusan PW Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('enforcement.process.result-pw.approve', $enforcement->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_pw_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pemeriksaan Berkanun - Keputusan PW Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $enforcement = Enforcement::findOrFail($request->id);
        $enforcement->filing_status_id = 2;
        $enforcement->is_editable = 1;
        $enforcement->save();

        $enforcement->logs()->updateOrCreate(
            [
                'module_id' => 29,
                'activity_type_id' => 16,
                'filing_status_id' => $enforcement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Cadangan sesi Pemeriksaan Berkanun diluluskan.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_pw_reject_edit(Request $request) {

        $enforcement = Enforcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Pemeriksaan Berkanun - Keputusan PW Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('enforcement.process.result-pw.reject', $enforcement->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_pw_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 29;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Pemeriksaan Berkanun - Keputusan PW Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $enforcement = Enforcement::findOrFail($request->id);
        $enforcement->filing_status_id = 8;
        $enforcement->is_editable = 0;
        $enforcement->save();

        $enforcement->logs()->updateOrCreate(
            [
                'module_id' => 29,
                'activity_type_id' => 16,
                'filing_status_id' => $enforcement->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Cadangan sesi Pemeriksaan Berkanun ditolak.']);
    }


}
