<?php

namespace App\Http\Controllers\Amendment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\MasterModel\MasterMeetingType;
use App\FilingModel\FormGMember;
use App\FilingModel\FormG;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\FormG\ApprovedKS;
use App\Mail\FormG\ApprovedPWN;
use App\Mail\FormG\Rejected;
use App\Mail\FormG\Sent;
use App\Mail\FormG\NotReceived;
use App\Mail\FormG\DocumentApproved;
use App\Mail\FormG\ReminderConstitution;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\Query;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class FormGController extends Controller
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

        $formg = FormG::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'secretary_user_id' => auth()->id(),
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $errors_g1 = count(($this->getErrors($formg))['g1']);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang g";
        $log->data_new = json_encode($formg);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('amendment.formg.index', compact('formg', 'errors_g1'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $formg = FormG::findOrFail($request->id);

        $errors_g1 = count(($this->getErrors($formg))['g1']);

        return view('amendment.formg.index', compact('formg', 'errors_g1'));
    }

    /**
     * Show the list application.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 16;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang G";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formg = FormG::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $formg = $formg->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $formg = $formg->where('filing_status_id', '>', 1)->where(function($formg) {
                    return $formg->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($formg){
                        if(auth()->user()->hasRole('ptw'))
                            return $formg->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $formg->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $formg = $formg->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($formg)
                ->editColumn('applied_at', function ($formg) {
                    return $formg->applied_at ? date('d/m/Y', strtotime($formg->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($formg) {
                    if($formg->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$formg->status->name.'</span>';
                    else if($formg->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$formg->status->name.'</span>';
                    else if($formg->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$formg->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$formg->status->name.'</span>';
                })
                ->editColumn('letter', function($formg) {
                    $result = "";
                    if($formg->filing_status_id == 9){
                        $result .= letterButton(22, get_class($formg), $formg->id);
                        $result .= letterButton(23, get_class($formg), $formg->id);
                        $result .= letterButton(24, get_class($formg), $formg->id);
                    }
                    elseif($formg->filing_status_id == 8)
                        $result .= letterButton(21, get_class($formg), $formg->id);
                    return $result;
                    // return '<a href="'.route('formg.pdf', $formg->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i>'.($formg->logs->count() > 0 ? date('d/m/Y', strtotime($formg->logs->first()->created_at)).' - ' : '').$formg->union->name.'</a><br>';
                })
                ->editColumn('action', function ($formg) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($formg)).'\','.$formg->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $formg->is_editable)) && $formg->filing_status_id < 7)
                        $button .= '<a href="'.route('formg.form', $formg->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status('.$formg->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if( ((auth()->user()->hasRole('ptw') && $formg->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $formg->distributions->count() == 3)) && $formg->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$formg->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp', 'kpks']) && $formg->filing_status_id < 8)
                        $button .= '<a onclick="query('.$formg->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp']) && $formg->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$formg->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $formg->filing_status_id < 8)
                        $button .= '<a onclick="process('.$formg->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 16;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang G";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

    	return view('amendment.formg.list');
    }

    public function praecipe(Request $request) {
        $formg = FormG::findOrFail($request->id);

        $pdf = PDF::loadView('amendment.formg.praecipe', compact('formg'));
        return $pdf->setPaper('A4')->setOrientation('portrait')->download('praecipe.pdf');
    }


    /**
     * Show the form application.
     *
     * @return \Illuminate\Http\Response
     */
    public function g1_index(Request $request) {

        $formg = FormG::findOrFail($request->id);
        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();

        return view('amendment.formg.g1.index', compact('meeting_types', 'formg'));
    }

    //Member CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function member_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang G - Ahli";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formg = FormG::findOrFail($request->id);
        $members = $formg->members()->get();

        while($members->count() < 7)
            $members->push(new FormGMember(['formg_id' => $formg->id, 'name' => '']));

        return datatables()->of($members)
            ->editColumn('action', function ($member) {
                $button = "";

                if($member->id) {
                    $button .= '<a onclick="editMember('.$member->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                    $button .= '<a onclick="removeMember('.$member->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';
                } else {
                    $button .= '<a onclick="addMember()" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                }


                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function member_insert(Request $request) {

        $formg = FormG::findOrFail($request->id);
        $member = $formg->members()->create([
            'name' => $request->member,
        ]);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang G - Ahli";
        $log->data_new = json_encode($member);
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
    public function member_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang G - Ahli";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formg = FormG::findOrFail($request->id);
        $member = FormGMember::findOrFail($request->member_id);

        return view('amendment.formg.g1.edit', compact('formg', 'member'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function member_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $member = FormGMember::findOrFail($request->member_id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang G - Ahli";
        $log->data_old = json_encode($member);

        $member->update([
            'name' => $request->name,
        ]);

        $log->data_new = json_encode($member);
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
    public function member_delete(Request $request) {

        $member = FormGMember::findOrFail($request->member_id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang G - Ahli";
        $log->data_old = json_encode($member);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $member->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    // Member CRUD END
    private function getErrors($formg) {

        $errors = [];

        if(!$formg) {
            $errors['g1'] = [null,null,null,null,null,null];
        }
        else {
            $validate_formg = Validator::make($formg->toArray(), [
                'name' => 'required',
                'justification' => 'required',
                'meeting_type_id' => 'required|integer',
                'certification_no' => 'required',
                'applied_at' => 'required',
            ]);

            $errors_g1 = [];

            if ($validate_formg->fails())
                $errors_g1 = array_merge($errors_g1, $validate_formg->errors()->toArray());

            if($formg->members->count() < 7)
                $errors_g1 = array_merge($errors_g1, ['members' => ['Jumlah ahli-ahli kurang dari 7 orang.']]);

            $errors['g1'] = $errors_g1;
        }

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $formg = FormG::findOrFail($request->id);

        $errors = ($this->getErrors($formg))['g1'];
        //return response()->json(['errors' => $errors], 422);

        if(count($errors) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 16;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang G - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formg->logs()->updateOrCreate(
                [
                    'module_id' => 16,
                    'activity_type_id' => 11,
                    'filing_status_id' => $formg->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $formg->filing_status_id = 2;
            $formg->is_editable = 0;
            $formg->save();

            $formg->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 16,
            ]);

            Mail::to($formg->created_by->email)->send(new Sent($formg, 'Permohonan Borang G'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($formg, $target) {

        $check = $formg->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($formg->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormG')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $formg->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formg->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($formg->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormG')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $formg->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formg->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($formg, 'Serahan Permohonan Borang G'));
        }
        else if($target == "pw") {
            if($formg->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $formg->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formg->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($formg, 'Serahan Permohonan Borang G'));
        }
        else if($target == "pthq") {
            if($formg->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormG')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $formg->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formg->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($formg->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormG')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $formg->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formg->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($formg, 'Serahan Permohonan Borang G'));
        }
        else if($target == "pkpp") {
            if($formg->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $formg->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formg->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($formg, 'Serahan Permohonan Borang G'));
        }
        else if($target == "kpks") {
            if($formg->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $formg->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formg->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($formg, 'Serahan Permohonan Borang G'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $formg = FormG::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang G - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formg.process.document-receive', $formg->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang G - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formg = FormG::findOrFail($request->id);

        $formg->filing_status_id = 3;
        $formg->save();

        $formg->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 16,
            ]
        );

        $formg->logs()->updateOrCreate(
            [
                'module_id' => 16,
                'activity_type_id' => 12,
                'filing_status_id' => $formg->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($formg, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($formg, 'ppw');
            Mail::to($formg->created_by->email)->send(new Received(auth()->user(), $formg, 'Pengesahan Penerimaan Permohonan Borang G'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($formg, 'pphq');
            Mail::to($formg->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formg, 'Pengesahan Penerimaan Permohonan Borang G'));
            Mail::to($formg->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formg, 'Pengesahan Penerimaan Permohonan Borang G'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $formg = FormG::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang G - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formg.process.query.item', $formg->id);
        $route2 = route('formg.process.query', $formg->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $formg = FormG::findOrFail($request->id);

        if(count($formg->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang G - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formg->filing_status_id = 5;
        $formg->is_editable = 1;
        $formg->save();

        $log2 = $formg->logs()->updateOrCreate(
            [
                'module_id' => 16,
                'activity_type_id' => 13,
                'filing_status_id' => $formg->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $formg->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formg, 'Kuiri Permohonan Borang G oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $formg->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formg, 'Kuiri Permohonan Borang G oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $formg->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formg, 'Kuiri Permohonan Borang G oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($formg->created_by->email)->send(new Queried(auth()->user(), $formg, 'Kuiri Permohonan Borang G'));
        }

        $formg->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 16;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang G - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formg = FormG::findOrFail($request->id);

            $queries = $formg->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $formg = FormG::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 16;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang G - Kuiri";
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
            $query = $formg->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 16;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang G - Kuiri";
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
        $log->module_id = 16;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang G - Kuiri";
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

        $formg = FormG::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang G - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $formg->logs()->where('activity_type_id',14)->where('filing_status_id', $formg->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('formg.process.recommend', $formg->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang G - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formg = FormG::findOrFail($request->id);
        $formg->filing_status_id = 6;
        $formg->is_editable = 0;
        $formg->save();

        $formg->logs()->updateOrCreate(
            [
                'module_id' => 16,
                'activity_type_id' => 14,
                'filing_status_id' => $formg->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($formg, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($formg, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($formg, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($formg->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $formg, 'Serahan Permohonan Borang G'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $formg = FormG::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang G - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formg.process.delay', $formg->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang G - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formg = FormG::findOrFail($request->id);
        $formg->filing_status_id = 7;
        $formg->is_editable = 0;
        $formg->save();

        $formg->logs()->updateOrCreate(
            [
                'module_id' => 16,
                'activity_type_id' => 15,
                'filing_status_id' => $formg->filing_status_id,
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

        $formg = FormG::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Borang G - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formg.process.status', $formg->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang G - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formg = FormG::findOrFail($request->id);

        $log = $formg->logs()->create([
                'module_id' => 16,
                'activity_type_id' => 20,
                'filing_status_id' => $formg->filing_status_id,
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

        $form = $formg = FormG::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang G - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("formg.process.result.reject", $form->id);
        $route_approve = route("formg.process.result.approve", $form->id);
        $route_delay = route("formg.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $formg = FormG::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang G - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formg.process.result.approve', $formg->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang G - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formg = FormG::findOrFail($request->id);
        $formg->filing_status_id = 9;
        $formg->is_editable = 0;
        $formg->save();

        $formg->logs()->updateOrCreate(
            [
                'module_id' => 16,
                'activity_type_id' => 16,
                'filing_status_id' => $formg->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        $formg->tenure->entity()->update(['name' => $formg->name]);

        Mail::to($formg->created_by->email)->send(new ApprovedKS($formg, 'Status Permohonan Borang G'));
        Mail::to($formg->created_by->email)->send(new ReminderConstitution($formg, 'Peringatan Serahan Salinan Buku Perlembagaan'));

        Mail::to($formg->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formg, 'Status Permohonan Borang G'));
        Mail::to($formg->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formg, 'Status Permohonan Borang G'));
        Mail::to($formg->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formg, 'Status Permohonan Borang G'));
        Mail::to($formg->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($formg, 'Sedia Dokumen Kelulusan Borang G'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $formg = FormG::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang G - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formg.process.result.reject', $formg->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang G - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formg = FormG::findOrFail($request->id);
        $formg->filing_status_id = 8;
        $formg->is_editable = 0;
        $formg->save();

        $formg->logs()->updateOrCreate(
            [
                'module_id' => 16,
                'activity_type_id' => 16,
                'filing_status_id' => $formg->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formg->created_by->email)->send(new Rejected($formg, 'Status Permohonan Borang G'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function download(Request $request) {

        $filing = FormG::findOrFail($request->id);                                                      // Change here
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
            'applied_day' => htmlspecialchars(strftime('%e', strtotime($filing->applied_at))),
            'applied_month_year' => htmlspecialchars(strftime('%B %Y', strtotime($filing->applied_at))),
            'new_name' => htmlspecialchars($filing->name),
            'certification_no' => htmlspecialchars($filing->certification_no),
            'secretary_name' => htmlspecialchars($filing->tenure->entity->user->name),
            'meeting_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'resolved_day' => htmlspecialchars(strftime('%e', strtotime($filing->resolved_at))),
            'resolved_month_year' => htmlspecialchars(strftime('%B %Y', strtotime($filing->resolved_at))),
            'today_day' => htmlspecialchars(strftime('%e')),
            'today_month_year' =>  htmlspecialchars(strftime('%B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 16;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/amendment/formg.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate list
        $members = $filing->members;

        $document->cloneBlockString('list', count($members)-1);

        foreach($members as $index => $member){
            $content = preg_replace('~\R~u', '<w:br/>', $member->name);
            $document->setValue('list_name', ucfirst($content), 1);
        }
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang G';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);
       
        return docxToPdf($temp_file);
    }
}
