<?php

namespace App\Http\Controllers\Finance\Insurance;

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
use App\Mail\Insurance\ApprovedKS;
use App\Mail\Insurance\ApprovedPWN;
use App\Mail\Insurance\Rejected;
use App\Mail\Insurance\Sent;
use App\Mail\Insurance\NotReceived;
use App\Mail\Insurance\DocumentApproved;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\Query;
use App\FilingModel\Insurance;
use App\FilingModel\FormU;
use App\FilingModel\FormUExaminer;
use App\MasterModel\MasterMeetingType;
use App\UserStaff;
use App\User;
use Validator;
use Carbon\Carbon;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class InsuranceController extends Controller
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
            $log->module_id = 23;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang Insurans";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $insurance = Insurance::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $insurance = $insurance->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $insurance = $insurance->where('filing_status_id', '>', 1)->where(function($insurance) {
                    return $insurance->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($insurance){
                        if(auth()->user()->hasRole('ptw'))
                            return $insurance->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $insurance->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $insurance = $insurance->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($insurance)
                ->editColumn('tenure.entity.name', function ($insurance) {
                    return $insurance->tenure->entity->name;
                })
                ->editColumn('entity_type', function ($insurance) {
                    return $insurance->tenure->entity_type == "App\\UserUnion" ? 'Kesatuan' : 'Persekutuan';
                })
                ->editColumn('applied_at', function ($insurance) {
                    return $insurance->applied_at ? date('d/m/Y', strtotime($insurance->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($insurance) {
                    if($insurance->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$insurance->status->name.'</span>';
                    else if($insurance->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$insurance->status->name.'</span>';
                    else if($insurance->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$insurance->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$insurance->status->name.'</span>';
                })
                ->editColumn('letter', function($insurance) {
                    $result = "";
                    if($insurance->filing_status_id == 9){
                        $result .= letterButton(39, get_class($insurance), $insurance->id);
                    }
                    elseif($insurance->filing_status_id == 8){
                        $result .= letterButton(40, get_class($insurance), $insurance->id);
                    }
                    return $result;
                })
                ->editColumn('action', function ($insurance) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($insurance)).'\','.$insurance->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status(1)" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $insurance->is_editable)) && $insurance->filing_status_id < 7)
                        $button .= '<a href="'.route('insurance.form', $insurance->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if( ((auth()->user()->hasRole('ptw') && $insurance->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $insurance->distributions->count() == 3)) && $insurance->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$insurance->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp', 'kpks']) && $insurance->filing_status_id < 8)
                        $button .= '<a onclick="query('.$insurance->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw','pphq','pkpp']) && $insurance->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$insurance->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $insurance->filing_status_id < 8)
                        $button .= '<a onclick="process('.$insurance->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 23;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang Insurans";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }
        return view('finance.insurance.list');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $insurance = Insurance::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $formu = $insurance->formu()->create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $errors_ins1 = count(($this->getErrors($insurance))['ins1']);
        $errors_u = count(($this->getErrors($insurance))['u']);

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Insurans";
        $log->data_new = json_encode($insurance);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('finance.insurance.index', compact('insurance','formu','errors_ins1', 'errors_u'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $insurance = Insurance::findOrFail($request->id);
        $formu = $insurance->formu;

        $errors_ins1 = count(($this->getErrors($insurance))['ins1']);
        $errors_u = count(($this->getErrors($insurance))['u']);

        return view('finance.insurance.index', compact('insurance','formu','errors_ins1', 'errors_u'));
    }

    // Examiner CRUD END

    private function getErrors($insurance) {

        $errors = [];

        //////////////////////////////////////////////////////////////////////////////////////////////////////////

        $validate_ins1 = Validator::make($insurance->toArray(), [
            'meeting_type_id' => 'required|integer',
            'resolved_at' => 'required',
            'total_attendant' => 'required|numeric',
            'total_covered' => 'required|numeric',
            'insurance_type' => 'required|string',
            'insurance_name' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',
            'last_approved_at' => 'required',
            'annual_fee' => 'required|numeric',
            'annual_member_fee' => 'required|numeric',
            'formn_applied_at' => 'required',
        ]);

        $errors_ins1 = [];

        if ($validate_ins1->fails())
            $errors_ins1 = array_merge($errors_ins1, $validate_ins1->errors()->toArray());

        $errors['ins1'] = $errors_ins1;

        //////////////////////////////////////////////////////////////////////////////////////////////////////////

        $errors_formu = [];

        $validate_formu = Validator::make($insurance->formu->toArray(), [
            'setting' => 'required',
            'voted_at' => 'required',
            'total_voters' => 'required|integer',
            'total_slips' => 'required|integer',
            'total_supporting' => 'required|integer',
            'total_against' => 'required|integer',
            'is_supported' => 'required|integer',
        ]);

        if ($validate_formu->fails()) {
            $errors_formu = array_merge($errors_formu, $validate_formu->errors()->toArray());
        }

        $errors['u'] = $errors_formu;

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $insurance = Insurance::findOrFail($request->id);
        $error_list = $this->getErrors($insurance);

        $errors = count($error_list['ins1']) + count($error_list['u']);
        //return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 23;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Insurans - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $insurance->logs()->updateOrCreate(
                [
                    'module_id' => 23,
                    'activity_type_id' => 11,
                    'filing_status_id' => $insurance->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $insurance->filing_status_id = 2;
            $insurance->is_editable = 0;
            $insurance->save();

            $insurance->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 23,
            ]);

            Mail::to($insurance->created_by->email)->send(new Sent($insurance, 'Permohonan Pembayaran Insurans'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar.']);
        }
    }
    

    /**
     * Show the form application.
     *
     * @return \Illuminate\Http\Response
     */
    public function formu_index(Request $request) {

        $insurance = Insurance::findOrFail($request->id);
        $formu = $insurance->formu;

        return view('finance.insurance.formu.index', compact('insurance','formu'));
    }

    // Examiner CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function examiner_index(Request $request) {
        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Pegawai Borang U - Butiran Pemeriksa";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $insurance = Insurance::findOrFail($request->id);
        $examiners = $insurance->formu->examiners;

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

        $insurance = Insurance::findOrFail($request->id);
        $examiner = $insurance->formu->examiners()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 23;
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
        $log->module_id = 23;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang U - Butiran Pemeriksa";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $examiner = FormUExaminer::findOrFail($request->examiner_id);
        $insurance = Insurance::findOrFail($request->id);

        return view('finance.insurance.formu.examiner.edit', compact('examiner', 'insurance'));
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
        $log->module_id = 23;
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
        $log->module_id = 23;
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

    public function ins1_index(Request $request) {

        $insurance = Insurance::findOrFail($request->id);
        $formu = $insurance->formu; 

        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();    

        return view('finance.insurance.ins1.index', compact('insurance','formu','meeting_types'));
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($insurance, $target) {

        $check = $insurance->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($insurance->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\Insurance')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $insurance->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $insurance->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($insurance->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Insurance')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $insurance->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $insurance->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($insurance, 'Serahan Permohonan Pembelian Insurans'));
        }
        else if($target == "pw") {
            if($insurance->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $insurance->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $insurance->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($insurance, 'Serahan Permohonan Pembelian Insurans'));
        }
        else if($target == "pthq") {
            if($insurance->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\Insurance')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $insurance->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $insurance->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($insurance->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Insurance')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $insurance->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $insurance->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($insurance, 'Serahan Permohonan Pembelian Insurans'));
        }
        else if($target == "pkpp") {
            if($insurance->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $insurance->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $insurance->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

           Mail::to($pkpp->user->email)->send(new Distributed($insurance, 'Serahan Permohonan Pembelian Insurans')); 
        }
        else if($target == "kpks") {
            if($insurance->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $insurance->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $insurance->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($insurance, 'Serahan Permohonan Pembelian Insurans'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $insurance = Insurance::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Insurans - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('insurance.process.document-receive', $insurance->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Insurans - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $insurance = Insurance::findOrFail($request->id);

        $insurance->filing_status_id = 3;
        $insurance->save();

        $insurance->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 23,
            ]
        );

        $insurance->logs()->updateOrCreate(
            [
                'module_id' => 23,
                'activity_type_id' => 12,
                'filing_status_id' => $insurance->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($insurance, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($insurance, 'ppw');
            Mail::to($insurance->created_by->email)->send(new Received(auth()->user(), $insurance, 'Pengesahan Penerimaan Permohonan Pembayaran Insurans'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($insurance, 'pphq');
            Mail::to($insurance->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $insurance, 'Pengesahan Penerimaan Permohonan Pembayaran Insurans'));
            Mail::to($insurance->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $insurance, 'Pengesahan Penerimaan Permohonan Pembayaran Insurans'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $insurance = Insurance::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Insurans - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('insurance.process.query.item', $insurance->id);
        $route2 = route('insurance.process.query', $insurance->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $insurance = Insurance::findOrFail($request->id);

        if(count($insurance->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Insurans - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $insurance->filing_status_id = 5;
        $insurance->is_editable = 1;
        $insurance->save();

        $log2 = $insurance->logs()->updateOrCreate(
            [
                'module_id' => 23,
                'activity_type_id' => 13,
                'filing_status_id' => $insurance->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $insurance->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $insurance, 'Kuiri Pembayaran Insurans oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $insurance->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $insurance, 'Kuiri Pembayaran Insurans oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $insurance->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $insurance, 'Kuiri Pembayaran Insurans oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($insurance->created_by->email)->send(new Queried(auth()->user(), $insurance, 'Kuiri Pembayaran Insurans'));
        }

        $insurance->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 23;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Insurans - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $insurance = Insurance::findOrFail($request->id);

            $queries = $insurance->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $insurance = Insurance::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 23;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Insurans - Kuiri";
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
            $query = $insurance->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 23;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Insurans - Kuiri";
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
        $log->module_id = 23;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Insurans - Kuiri";
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

        $insurance = Insurance::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Insurans - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $insurance->logs()->where('activity_type_id',14)->where('filing_status_id', $insurance->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('insurance.process.recommend', $insurance->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Insurans - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $insurance = Insurance::findOrFail($request->id);
        $insurance->filing_status_id = 6;
        $insurance->is_editable = 0;
        $insurance->save();

        $insurance->logs()->updateOrCreate(
            [
                'module_id' => 23,
                'activity_type_id' => 14,
                'filing_status_id' => $insurance->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($insurance, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($insurance, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($insurance, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($insurance->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $insurance, 'Serahan Permohonan Bayaran Insurans'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $insurance = Insurance::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Insurans - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('insurance.process.delay', $insurance->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Insurans - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $insurance = Insurance::findOrFail($request->id);
        $insurance->filing_status_id = 7;
        $insurance->is_editable = 0;
        $insurance->save();

        $insurance->logs()->updateOrCreate(
            [
                'module_id' => 23,
                'activity_type_id' => 15,
                'filing_status_id' => $insurance->filing_status_id,
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

        $insurance = Insurance::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Insurans - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('insurance.process.status', $insurance->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Insurans - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $insurance = Insurance::findOrFail($request->id);

        $log = $insurance->logs()->create([
                'module_id' => 23,
                'activity_type_id' => 20,
                'filing_status_id' => $insurance->filing_status_id,
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

        $form = $insurance = Insurance::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Insurans - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("insurance.process.result.reject", $form->id);
        $route_approve = route("insurance.process.result.approve", $form->id);
        $route_delay = route("insurance.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $insurance = Insurance::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Insurans - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('insurance.process.result.approve', $insurance->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Insurans - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $insurance = Insurance::findOrFail($request->id);
        $insurance->filing_status_id = 9;
        $insurance->is_editable = 0;
        $insurance->save();

        $insurance->logs()->updateOrCreate(
            [
                'module_id' => 23,
                'activity_type_id' => 16,
                'filing_status_id' => $insurance->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($insurance->created_by->email)->send(new ApprovedKS($insurance, 'Status Permohonan Pembayaran Insurans'));

        // Mail::to($insurance->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($insurance, 'Status Permohonan Pembayaran Insurans'));
        // Mail::to($insurance->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($insurance, 'Status Permohonan Pembayaran Insurans'));
        Mail::to($insurance->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($insurance, 'Status Permohonan Pembayaran Insurans'));
        Mail::to($insurance->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($insurance, 'Sedia Dokumen Kelulusan Pembayaran Insurans'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $insurance = Insurance::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Insurans - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('insurance.process.result.reject', $insurance->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 23;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Insurans - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $insurance = Insurance::findOrFail($request->id);
        $insurance->filing_status_id = 8;
        $insurance->is_editable = 0;
        $insurance->save();

        $insurance->logs()->updateOrCreate(
            [
                'module_id' => 23,
                'activity_type_id' => 16,
                'filing_status_id' => $insurance->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($insurance->created_by->email)->send(new Rejected($insurance, 'Status Permohonan Pembayaran Insurans'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function download(Request $request) {

        $filing = Insurance::findOrFail($request->id); 
                                                             // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->tenure->entity->name),
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
            'meeting_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'resolved_at' => htmlspecialchars(strftime('%e %B %Y', strtotime($filing->resolved_at))), 
            'total_attendant' => htmlspecialchars($filing->total_attendant),
            'total_covered' => htmlspecialchars($filing->total_covered),
            'insurance_type' => htmlspecialchars($filing->insurance_type),
            'insurance_name' => htmlspecialchars($filing->insurance_name),
            'annual_fee' => htmlspecialchars($filing->annual_fee),
            'annual_member_fee' => htmlspecialchars($filing->annual_member_fee),
            'start_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->start_date))),
            'end_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->end_date))),
            'last_approved_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->last_approved_at))),
            'formn_applied_at' => htmlspecialchars(date('d/m/Y', strtotime($filing->formn_applied_at))),
            'lu_date' => $filing->tenure->formlu ? htmlspecialchars(date('d/m/Y', strtotime($filing->tenure->formlu->applied_at))) : '-',
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/finance/insurance/ins1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang INS1';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function formu_download(Request $request) {

        $insurance = Insurance::findOrFail($request->id);
        $filing = $insurance->formu;
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/finance/insurance/formu.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table examnier
        $rows = $filing->examiners;
        $document->cloneRow('no', count($rows));
        foreach($rows as $index => $row) {
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
