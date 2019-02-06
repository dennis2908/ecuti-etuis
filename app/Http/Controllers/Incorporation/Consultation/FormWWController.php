<?php

namespace App\Http\Controllers\Incorporation\Consultation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FilingModel\ConsultancyPurpose;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\FilingModel\Officer;
use App\FilingModel\FormWW;
use App\FilingModel\Query;
use App\OtherModel\Address;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\FormWW\ApprovedKS;
use App\Mail\FormWW\ApprovedPWN;
use App\Mail\FormWW\Rejected;
use App\Mail\FormWW\Sent;
use App\Mail\FormWW\NotReceived;
use App\Mail\FormWW\DocumentApproved;
use App\MasterModel\MasterState;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterMeetingType;
use App\MasterModel\MasterDesignation;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\UserUnion;
use App\User;
use App\UserStaff;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class FormWWController extends Controller
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

        $states = MasterState::all();
        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();
        $designations = MasterDesignation::all();

        $formww = FormWW::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        return view('incorporation.consultation.formww.index', compact('formww', 'states','meeting_types', 'designations'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $formww = FormWW::findOrFail($request->id);

        $states = MasterState::all();
        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();
        $designations = MasterDesignation::all();

        return view('incorporation.consultation.formww.index', compact('formww', 'states','meeting_types', 'designations'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 13;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang WW";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formww = FormWW::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $formww = $formww->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else {
                $formww = $formww->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($formww)
                ->editColumn('applied_at', function ($formww) {
                    return $formww->applied_at ? date('d/m/Y', strtotime($formww->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($formww) {
                    if($formww->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$formww->status->name.'</span>';
                    else if($formww->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$formww->status->name.'</span>';
                    else if($formww->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$formww->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$formww->status->name.'</span>';
                })
                ->editColumn('letter', function($formww) {
                    $result = "";
                    if($formww->filing_status_id > 1)
                        $result .= '<a href="'.route('download.formww', $formww->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i>Borang WW</a><br>';
                    if($formww->filing_status_id == 9)
                        $result .= letterButton(12, get_class($formww), $formww->id);
                    return $result;
                    // return '<a href="'.route('formw.pdf', $formw->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i>'.($formw->logs->count() > 0 ? date('d/m/Y', strtotime($formw->logs->first()->created_at)).' - ' : '').$formw->union->name.'</a><br>';
                })
                ->editColumn('action', function ($formww) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($formww)).'\','.$formww->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $formww->is_editable)) && $formww->filing_status_id < 7 )
                        $button .= '<a href="'.route('formww.form', $formww->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg', 'kpks']) && $formww->filing_status_id < 8 )
                        $button .= '<a onclick="query('.$formww->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg']) && $formww->filing_status_id < 7 )
                        $button .= '<a onclick="recommend('.$formww->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';

                    if(auth()->user()->hasRole('kpks') && $formww->filing_status_id < 8 )
                        $button .= '<a onclick="process('.$formww->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 13;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang WW";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('incorporation.consultation.formww.list');
    }

    private function getErrors($formww_id) {

        $formww = FormWW::findOrFail($formww_id);

        $errors = [];

        $validate_formww = Validator::make($formww->toArray(), [
            'consultant_name' => 'required|string',
            'consultant_address' => 'required|string',
            'consultant_phone' => 'required|string',
            'consultant_fax' => 'required|string',
            'consultant_email' => 'required|string|email',
            'resolved_at' => 'required',
            'meeting_type_id' => 'required|integer',
            'applied_at' => 'required',
        ]);

        if ($validate_formww->fails())
            $errors = array_merge($errors, $validate_formww->errors()->toArray());

        $errors = ['ww' => $errors];

        return $errors;
    }

    public function purpose_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang WW - Tujuan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formww = FormWW::findOrFail($request->id);

        return datatables()->of($formww->purposes)
             ->editColumn('action', function ($purpose) {
                 $button = "";
                 $button .= '<button type="button" class="btn btn-danger btn-xs" onclick="removePurpose('.$purpose->id.')"><i class="fa fa-times"></i></button>';

                 return $button;
            })
            ->make(true);

    }

    public function purpose_insert(Request $request) {

        $formww = FormWW::findOrFail($request->id);
        $purpose = $formww->purposes()->create([
            'purpose' => $request->purpose,
        ]);

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang WW - Tujuan";
        $log->data_new = json_encode($purpose);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.']);
    }

    public function purpose_delete(Request $request) {

        $purpose = ConsultancyPurpose::findOrFail($request->purpose_id);

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang WW - Tujuan";
        $log->data_old = json_encode($purpose);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $purpose->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $errors = ($this->getErrors($request->id))['ww'];
        //return response()->json(['errors' => $errors], 422);

        if(count($errors) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 13;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang W - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formww = FormWW::findOrFail($request->id);

            $formww->logs()->updateOrCreate(
                [
                    'module_id' => 13,
                    'activity_type_id' => 11,
                    'filing_status_id' => $formww->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $formww->filing_status_id = 2;
            $formww->is_editable = 0;
            $formww->save();

            if($formww->logs->count() == 1)
                $this->distribute($formww, 'ppw');

            $formww->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 13,
            ]);

            Mail::to($formww->created_by->email)->send(new Sent($formww, 'Permohonan Penggabungan dengan Badan Perunding Dalam Malaysia'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar.']);
        }
    }

    //Officer CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function officer_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang WW - Butiran Pegawai";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formww = FormWW::findOrFail($request->id);
        $officers = $formww->officers()->with(['designation', 'address'])->get();

        while($officers->count() < 5)
            $officers->push(new Officer(['name' => '', 'identification_no ' => '', 'occupation' => '']));

        return datatables()->of($officers)
            ->editColumn('address', function ($officer) {
                if($officer->address)
                    return $officer->address->address1.
                        ($officer->address->address2 ? ',<br>'.$officer->address->address2 : '').
                        ($officer->address->address3 ? ',<br>'.$officer->address->address3 : '').
                        ',<br>'.
                        $officer->address->postcode.' '.
                        ($officer->address->district ? $officer->address->district->name : '').', '.
                        ($officer->address->state ? $officer->address->state->name : '');
                else
                    return "";
            })
            ->editColumn('designation.name', function ($officer) {
                return $officer->designation ? $officer->designation->name : '';
            })
            ->editColumn('date_of_birth', function($officer) {
                return $officer->date_of_birth ? date('d/m/Y', strtotime($officer->date_of_birth)) : '';
            })
            ->editColumn('action', function ($officer) {
                $button = "";

                if($officer->id) {
                    $button .= '<a onclick="editOfficer('.$officer->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                    $button .= '<a onclick="removeOfficer('.$officer->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';
                } else {
                    $button .= '<a onclick="addOfficer()" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
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
    public function officer_insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'age' => 'required|integer',
            'designation_id' => 'required',
            'date_of_birth' => 'required',
            'occupation' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create($request->all());

        $formww = FormWW::findOrFail($request->id);
        $officer = $formww->officers()->create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'name' => $request->name,
            'designation_id' => $request->designation_id,
            'age' => $request->age,
            'date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->toDateTimeString(),
            'occupation' => $request->occupation,
            'address_id' => $address->id,
            'created_by_user_id' => $request->created_by_user_id,
        ]);

        $count = $formww->officers->count();

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang WW - Butiran Pegawai";
        $log->data_new = json_encode($officer);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.', 'count' => $count]);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function officer_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang WW - Butiran Pegawai";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formww = FormWW::findOrFail($request->id);
        $officer = Officer::findOrFail($request->officer_id);
        $states = MasterState::all();
        $designations = MasterDesignation::all();

        return view('incorporation.consultation.formww.tab2.edit', compact('formww', 'officer', 'states', 'designations'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function officer_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'age' => 'required|integer',
            'designation_id' => 'required',
            'date_of_birth' => 'required',
            'occupation' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $officer = Officer::findOrFail($request->officer_id);

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang WW - Butiran Pegawai";
        $log->data_old = json_encode($officer);

        $address = Address::findOrFail($officer->address_id)->update($request->all());
        $officer->update([
            'name' => $request->name,
            'designation_id' => $request->designation_id,
            'age' => $request->age,
            'date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->toDateTimeString(),
            'occupation' => $request->occupation,
            'created_by_user_id' => $request->created_by_user_id,
        ]);

        $log->data_new = json_encode($officer);
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
    public function officer_delete(Request $request) {

        $formww = FormWW::findOrFail($request->id);
        $officer = Officer::findOrFail($request->officer_id);

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang WW - Butiran Pegawai";
        $log->data_old = json_encode($officer);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $officer->delete();

        $count = $formww->officers->count();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.', 'count' => $count]);
    }
    //Officer CRUD END

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($formww, $target) {

        $check = $formww->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ppw") {
            if($formww->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormWW')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $formww->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formww->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($formww, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));
        }
        else if($target == "pw") {
            if($formww->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $formww->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formww->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($formww, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));
        }
        else if($target == "pphq") {
            if($formww->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormWW')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $formww->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formww->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($formww, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));
        }
        else if($target == "pkpg") {
            if($formww->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',12)->first();

            $formww->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formww->filing_status_id,
                    'assigned_to_user_id' => $pkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpg->user->email)->send(new Distributed($formww, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));
        }
        else if($target == "kpks") {
            if($formww->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $formww->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formww->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($formww, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $formww = FormWW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang WW - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formww.process.query.item', $formww->id);
        $route2 = route('formww.process.query', $formww->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $formww = FormWW::findOrFail($request->id);

        if(count($formww->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang WW - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formww->filing_status_id = 5;
        $formww->is_editable = 1;
        $formww->save();

        $log2 = $formww->logs()->updateOrCreate(
            [
                'module_id' => 13,
                'activity_type_id' => 13,
                'filing_status_id' => $formww->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $formww->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formww, 'Kuiri notis Borang WW oleh PW'));
        } else if(auth()->user()->hasRole('pkpg')) {
            // Send to PPHQ
            $log = $formww->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formww, 'Kuiri notis Borang WW oleh PKPG'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to PKPG
            $log = $formww->logs()->where('role_id', 12)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formww, 'Kuiri notis Borang WW oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($formww->created_by->email)->send(new Queried(auth()->user(), $formww, 'Kuiri notis Borang WW'));
        }

        $formww->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 13;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang WW - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formww = FormWW::findOrFail($request->id);

            $queries = $formww->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $formww = FormWW::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 13;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang WW - Kuiri";
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
            $query = $formww->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 13;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang WW - Kuiri";
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
        $log->module_id = 13;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang WW - Kuiri";
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

        $formww = FormWW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang WW - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $formww->logs()->where('activity_type_id',14)->where('filing_status_id', $formww->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('formww.process.recommend', $formww->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang WW - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formww = FormWW::findOrFail($request->id);
        $formww->filing_status_id = 6;
        $formww->is_editable = 0;
        $formww->save();

        $formww->logs()->updateOrCreate(
            [
                'module_id' => 13,
                'activity_type_id' => 14,
                'filing_status_id' => $formww->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($formww, 'pw');
        else if(auth()->user()->hasRole('pw'))
            $this->distribute($formww, 'pphq');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($formww, 'pkpg');
        else if(auth()->user()->hasRole('pkpg'))
            $this->distribute($formww, 'kpks');

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $formww = FormWW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang WW - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formww.process.delay', $formww->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang WW - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formww = FormWW::findOrFail($request->id);
        $formww->filing_status_id = 7;
        $formww->is_editable = 0;
        $formww->save();

        $formww->logs()->updateOrCreate(
            [
                'module_id' => 13,
                'activity_type_id' => 15,
                'filing_status_id' => $formww->filing_status_id,
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
    public function process_result(Request $request) {

        $form = $formww = FormWW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang WW - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("formww.process.result.reject", $form->id);
        $route_approve = route("formww.process.result.approve", $form->id);
        $route_delay = route("formww.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $formww = FormWW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang WW - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formww.process.result.approve', $formww->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang WW - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formww = FormWW::findOrFail($request->id);
        $formww->filing_status_id = 9;
        $formww->is_editable = 0;
        $formww->save();

        $formww->logs()->updateOrCreate(
            [
                'module_id' => 13,
                'activity_type_id' => 16,
                'filing_status_id' => $formww->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formww->created_by->email)->send(new ApprovedKS($formww, 'Status Permohonan Penggabungan dengan Badan Berkanun Dalam Malaysia'));
        Mail::to($formww->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formww, 'Status Permohonan Penggabungan dengan Badan Berkanun Dalam Malaysia'));
        Mail::to($formww->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formww, 'Status Permohonan Penggabungan dengan Badan Berkanun Dalam Malaysia'));
        Mail::to($formww->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formww, 'Status Permohonan Penggabungan dengan Badan Berkanun Dalam Malaysia'));
        Mail::to($formww->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($formww, 'Sedia Dokumen Kelulusan Penggabungan dengan Badan Berkanun Dalam Malaysia'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $formww = FormWW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang WW - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formww.process.result.reject', $formww->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 13;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang WW - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formww = FormWW::findOrFail($request->id);
        $formww->filing_status_id = 8;
        $formww->is_editable = 0;
        $formww->save();

        $formww->logs()->updateOrCreate(
            [
                'module_id' => 13,
                'activity_type_id' => 16,
                'filing_status_id' => $formww->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formww->created_by->email)->send(new Rejected($formww, 'Status Permohonan Penggabungan dengan Badan Berkanun Dalam Malaysia'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function download(Request $request) {

        $filing = FormWW::findOrFail($request->id);                                                      // Change here
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
            'consultant_name' => htmlspecialchars($filing->consultant_name),
            'consultant_address' => htmlspecialchars($filing->consultant_address),
            'meeting_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'resolved_at' => htmlspecialchars(strftime('%e %B %Y', strtotime($filing->resolved_at))),
            'today_day' => htmlspecialchars(strftime('%e')),
            'today_month_year' =>  htmlspecialchars(strftime('%B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 13;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/formwww/formww.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate list
        $purposes = $filing->purposes;

        $document->cloneBlockString('list', count($purposes));

        foreach($purposes as $index => $purpose){
            $content = preg_replace('~\R~u', '<w:br/>', $purpose->purpose);
            $document->setValue('objective', strtoupper($content), 1);
        }

        // Generate table officer
        $rows2 = $filing->officers;
        $document->cloneRow('designation', count($rows2));

        foreach($rows2 as $index => $row2) {
            $document->setValue('designation#'.($index+1), ($row2->designation ? htmlspecialchars(strtoupper($row2->designation->name)) : ''));
            $document->setValue('name#'.($index+1), htmlspecialchars(strtoupper($row2->name)));
            $document->setValue('dob#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row2->date_of_birth))));
            $document->setValue('address#'.($index+1), htmlspecialchars(strtoupper($row2->address->address1)).
                ($row2->address->address2 ? ', '.htmlspecialchars(strtoupper($row2->address->address2)) : '').
                ($row2->address->address3 ? ', '.htmlspecialchars(strtoupper($row2->address->address3)) : '').
                ', '.($row2->address->postcode).
                ($row2->address->district ? ' '.htmlspecialchars(strtoupper($row2->address->district->name)) : '').
                ($row2->address->state ? ', '.htmlspecialchars(strtoupper($row2->address->state->name)) : '')
            );
            $document->setValue('occupation#'.($index+1), htmlspecialchars(strtoupper($row2->occupation)));
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang WW';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
