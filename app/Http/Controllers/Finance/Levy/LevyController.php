<?php

namespace App\Http\Controllers\Finance\Levy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\FilingModel\FormUExaminer;
use App\FilingModel\FormU;
use App\FilingModel\Levy;
use App\FilingModel\Query;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\Levy\ApprovedKS;
use App\Mail\Levy\ApprovedPWN;
use App\Mail\Levy\Rejected;
use App\Mail\Levy\Sent;
use App\Mail\Levy\NotReceived;
use App\Mail\Levy\DocumentApproved;
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

class LevyController extends Controller
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

        $levy = Levy::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $formu = $levy->formu()->create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $errors_levy = count(($this->getErrors($levy))['levy']);
        $errors_u = count(($this->getErrors($levy))['u']);

    	return view('finance.levy.index', compact('levy', 'formu', 'errors_levy', 'errors_u'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $levy = Levy::findOrFail($request->id);
        $formu = $levy->formu;

        $errors_levy = count(($this->getErrors($levy))['levy']);
        $errors_u = count(($this->getErrors($levy))['u']);

        return view('finance.levy.index', compact('levy', 'formu', 'errors_levy', 'errors_u'));
    }

    /**
     * Show the list of data
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 24;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang PLV";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $levy = Levy::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $levy = $levy->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $levy = $levy->where('filing_status_id', '>', 1)->where(function($levy) {
                    return $levy->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($levy){
                        if(auth()->user()->hasRole('ptw'))
                            return $levy->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $levy->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $levy = $levy->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($levy)
                ->editColumn('tenure.entity.name', function ($levy) {
                    return $levy->tenure->entity->name;
                })
                ->editColumn('tenure.entity.type', function ($levy) {
                    return $levy->tenure->entity_type == "App\\UserUnion" ? 'Kesatuan' : 'Persekutuan';
                })
                ->editColumn('applied_at', function ($levy) {
                    return $levy->applied_at ? date('d/m/Y', strtotime($levy->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($levy) {
                    if($levy->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$levy->status->name.'</span>';
                    else if($levy->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$levy->status->name.'</span>';
                    else if($levy->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$levy->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$levy->status->name.'</span>';
                })
                ->editColumn('letter', function($levy) {
                    $result = "";
                    if($levy->filing_status_id == 9){
                        $result .= letterButton(41, get_class($levy), $levy->id);
                    }
                    elseif($levy->filing_status_id == 8){
                        $result .= letterButton(42, get_class($levy), $levy->id);
                    }
                    return $result;
                    // return '<a href="'.route('levy.pdf', $levy->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i>'.($levy->logs->count() > 0 ? date('d/m/Y', strtotime($levy->logs->first()->created_at)).' - ' : '').$levy->union->name.'</a><br>';
                })
                ->editColumn('action', function ($levy) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($levy)).'\','.$levy->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $levy->is_editable)) && $levy->filing_status_id < 7)
                        $button .= '<a href="'.route('levy.form', $levy->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status('.$levy->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if( ((auth()->user()->hasRole('ptw') && $levy->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $levy->distributions->count() == 3)) && $levy->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$levy->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp', 'kpks']) && $levy->filing_status_id < 8)
                        $button .= '<a onclick="query('.$levy->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp']) && $levy->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$levy->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $levy->filing_status_id < 8)
                        $button .= '<a onclick="process('.$levy->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 24;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang PLV";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }
        return view('finance.levy.list');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function plv1_index(Request $request) {

        $levy = Levy::findOrFail($request->id);

    	return view('finance.levy.plv1.index', compact('levy'));
    }

    /**
     * Show the list of data
     *
     * @return \Illuminate\Http\Response
     */
    public function formu_index(Request $request) {

        $levy = Levy::findOrFail($request->id);
        $formu = $levy->formu;

        return view('finance.levy.formu.index', compact('levy', 'formu'));
    }



    // Examiner CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function examiner_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang U - Butiran Pemeriksa";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $levy = Levy::findOrFail($request->id);
        $formu = $levy->formu;
        $examiners = $formu->examiners;

        return datatables()->of($examiners)
        ->editColumn('examiner.name', function($examiner) {
            return $examiner->name;
        })
        ->editColumn('action', function ($examiner) {
            $button = "";

            $button .= '<a onclick="editExaminer('.$examiner->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
            $button .= '<a onclick="removeExaminer('.$examiner->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

            return $button;
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function examiner_insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $levy = Levy::findOrFail($request->id);
        $formu = $levy->formu;
        $examiner = $formu->examiners()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang U - Butiran Pemeriksa";
        $log->data_new = json_encode($examiner);
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
    public function examiner_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang U - Butiran Pemeriksa";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $examiner = FormUExaminer::findOrFail($request->examiner_id);
        $levy = Levy::findOrFail($request->id);
        $formu = $levy->formu;

        return view('finance.levy.formu.examiner.edit', compact('examiner', 'levy', 'formu'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function examiner_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $examiner = FormUExaminer::findOrFail($request->examiner_id);

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang U - Butiran Pemeriksa";
        $log->data_old = json_encode($examiner);

        $examiner->update($request->all());

        $log->data_new = json_encode($examiner);
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
    public function examiner_delete(Request $request) {

        $examiner = FormUExaminer::findOrFail($request->examiner_id);

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang U - Butiran Pemeriksa";
        $log->data_old = json_encode($examiner);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $examiner->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    // Examiner CRUD END

    private function getErrors($levy) {

        $errors = [];

        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        $validate_levy = Validator::make($levy->toArray(), [
            'objective' => 'required',
            'estimate' => 'required',
            'applied_at' => 'required',
        ]);

        $errors_levy = [];

        if ($validate_levy->fails())
            $errors_levy = array_merge($errors_levy, $validate_levy->errors()->toArray());

        $errors['levy'] = $errors_levy;

        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        $errors_u = [];
        $formu = $levy->formu;

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

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $levy = Levy::findOrFail($request->id);

        $error_list = $this->getErrors($levy);
        $errors = count($error_list['levy']) + count($error_list['u']);
        //return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 24;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Levi - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $levy->logs()->updateOrCreate(
                [
                    'module_id' => 24,
                    'activity_type_id' => 11,
                    'filing_status_id' => $levy->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $levy->filing_status_id = 2;
            $levy->is_editable = 0;
            $levy->save();

            $levy->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 24,
            ]);

            Mail::to($levy->created_by->email)->send(new Sent($levy, 'Permohonan Levi'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($levy, $target) {

        $check = $levy->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($levy->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\Levy')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $levy->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $levy->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($levy->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Levy')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $levy->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $levy->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($levy, 'Serahan Permohonan Levi'));
        }
        else if($target == "pw") {
            if($levy->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $levy->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $levy->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($levy, 'Serahan Permohonan Levi'));
        }
        else if($target == "pthq") {
            if($levy->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\Levy')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $levy->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $levy->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($levy->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Levy')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $levy->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $levy->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($levy, 'Serahan Permohonan Levi'));
        }
        else if($target == "pkpp") {
            if($levy->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $levy->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $levy->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($levy, 'Serahan Permohonan Levi'));
        }
        else if($target == "kpks") {
            if($levy->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $levy->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $levy->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($levy, 'Serahan Permohonan Levi'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $levy = Levy::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Levi - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('levy.process.document-receive', $levy->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Levi - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $levy = Levy::findOrFail($request->id);

        $levy->filing_status_id = 3;
        $levy->save();

        $levy->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 24,
            ]
        );

        $levy->logs()->updateOrCreate(
            [
                'module_id' => 24,
                'activity_type_id' => 12,
                'filing_status_id' => $levy->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($levy, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($levy, 'ppw');
            Mail::to($levy->created_by->email)->send(new Received(auth()->user(), $levy, 'Pengesahan Penerimaan Permohonan Levi'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($levy, 'pphq');
            Mail::to($levy->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $levy, 'Pengesahan Penerimaan Permohonan Levi'));
            Mail::to($levy->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $levy, 'Pengesahan Penerimaan Permohonan Levi'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $levy = Levy::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Levi - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('levy.process.query.item', $levy->id);
        $route2 = route('levy.process.query', $levy->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $levy = Levy::findOrFail($request->id);

        if(count($levy->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Levi - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $levy->filing_status_id = 5;
        $levy->is_editable = 1;
        $levy->save();

        $log2 = $levy->logs()->updateOrCreate(
            [
                'module_id' => 24,
                'activity_type_id' => 13,
                'filing_status_id' => $levy->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $levy->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $levy, 'Kuiri Permohonan Levi oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $levy->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $levy, 'Kuiri Permohonan Levi oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $levy->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $levy, 'Kuiri Permohonan Levi oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($levy->created_by->email)->send(new Queried(auth()->user(), $levy, 'Kuiri Permohonan Levi'));
        }

        $levy->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 24;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Levi - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $levy = Levy::findOrFail($request->id);

            $queries = $levy->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $levy = Levy::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 24;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Levi - Kuiri";
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
            $query = $levy->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 24;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Levi - Kuiri";
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
        $log->module_id = 24;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Levi - Kuiri";
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

        $levy = Levy::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Levi - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $levy->logs()->where('activity_type_id',14)->where('filing_status_id', $levy->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('levy.process.recommend', $levy->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Levi - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $levy = Levy::findOrFail($request->id);
        $levy->filing_status_id = 6;
        $levy->is_editable = 0;
        $levy->save();

        $levy->logs()->updateOrCreate(
            [
                'module_id' => 24,
                'activity_type_id' => 14,
                'filing_status_id' => $levy->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($levy, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($levy, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($levy, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($levy->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $levy, 'Serahan Permohonan Levi'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $levy = Levy::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Levi - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('levy.process.delay', $levy->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Levi - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $levy = Levy::findOrFail($request->id);
        $levy->filing_status_id = 7;
        $levy->is_editable = 0;
        $levy->save();

        $levy->logs()->updateOrCreate(
            [
                'module_id' => 24,
                'activity_type_id' => 15,
                'filing_status_id' => $levy->filing_status_id,
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

        $levy = Levy::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Levi - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('levy.process.status', $levy->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Levi - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $levy = Levy::findOrFail($request->id);

        $log = $levy->logs()->create([
                'module_id' => 24,
                'activity_type_id' => 20,
                'filing_status_id' => $levy->filing_status_id,
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

        $form = $levy = Levy::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Levi - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("levy.process.result.reject", $form->id);
        $route_approve = route("levy.process.result.approve", $form->id);
        $route_delay = route("levy.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $levy = Levy::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Levi - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('levy.process.result.approve', $levy->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Levi - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $levy = Levy::findOrFail($request->id);
        $levy->filing_status_id = 9;
        $levy->is_editable = 0;
        $levy->save();

        $levy->logs()->updateOrCreate(
            [
                'module_id' => 24,
                'activity_type_id' => 16,
                'filing_status_id' => $levy->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($levy->created_by->email)->send(new ApprovedKS($levy, 'Status Permohonan Levi'));

        Mail::to($levy->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($levy, 'Status Permohonan Levi'));
        Mail::to($levy->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($levy, 'Status Permohonan Levi'));
        Mail::to($levy->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($levy, 'Status Permohonan Levi'));
        Mail::to($levy->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($levy, 'Sedia Dokumen Kelulusan Levi'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $levy = Levy::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Levi - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('levy.process.result.reject', $levy->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 24;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Levi - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $levy = Levy::findOrFail($request->id);
        $levy->filing_status_id = 8;
        $levy->is_editable = 0;
        $levy->save();

        $levy->logs()->updateOrCreate(
            [
                'module_id' => 24,
                'activity_type_id' => 16,
                'filing_status_id' => $levy->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($levy->created_by->email)->send(new Rejected($levy, 'Status Permohonan Levi'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function download(Request $request) {

        $filing = Levy::findOrFail($request->id); 
                                                             // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->tenure->entity->name),
            'registration_no' => htmlspecialchars($filing->tenure->entity->registration_no),
            'entity_address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ', '.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars($filing->address->address3) : '').
                ', '.($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars($filing->address->district->name) : '').
                ($filing->address->state ? ', '.htmlspecialchars($filing->address->state->name) : ''),
            'branch_name' => $filing->branch ? htmlspecialchars($filing->branch->name) : '',
            'branch_address' => $filing->branch ? 
                (', '.Shtmlspecialchars($filing->branch->address->address1).
                ($filing->branch->address->address2 ? ', '.htmlspecialchars($filing->branch->address->address2) : '').
                ($filing->branch->address->address3 ? ', '.htmlspecialchars($filing->branch->address->address3) : '').
                ', '.($filing->branch->address->postcode).
                ($filing->branch->address->district ? ' '.htmlspecialchars($filing->branch->address->district->name) : '').
                ($filing->branch->address->state ? ', '.htmlspecialchars($filing->branch->address->state->name) : '')) : '',
            'objective' => htmlspecialchars($filing->objective),
            'estimate' => htmlspecialchars($filing->estimate),
            'meeting_type' => htmlspecialchars('Undi Sulit'),
            'resolved_at' => htmlspecialchars(strftime('%e %B %Y', strtotime($filing->formu->voted_at))), 
        ];

        $log = new LogSystem;
        $log->module_id = 24;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/finance/levy/plv1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang PLV1';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function formu_download(Request $request) {

        $levy = Levy::findOrFail($request->id);
        $filing = $levy->formu;
                                                              // Change here
        $result = $filing->total_voters != 0 ? $filing->total_supporting / $filing->total_voters * 100 : 0;
        $total_return = $filing->total_supporting + $filing->total_against;
        $president = $filing->tenure->officers()->where('designation_id', 1)->first();
        $treasurer = $filing->tenure->officers()->where('designation_id', 5)->first();;

        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->tenure->entity->name),
            'entity_address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ', '.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars($filing->address->address3) : '').
                ', '.($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars($filing->address->district->name) : '').
                ($filing->address->state ? ', '.htmlspecialchars($filing->address->state->name) : ''),
            'registration_no' => htmlspecialchars($filing->tenure->entity->registration_no),
            'branch_name' => $filing->branch ? htmlspecialchars($filing->branch->name) : '',
            'branch_address' => $filing->branch ? 
                (', '.Shtmlspecialchars($filing->branch->address->address1).
                ($filing->branch->address->address2 ? ', '.htmlspecialchars($filing->branch->address->address2) : '').
                ($filing->branch->address->address3 ? ', '.htmlspecialchars($filing->branch->address->address3) : '').
                ', '.($filing->branch->address->postcode).
                ($filing->branch->address->district ? ' '.htmlspecialchars($filing->branch->address->district->name) : '').
                ($filing->branch->address->state ? ', '.htmlspecialchars($filing->branch->address->state->name) : '')) : '',
            'setting' => htmlspecialchars($filing->setting),
            'voted_day' => htmlspecialchars(strftime('%e', strtotime($filing->voted_at))),
            'voted_month_year' => htmlspecialchars(strftime('%B %Y', strtotime($filing->voted_at))),
            'total_voters' => htmlspecialchars($filing->total_voters),
            'total_slips' => htmlspecialchars($filing->total_slips),
            'total_return' => htmlspecialchars($total_return),
            'total_supporting' => htmlspecialchars($filing->total_supporting),
            'total_against' => htmlspecialchars($filing->total_against),
            'result' => htmlspecialchars($result),
            'is_supported' => $filing->is_supported == 1 ? htmlspecialchars('Menang') : htmlspecialchars('Kalah'),
            'president_name' => $president ? htmlspecialchars(strtoupper($president->name)) : '',
            'secretary_name' => htmlspecialchars(strtoupper($filing->tenure->entity->user->name)),
            'treasurer_name' => $treasurer ? htmlspecialchars(strtoupper($treasurer->name)) : '',
            'today_date' =>  htmlspecialchars(strftime('%e %B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 23;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/finance/levy/formu.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table requester
        $rows = $filing->examiners;
        $document->cloneRow('no', count($rows));
        foreach($rows as $index => $row) {
            ;
            if($index == 0)
                $document->setValue('examiners#'.($index+1), 'Pemeriksa-pemeriksa:');
            else
                $document->setValue('examiners#'.($index+1), '');

            $document->setValue('no#'.($index+1), ($index+1));
            $document->setValue('examiner_name#'.($index+1), htmlspecialchars(strtoupper($row->name)));
        }
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang U';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);
       
        return docxToPdf($temp_file);
    }

}
