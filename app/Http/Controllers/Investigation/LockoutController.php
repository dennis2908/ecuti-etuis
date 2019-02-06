<?php

namespace App\Http\Controllers\Investigation;

use Illuminate\Http\Request;
use App\MasterModel\MasterState;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\FilingModel\FormUExaminer;
use App\FilingModel\Lockout;
use App\FilingModel\Period;
use App\FilingModel\FormU;
use App\OtherModel\Address;
use App\OtherModel\Attachment;
use App\FilingModel\Query;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\Lockout\ApprovedKS;
use App\Mail\Lockout\ApprovedPWN;
use App\Mail\Lockout\Rejected;
use App\Mail\Lockout\Sent;
use App\Mail\Lockout\NotReceived;
use App\Mail\Lockout\DocumentApproved;
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

class LockoutController extends Controller
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
        
        $address = Address::create([]);
        $lockout = Lockout::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'employer_address_id' => $address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $formu = $lockout->formu()->create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $errors_lockout = count(($this->getErrors($lockout))['lockout']);
        $errors_u = count(($this->getErrors($lockout))['u']);

    	return view('investigation.lockout.index', compact('lockout', 'formu', 'errors_lockout', 'errors_u'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $lockout = Lockout::findOrFail($request->id);
        $formu = $lockout->formu;

        $errors_lockout = count(($this->getErrors($lockout))['lockout']);
        $errors_u = count(($this->getErrors($lockout))['u']);

        return view('investigation.lockout.index', compact('lockout', 'formu', 'errors_lockout', 'errors_u'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 53;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengendalian Tutup Pintu";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $lockout = Lockout::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $lockout = $lockout->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $lockout = $lockout->where('filing_status_id', '>', 1)->where(function($lockout) {
                    return $lockout->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($lockout){
                        if(auth()->user()->hasRole('ptw'))
                            return $lockout->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $lockout->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $lockout = $lockout->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($lockout)
                ->editColumn('tenure.entity.name', function ($lockout) {
                    return $lockout->tenure->entity->name;
                })
                ->editColumn('applied_at', function ($lockout) {
                    return $lockout->applied_at ? date('d/m/Y', strtotime($lockout->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($lockout) {
                    if($lockout->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$lockout->status->name.'</span>';
                    else if($lockout->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$lockout->status->name.'</span>';
                    else if($lockout->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$lockout->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$lockout->status->name.'</span>';
                })
                ->editColumn('letter', function($lockout) {
                    $result = "";
                    if($lockout->filing_status_id == 9  )
                        $result .= letterButton(60, get_class($lockout), $lockout->id);
                    return $result;
                    // return '<a href="{{ url('files/investigation/larangan_Tutup Pintu.pdf') }}" class="btn btn-xs btn-default mb-1 text-capitalize pull-right"><i class="fa fa-download mr-1"></i>Surat Ketidakpatuhan</a>';
                })
                ->editColumn('action', function ($lockout) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($lockout)).'\','.$lockout->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['ptw', 'ppw', 'pphq']) || (auth()->user()->hasRole('ks') && $lockout->is_editable)) && $lockout->filing_status_id < 7)
                        $button .= '<a href="'.route('lockout.form', $lockout->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status('.$lockout->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if( ((auth()->user()->hasRole('ptw') && $lockout->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $lockout->distributions->count() == 3)) && $lockout->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$lockout->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp']) && $lockout->filing_status_id < 8)
                        $button .= '<a onclick="query('.$lockout->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp']) && $lockout->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$lockout->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $lockout->filing_status_id < 8)
                        $button .= '<a onclick="process('.$lockout->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 53;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Pengendalian Tutup Pintu";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('investigation.lockout.list');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function lockout_index(Request $request) {

        $lockout = Lockout::findOrFail($request->id);
        $states = MasterState::all();

        return view('investigation.lockout.form', compact('lockout', 'states'));
    }

    // Period CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function period_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Pengendalian Tutup Pintu - Tempoh Tutup Pintu";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $lockout = Lockout::findOrFail($request->id);
        $period = $lockout->periods;

        return datatables()->of($period)
            ->editColumn('start_date', function ($period) {
                return date('d/m/Y', strtotime($period->start_date));
            })
            ->editColumn('end_date', function ($period) {
                return date('d/m/Y', strtotime($period->end_date));
            })
            ->editColumn('action', function ($period) {
                $button = "";

                $button .= '<a onclick="editPeriod('.$period->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                $button .= '<a onclick="removePeriod('.$period->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function period_insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lockout = Lockout::findOrFail($request->id);
        $period = $lockout->periods()->create([
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString(),
            'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateTimeString(),
        ]);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pengendalian Tutup Pintu - Tempoh Tutup Pintu";
        $log->data_new = json_encode($period);
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
    public function period_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Pengendalian Tutup Pintu - Tempoh Tutup Pintu";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $period = Period::findOrFail($request->period_id);
        $lockout = Lockout::findOrFail($request->id);

        return view('investigation.lockout.period.edit', compact('period', 'lockout'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function period_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $period = Period::findOrFail($request->period_id);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengendalian Tutup Pintu - Butiran Pemeriksa";
        $log->data_old = json_encode($period);

        $period->update([
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString(),
            'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateTimeString(),
        ]);

        $log->data_new = json_encode($period);
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
    public function period_delete(Request $request) {

        $period = Period::findOrFail($request->period_id);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 6;
        $log->description = "Padam Pengendalian Tutup Pintu - Tempoh Tutup Pintu";
        $log->data_old = json_encode($period);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $period->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    // Period CRUD END

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function formu_index(Request $request) {

        $lockout = Lockout::findOrFail($request->id);
        $formu = $lockout->formu;

        return view('investigation.lockout.formu.index', compact('lockout', 'formu'));
    }

    // Examiner CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function examiner_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Pengendalian Tutup Pintu - Butiran Pemeriksa";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $lockout = Lockout::findOrFail($request->id);
        $formu = $lockout->formu;
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

        $lockout = Lockout::findOrFail($request->id);
        $formu = $lockout->formu;
        $examiner = $formu->examiners()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pengendalian Tutup Pintu - Butiran Pemeriksa";
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
        $log->module_id = 53;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Pengendalian Tutup Pintu - Butiran Pemeriksa";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $examiner = FormUExaminer::findOrFail($request->examiner_id);
        $lockout = Lockout::findOrFail($request->id);
        $formu = $lockout->formu;

        return view('investigation.lockout.formu.examiner.edit', compact('examiner', 'lockout', 'formu'));
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
        $log->module_id = 53;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengendalian Tutup Pintu - Butiran Pemeriksa";
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
        $log->module_id = 53;
        $log->activity_type_id = 6;
        $log->description = "Padam Pengendalian Tutup Pintu - Butiran Pemeriksa";
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

    private function getErrors($lockout) {

        $errors = [];

        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        $validate_lockout = Validator::make($lockout->toArray(), [
            'employer' => 'required',
            'address_lockout' => 'required',
            'phone_president' => 'required',
            'phone_secretary' => 'required',
            'phone_treasurer' => 'required',
            'applied_at' => 'required',
        ]);

        $errors_lockout = [];

        if ($validate_lockout->fails())
            $errors_lockout = array_merge($errors_lockout, $validate_lockout->errors()->toArray());

        if ($lockout->periods->count() == 0)
            $errors_lockout = array_merge($errors_lockout, ['periods' => 'Sila isi sekurang-kurangnya satu (1) tempoh tutup pintu.']);

        $validate_address = Validator::make($lockout->employer_address->toArray(), [
            'address1' => 'required',
            'postcode' => 'required|digits:5',
            'district_id' => 'required|integer',
            'state_id' => 'required|integer',
        ]);

        if ($validate_address->fails())
            $errors_lockout = array_merge($errors_lockout, $validate_address->errors()->toArray());

        $errors['lockout'] = $errors_lockout;

        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        $errors_u = [];
        $formu = $lockout->formu;

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

        $lockout = Lockout::findOrFail($request->id);

        $error_list = $this->getErrors($lockout);
        $errors = count($error_list['lockout']) + count($error_list['u']);
        //return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 53;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Pengendalian Tutup Pintu - Hantar Permohonan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $lockout->logs()->updateOrCreate(
                [
                    'module_id' => 53,
                    'activity_type_id' => 11,
                    'filing_status_id' => $lockout->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $lockout->filing_status_id = 2;
            $lockout->is_editable = 0;
            $lockout->save();

            $lockout->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 53,
            ]);

            Mail::to($lockout->created_by->email)->send(new Sent($lockout, 'Permohonan Tutup Pintu'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($lockout, $target) {

        $check = $lockout->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($lockout->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\Lockout')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $lockout->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $lockout->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($lockout->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Lockout')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $lockout->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $lockout->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($lockout, 'Serahan Permohonan Tutup Pintu'));
        }
        else if($target == "pw") {
            if($lockout->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $lockout->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $lockout->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($lockout, 'Serahan Permohonan Tutup Pintu'));
        }
        else if($target == "pthq") {
            if($lockout->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\Lockout')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $lockout->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $lockout->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($lockout->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Lockout')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $lockout->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $lockout->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($lockout, 'Serahan Permohonan Tutup Pintu'));
        }
        else if($target == "pkpp") {
            if($lockout->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $lockout->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $lockout->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($lockout, 'Serahan Permohonan Tutup Pintu'));
        }
        else if($target == "kpks") {
            if($lockout->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $lockout->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $lockout->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($lockout, 'Serahan Permohonan Tutup Pintu'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $lockout = Lockout::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Tutup Pintu - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('lockout.process.document-receive', $lockout->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Tutup Pintu - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $lockout = Lockout::findOrFail($request->id);

        $lockout->filing_status_id = 3;
        $lockout->save();

        $lockout->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 53,
            ]
        );

        $lockout->logs()->updateOrCreate(
            [
                'module_id' => 53,
                'activity_type_id' => 12,
                'filing_status_id' => $lockout->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($lockout, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($lockout, 'ppw');
            Mail::to($lockout->created_by->email)->send(new Received(auth()->user(), $lockout, 'Pengesahan Penerimaan Permohonan Tutup Pintu'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($lockout, 'pphq');
            Mail::to($lockout->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $lockout, 'Pengesahan Penerimaan Permohonan Tutup Pintu'));
            Mail::to($lockout->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $lockout, 'Pengesahan Penerimaan Permohonan Tutup Pintu'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $lockout = Lockout::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Tutup Pintu - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('lockout.process.query.item', $lockout->id);
        $route2 = route('lockout.process.query', $lockout->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $lockout = Lockout::findOrFail($request->id);

        if(count($lockout->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Tutup Pintu - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $lockout->filing_status_id = 5;
        $lockout->is_editable = 1;
        $lockout->save();

        $log2 = $lockout->logs()->updateOrCreate(
            [
                'module_id' => 53,
                'activity_type_id' => 13,
                'filing_status_id' => $lockout->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $lockout->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $lockout, 'Kuiri Permohonan Tutup Pintu oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $lockout->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $lockout, 'Kuiri Permohonan Tutup Pintu oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $lockout->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $lockout, 'Kuiri Permohonan Tutup Pintu oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($lockout->created_by->email)->send(new Queried(auth()->user(), $lockout, 'Kuiri Permohonan Tutup Pintu'));
        }

        $lockout->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 53;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Tutup Pintu - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $lockout = Lockout::findOrFail($request->id);

            $queries = $lockout->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $lockout = Lockout::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 53;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Tutup Pintu - Kuiri";
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
            $query = $lockout->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 53;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Tutup Pintu - Kuiri";
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
        $log->module_id = 53;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Tutup Pintu - Kuiri";
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

        $lockout = Lockout::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Tutup Pintu - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $lockout->logs()->where('activity_type_id',14)->where('filing_status_id', $lockout->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('lockout.process.recommend', $lockout->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Tutup Pintu - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $lockout = Lockout::findOrFail($request->id);
        $lockout->filing_status_id = 6;
        $lockout->is_editable = 0;
        $lockout->save();

        $lockout->logs()->updateOrCreate(
            [
                'module_id' => 53,
                'activity_type_id' => 14,
                'filing_status_id' => $lockout->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($lockout, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($lockout, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($lockout, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($lockout->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $lockout, 'Serahan Permohonan Tutup Pintu'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_status_edit(Request $request) {

        $lockout = Lockout::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Tutup Pintu - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('lockout.process.status', $lockout->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Tutup Pintu - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $lockout = Lockout::findOrFail($request->id);

        $log = $lockout->logs()->create([
                'module_id' => 53,
                'activity_type_id' => 20,
                'filing_status_id' => $lockout->filing_status_id,
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

        $form = $lockout = Lockout::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Tutup Pintu - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("lockout.process.result.reject", $form->id);
        $route_approve = route("lockout.process.result.approve", $form->id);

        return view('general.modal.result-lockout', compact('route_reject','route_approve'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $lockout = Lockout::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Tutup Pintu - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('lockout.process.result.approve', $lockout->id);

        return view('general.modal.obey', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Tutup Pintu - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $lockout = Lockout::findOrFail($request->id);
        $lockout->filing_status_id = 9;
        $lockout->is_editable = 0;
        $lockout->save();

        $lockout->logs()->updateOrCreate(
            [
                'module_id' => 53,
                'activity_type_id' => 16,
                'filing_status_id' => $lockout->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($lockout->created_by->email)->send(new ApprovedKS($lockout, 'Status Permohonan Tutup Pintu'));

        Mail::to($lockout->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($lockout, 'Status Permohonan Tutup Pintu'));
        Mail::to($lockout->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($lockout, 'Status Permohonan Tutup Pintu'));
        Mail::to($lockout->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($lockout, 'Status Permohonan Tutup Pintu'));
        Mail::to($lockout->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($lockout, 'Sedia Dokumen Kelulusan Tutup Pintu'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $lockout = Lockout::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Tutup Pintu - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('lockout.process.result.reject', $lockout->id);

        return view('general.modal.disobey', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Tutup Pintu - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $lockout = Lockout::findOrFail($request->id);
        $lockout->filing_status_id = 8;
        $lockout->is_editable = 0;
        $lockout->save();

        $lockout->logs()->updateOrCreate(
            [
                'module_id' => 53,
                'activity_type_id' => 16,
                'filing_status_id' => $lockout->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($lockout->created_by->email)->send(new Rejected($lockout, 'Status Permohonan Tutup Pintu'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_index(Request $request) {

        $lockout = Lockout::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 53;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Tutup Pintu - Dokumen Sokongan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attachments = [];

        foreach($lockout->attachments as $attachment) {
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
                'lockout',
                $request->file('file'),
                uniqid().'_'.$request->file('file')->getClientOriginalName()
            );

            $lockout = Lockout::findOrFail($request->id);

            $attachment = $lockout->attachments()->create([
                'name' => $request->file('file')->getClientOriginalName(),
                'url' => $path,
                'created_by_user_id' => auth()->id()
            ]);

            $log = new LogSystem;
            $log->module_id = 53;
            $log->activity_type_id = 4;
            $log->description = "Tambah Tutup Pintu - Dokumen Sokongan";
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
        $log->module_id = 53;
        $log->activity_type_id = 6;
        $log->description = "Padam Tutup Pintu - Dokumen Sokongan";
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

    public function download(Request $request) {

        $filing = Lockout::findOrFail($request->id);  
        
        $period = '';
        $total = count($filing->formu->periods);
        foreach ($filing->formu->periods as $index => $period) {
            if($index > 0 && $index != ($total-1))
                $period .= ', ';
            elseif($index > 0 && $index == ($total-1))
                $period .= 'dan ';
            if($period->start_date == $period->end_date)
                $period .= date('d/m/Y' , strtotime($period->start_date));
            else
                $period .= date('d/m/Y' , strtotime($period->start_date)).' - '.date('d/m/Y' , strtotime($period->end_date));
        }

        $result = $filing->total_voters != 0 ? $filing->total_supporting / $filing->total_voters * 100 : 0;
        $total_return = $filing->formu->total_slips - $filing->formu->total_supporting - $filing->formu->total_against;
        $president = $filing->tenure->officers()->where('designation_id', 1)->firstOrFail();
        $treasurer = $filing->tenure->officers()->where('designation_id', 5)->firstOrFail();
                                                 // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->tenure->entity->name),
            'address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ',<w:br/>'.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ',<w:br/>'.htmlspecialchars($filing->address->address3) : ''),
            'postcode' => htmlspecialchars($filing->address->postcode),
            'district' => $filing->address->district ? htmlspecialchars($filing->address->district->name) : '','state' => $filing->address->state ? htmlspecialchars($filing->address->state->name) : '',
            'today_date' => htmlspecialchars(strftime('%e %B %Y')),
            'employer_name' => htmlspecialchars($filing->employer_name),
            'employer_address' => htmlspecialchars($filing->employer_address->address1).
                ($filing->employer_address->address2 ? ', '.htmlspecialchars($filing->employer_address->address2) : '').
                ($filing->employer_address->address3 ? ', '.htmlspecialchars($filing->employer_address->address3) : '').
                ', '.($filing->employer_address->postcode).
                ($filing->employer_address->district ? ' '.htmlspecialchars($filing->employer_address->district->name) : '').
                ($filing->employer_address->state ? ', '.htmlspecialchars($filing->employer_address->state->name) : ''),
            'address_lockout' => htmlspecialchars(preg_replace('<br>', '<w:br/>', $filing->address_lockout)),
            'lockout_at' => htmlspecialchars($period),
            'setting' => htmlspecialchars(preg_replace('<br>', '<w:br/>', $filing->setting)),
            'voted_at' => htmlspecialchars(strftime('%e $B %Y' , strtotime($filing->formu->voted_at))),
            'total_voters' => htmlspecialchars($filing->formu->total_voters),
            'total_slips' => htmlspecialchars($filing->formu->total_slips),
            'total_return' => htmlspecialchars($total_return),
            'total_supporting' => htmlspecialchars($filing->formu->total_supporting),
            'total_against' => htmlspecialchars($filing->formu->total_against),
            'result' => htmlspecialchars($result),
            'president_name' => $president ? htmlspecialchars(strtoupper($president->name)) : '',
            'president_phone' => $president ? htmlspecialchars($president->phone) : '',
            'president_email' => $president ? htmlspecialchars($president->email) : '',
            'secretary_name' => htmlspecialchars(strtoupper($filing->tenure->entity->user->name)),
            'secretary_phone' => htmlspecialchars(strtoupper($filing->tenure->entity->user->phone)),
            'secretary_email' => htmlspecialchars(strtoupper($filing->tenure->entity->user->email)),
            'treasurer_name' => $treasurer ? htmlspecialchars(strtoupper($treasurer->name)) : '',
            'treasurer_phone' => $treasurer ? htmlspecialchars($treasurer->phone) : '',
            'treasurer_email' => $treasurer ? htmlspecialchars($treasurer->email) : '',
            'province_office_uppercase' => htmlspecialchars($filing->tenure->entity->province_office->name),
        ];

        $log = new LogSystem;
        $log->module_id = 53;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/investigation/lockout.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

         // Generate table requester
        $rows = $filing->formu->examiners;
        $document->cloneRow('examiner_name', count($rows));
        foreach($rows as $index => $row) {
            $document->setValue('examiner_name#'.($index+1), htmlspecialchars(strtoupper($row->name)));
        }
        
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Notis Tutup Pintu';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function formu_download(Request $request) {

        $filing = Lockout::findOrFail($request->id); 
        $filing = $formlu->formu;

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
                (', '.fhtmlspecialchars($filing->branch->address->address1).
                ($filing->branch->address->address2 ? ', '.htmlspecialchars($filing->branch->address->address2) : '').
                ($filing->branch->address->address3 ? ', '.htmlspecialchars($filing->branch->address->address3) : '').
                ', '.($filing->branch->address->postcode).
                ($filing->branch->address->district ? ' '.htmlspecialchars($filing->branch->address->district->name) : '').
                ($filing->branch->address->state ? ', '.htmlspecialchars($filing->branch->address->state->name) : '')) : '',
            'setting' => htmlspecialchars(preg_replace('<br>', 'w:br/>', $filing->setting)),
            'voted_day' => htmlspecialchars(strftime('%e', strtotime($filing->voted_at))),
            'voted_month_year' => htmlspecialchars(strftime('%B %Y', strtotime($filing->voted_at))),
            'total_voters' => htmlspecialchars($filing->total_voters),
            'total_slips' => htmlspecialchars($filing->total_slips),
            'president_name' => htmlspecialchars($president ? $president->name : ''),
            'secretary_name' => htmlspecialchars($filing->tenure->entity->user->name),
            'treasurer_name' => htmlspecialchars($treasurer ? $treasurer->name : ''),
            'today_day' => htmlspecialchars(strftime('%e')),
            'today_month_year' =>  htmlspecialchars(strftime('%B %Y')),
            'today_date' =>  htmlspecialchars(strftime('%e %B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 53;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/change-officer/formu.docx'));        // Change here

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
