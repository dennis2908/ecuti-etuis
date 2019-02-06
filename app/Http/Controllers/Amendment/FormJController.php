<?php

namespace App\Http\Controllers\Amendment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\MasterModel\MasterProvinceOffice;
use App\MasterModel\MasterJustification;
use App\MasterModel\MasterMeetingType;
use App\MasterModel\MasterAddressType;
use App\MasterModel\MasterState;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\FormJ\ApprovedKS;
use App\Mail\FormJ\ApprovedPWN;
use App\Mail\FormJ\Rejected;
use App\Mail\FormJ\Sent;
use App\Mail\FormJ\NotReceived;
use App\Mail\FormJ\DocumentApproved;
use App\Mail\FormJ\ReminderConstitution;
use App\OtherModel\Address;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\FormJ;
use App\FilingModel\Query;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class FormJController extends Controller
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
        $formj = FormJ::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'new_address_id' => $address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $errors_j1 = count(($this->getErrors($formj))['j1']);

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang J";
        $log->data_new = json_encode($formj);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('amendment.formj.index', compact('formj', 'errors_j1'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $formj = FormJ::findOrFail($request->id);

        $errors_j1 = count(($this->getErrors($formj))['j1']);

        return view('amendment.formj.index', compact('formj', 'errors_j1'));
    }

    /**
     * Show the list application.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 17;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang J";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formj = FormJ::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $formj = $formj->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $formj = $formj->where('filing_status_id', '>', 1)->where(function($formj) {
                    return $formj->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($formj){
                        if(auth()->user()->hasRole('ptw'))
                            return $formj->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $formj->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $formj = $formj->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($formj)
                ->editColumn('address', function ($formj) {
                    if($formj->new_address)
                        return $formj->new_address->address1.
                            ($formj->new_address->address2 ? ',<br>'.$formj->new_address->address2 : '').
                            ($formj->new_address->address3 ? ',<br>'.$formj->new_address->address3 : '').
                            ',<br>'.
                            $formj->new_address->postcode.' '.
                            ($formj->new_address->district ? $formj->new_address->district->name : '').', '.
                            ($formj->new_address->state ? $formj->new_address->state->name : '');
                    else
                        return "";
                })
                ->editColumn('applied_at', function ($formj) {
                    return $formj->applied_at ? date('d/m/Y', strtotime($formj->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($formj) {
                    if($formj->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$formj->status->name.'</span>';
                    else if($formj->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$formj->status->name.'</span>';
                    else if($formj->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$formj->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$formj->status->name.'</span>';
                })
                ->editColumn('letter', function($formj) {
                    $result = "";
                    if($formj->filing_status_id == 9){
                        $result .= letterButton(25, get_class($formj), $formj->id);
                        $result .= letterButton(27, get_class($formj), $formj->id);
                    }
                    elseif($formj->filing_status_id == 8)
                        $result .= letterButton(26, get_class($formj), $formj->id);
                    return $result;
                    // return '<a href="'.route('formj.pdf', $formj->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i>'.($formj->logs->count() > 0 ? date('d/m/Y', strtotime($formj->logs->first()->created_at)).' - ' : '').$formj->union->name.'</a><br>';
                })
                ->editColumn('action', function ($formj) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($formj)).'\','.$formj->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $formj->is_editable)) && $formj->filing_status_id < 7)
                        $button .= '<a href="'.route('formj.form', $formj->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status('.$formj->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if( ((auth()->user()->hasRole('ptw') && $formj->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $formj->distributions->count() == 3)) && $formj->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$formj->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp', 'kpks']) && $formj->filing_status_id < 8)
                        $button .= '<a onclick="query('.$formj->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp']) && $formj->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$formj->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $formj->filing_status_id < 8)
                        $button .= '<a onclick="process('.$formj->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 17;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang J";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

    	return view('amendment.formj.list');
    }

    public function praecipe(Request $request) {
        $formj = FormJ::findOrFail($request->id);
        $pdf = PDF::loadView('amendment.formj.praecipe', compact('formj'));
        return $pdf->setPaper('A4')->setOrientation('portrait')->download('praecipe.pdf');
    }


    /**
     * Show the form application.
     *
     * @return \Illuminate\Http\Response
     */
    public function j1_index(Request $request) {

        $formj = FormJ::findOrFail($request->id);
        $meeting_types = MasterMeetingType::whereIn('id', [1,2,3])->get();
        $address_types = MasterAddressType::all();
        $justifications = MasterJustification::all();
        $states = MasterState::all();
        $offices = MasterProvinceOffice::all();

        return view('amendment.formj.j1.index', compact('formj','meeting_types','address_types','justifications','states','offices'));
    }

    private function getErrors($formj) {

        $errors = [];

        if(!$formj) {
            $errors['j1'] = [null,null,null,null,null,null,null,null,null,null,null,null];
        }
        else {
            $errors_j1 = [];

            $rules = [
                'new_address_id' => 'required|integer',
                'province_office_id' => 'required|integer',
                'meeting_type_id' => 'required|integer',
                'resolved_at' => 'required',
                'justification_id' => 'required|integer',
                'moved_at' => 'required',
                'address_type_id' => 'required|integer',
                'applied_at' => 'required',
            ];

            if($formj->justification_id == 6)
                $rules['justification_description'] = 'required';

            $validate_formj = Validator::make($formj->toArray(), $rules);

            if ($validate_formj->fails())
                $errors_j1 = array_merge($errors_j1, $validate_formj->errors()->toArray());

            $validate_address = Validator::make($formj->new_address->toArray(), [
                'address1' => 'required',
                'postcode' => 'required|digits:5',
                'district_id' => 'required|integer',
                'state_id' => 'required|integer',
            ]);

            if ($validate_address->fails())
                $errors_j1 = array_merge($errors_j1, $validate_address->errors()->toArray());

            $errors['j1'] = $errors_j1;
        }

        return $errors;
    }


    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $formj = FormJ::findOrFail($request->id);

        $errors = ($this->getErrors($formj))['j1'];
        //return response()->json(['errors' => $errors], 422);

        if(count($errors) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 17;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang J - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formj = FormJ::findOrFail($request->id);

            $formj->logs()->updateOrCreate(
                [
                    'module_id' => 17,
                    'activity_type_id' => 11,
                    'filing_status_id' => $formj->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $formj->filing_status_id = 2;
            $formj->is_editable = 0;
            $formj->save();

            $formj->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 17,
            ]);

            Mail::to($formj->created_by->email)->send(new Sent($formj, 'Permohonan Borang J'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($formj, $target) {

        $check = $formj->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($formj->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormJ')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $formj->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formj->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($formj->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormJ')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $formj->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formj->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($formj, 'Serahan Permohonan Borang J'));
        }
        else if($target == "pw") {
            if($formj->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $formj->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formj->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($formj, 'Serahan Permohonan Borang J'));
        }
        else if($target == "pthq") {
            if($formj->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormJ')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $formj->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formj->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($formj->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormJ')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $formj->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formj->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($formj, 'Serahan Permohonan Borang J'));
        }
        else if($target == "pkpp") {
            if($formj->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $formj->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formj->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($formj, 'Serahan Permohonan Borang J'));
        }
        else if($target == "kpks") {
            if($formj->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $formj->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formj->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($formj, 'Serahan Permohonan Borang J'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $formj = FormJ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang J - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formj.process.document-receive', $formj->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang J - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formj = FormJ::findOrFail($request->id);

        $formj->filing_status_id = 3;
        $formj->save();

        $formj->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 17,
            ]
        );

        $formj->logs()->updateOrCreate(
            [
                'module_id' => 17,
                'activity_type_id' => 12,
                'filing_status_id' => $formj->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($formj, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($formj, 'ppw');
            Mail::to($formj->created_by->email)->send(new Received(auth()->user(), $formj, 'Pengesahan Penerimaan Permohonan Borang J'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($formj, 'pphq');
            Mail::to($formj->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formj, 'Pengesahan Penerimaan Permohonan Borang J'));
            Mail::to($formj->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formj, 'Pengesahan Penerimaan Permohonan Borang J'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $formj = FormJ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang J - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formj.process.query.item', $formj->id);
        $route2 = route('formj.process.query', $formj->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $formj = FormJ::findOrFail($request->id);

        if(count($formj->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang J - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formj->filing_status_id = 5;
        $formj->is_editable = 1;
        $formj->save();

        $log2 = $formj->logs()->updateOrCreate(
            [
                'module_id' => 17,
                'activity_type_id' => 13,
                'filing_status_id' => $formj->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $formj->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formj, 'Kuiri Permohonan Borang J oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $formj->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formj, 'Kuiri Permohonan Borang J oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $formj->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formj, 'Kuiri Permohonan Borang J oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($formj->created_by->email)->send(new Queried(auth()->user(), $formj, 'Kuiri Permohonan Borang J'));
        }

        $formj->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 17;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang J - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formj = FormJ::findOrFail($request->id);

            $queries = $formj->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $formj = FormJ::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 17;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang J - Kuiri";
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
            $query = $formj->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 17;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang J - Kuiri";
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
        $log->module_id = 17;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang J - Kuiri";
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

        $formj = FormJ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang J - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $formj->logs()->where('activity_type_id',14)->where('filing_status_id', $formj->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('formj.process.recommend', $formj->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang J - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formj = FormJ::findOrFail($request->id);
        $formj->filing_status_id = 6;
        $formj->is_editable = 0;
        $formj->save();

        $formj->logs()->updateOrCreate(
            [
                'module_id' => 17,
                'activity_type_id' => 14,
                'filing_status_id' => $formj->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($formj, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($formj, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($formj, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($formj->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $formj, 'Serahan Permohonan Borang J'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $formj = FormJ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang J - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formj.process.delay', $formj->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang J - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formj = FormJ::findOrFail($request->id);
        $formj->filing_status_id = 7;
        $formj->is_editable = 0;
        $formj->save();

        $formj->logs()->updateOrCreate(
            [
                'module_id' => 17,
                'activity_type_id' => 15,
                'filing_status_id' => $formj->filing_status_id,
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

        $formj = FormJ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Borang J - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formj.process.status', $formj->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang J - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formj = FormJ::findOrFail($request->id);

        $log = $formj->logs()->create([
                'module_id' => 17,
                'activity_type_id' => 20,
                'filing_status_id' => $formj->filing_status_id,
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

        $form = $formj = FormJ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang J - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("formj.process.result.reject", $form->id);
        $route_approve = route("formj.process.result.approve", $form->id);
        $route_delay = route("formj.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $formj = FormJ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang J - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formj.process.result.approve', $formj->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang J - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formj = FormJ::findOrFail($request->id);
        $formj->filing_status_id = 9;
        $formj->is_editable = 0;
        $formj->save();

        $formj->logs()->updateOrCreate(
            [
                'module_id' => 17,
                'activity_type_id' => 16,
                'filing_status_id' => $formj->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(Carbon::parse($formj->moved_at)->isPast() || Carbon::parse($formj->moved_at)->isCurrentDay())
            $formj->tenure->entity->addresses()->create(['address_id' => $formj->new_address_id]);

        Mail::to($formj->created_by->email)->send(new ApprovedKS($formj, 'Status Permohonan Borang J'));
        Mail::to($formj->created_by->email)->send(new ReminderConstitution($formj, 'Peringatan Serahan Salinan Buku Perlembagaan'));

        Mail::to($formj->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formj, 'Status Permohonan Borang J'));
        Mail::to($formj->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formj, 'Status Permohonan Borang J'));
        Mail::to($formj->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formj, 'Status Permohonan Borang J'));
        Mail::to($formj->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($formj, 'Sedia Dokumen Kelulusan Borang J'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $formj = FormJ::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang J - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formj.process.result.reject', $formj->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 17;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang J - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formj = FormJ::findOrFail($request->id);
        $formj->filing_status_id = 8;
        $formj->is_editable = 0;
        $formj->save();

        $formj->logs()->updateOrCreate(
            [
                'module_id' => 17,
                'activity_type_id' => 16,
                'filing_status_id' => $formj->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formj->created_by->email)->send(new Rejected($formj, 'Status Permohonan Borang J'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function download(Request $request) {

        $filing = FormJ::findOrFail($request->id);                                                      // Change here
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
            'new_address' => htmlspecialchars($filing->new_address->address1).
                ($filing->new_address->address2 ? ', '.htmlspecialchars($filing->new_address->address2) : '').
                ($filing->new_address->address3 ? ', '.htmlspecialchars($filing->new_address->address3) : '').
                ', '.($filing->new_address->postcode).
                ($filing->new_address->district ? ' '.htmlspecialchars($filing->new_address->district->name) : '').
                ($filing->new_address->state ? ', '.htmlspecialchars($filing->new_address->state->name) : ''),
            'moved_at' => htmlspecialchars(strftime('%e %B %Y', strtotime($filing->moved_at))),
            'meeting_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'resolved_at' => htmlspecialchars(strftime('%e %B %Y', strtotime($filing->resolved_at))),
        ];

        $log = new LogSystem;
        $log->module_id = 17;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/amendment/formj.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang J';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);
       
        return docxToPdf($temp_file);
    }

}
