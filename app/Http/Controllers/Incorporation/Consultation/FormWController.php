<?php

namespace App\Http\Controllers\Incorporation\Consultation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\FilingModel\ConsultancyPurpose;
use App\FilingModel\FormWRequester;
use App\FilingModel\Officer;
use App\FilingModel\FormW;
use App\FilingModel\Query;
use App\OtherModel\Address;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\FormW\ApprovedKS;
use App\Mail\FormW\ApprovedPWN;
use App\Mail\FormW\Rejected;
use App\Mail\FormW\Sent;
use App\Mail\FormW\NotReceived;
use App\Mail\FormW\DocumentApproved;
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

class FormWController extends Controller
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

        $formw = FormW::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

    	return view('incorporation.consultation.formw.index', compact('formw', 'states','meeting_types', 'designations'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $formw = FormW::findOrFail($request->id);

        $states = MasterState::all();
        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();
        $designations = MasterDesignation::all();

        return view('incorporation.consultation.formw.index', compact('formw', 'states','meeting_types', 'designations'));
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 14;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang W";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formw = FormW::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $formw = $formw->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $formw = $formw->where('filing_status_id', '>', 1)->where(function($formw) {
                    return $formw->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($formw){
                        if(auth()->user()->hasRole('ptw'))
                            return $formw->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $formw->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $formw = $formw->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($formw)
                ->editColumn('applied_at', function ($formw) {
                    return $formw->applied_at ? date('d/m/Y', strtotime($formw->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($formw) {
                    if($formw->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$formw->status->name.'</span>';
                    else if($formw->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$formw->status->name.'</span>';
                    else if($formw->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$formw->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$formw->status->name.'</span>';
                })
                ->editColumn('letter', function($formw) {
                    $result = "";
                    if($formw->filing_status_id > 1)
                        $result .= '<a href="'.route('download.formw', $formw->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i>Borang W</a><br>';
                    if($formw->filing_status_id == 9)
                        $result .= letterButton(13, get_class($formw), $formw->id);
                    return $result;
                    // return '<a href="'.route('formw.pdf', $formw->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i>'.($formw->logs->count() > 0 ? date('d/m/Y', strtotime($formw->logs->first()->created_at)).' - ' : '').$formw->union->name.'</a><br>';
                })
                ->editColumn('action', function ($formw) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($formw)).'\','.$formw->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $formw->is_editable)) && $formw->filing_status_id < 7 )
                        $button .= '<a href="'.route('formw.form', $formw->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';

                    if( ((auth()->user()->hasRole('ptw') && $formw->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $formw->distributions->count() == 3)) && $formw->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$formw->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg', 'kpks']) && $formw->filing_status_id < 8 )
                        $button .= '<a onclick="query('.$formw->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg']) && $formw->filing_status_id < 7 )
                        $button .= '<a onclick="recommend('.$formw->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';

                    if(auth()->user()->hasRole('kpks') && $formw->filing_status_id < 8 )
                        $button .= '<a onclick="process('.$formw->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 14;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang W";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('incorporation.consultation.formw.list');
    }

    private function getErrors($formw_id) {

        $formw = FormW::findOrFail($formw_id);

        $errors = [];

        $validate_formw = Validator::make($formw->toArray(), [
            'consultant_name' => 'required|string',
            'consultant_address' => 'required|string',
            'consultant_phone' => 'required|string',
            'consultant_fax' => 'required|string',
            'consultant_email' => 'required|string|email',
            'resolved_at' => 'required',
            'meeting_type_id' => 'required|integer',
            'applied_at' => 'required',
        ]);

        if ($validate_formw->fails())
            $errors = array_merge($errors, $validate_formw->errors()->toArray());

        $errors = ['w' => $errors];

        return $errors;
    }

    public function purpose_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang W - Tujuan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formw = FormW::findOrFail($request->id);

        return datatables()->of($formw->purposes)
            ->editColumn('action', function ($purpose) {
                $button = "";
                $button .= '<button type="button" class="btn btn-danger btn-xs" onclick="removePurpose('.$purpose->id.')"><i class="fa fa-times"></i></button>';

                return $button;
            })
            ->make(true);
    }

    public function purpose_insert(Request $request) {

        $formw = FormW::findOrFail($request->id);
        $purpose = $formw->purposes()->create([
            'purpose' => $request->purpose,
        ]);

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang W - Tujuan";
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
        $log->module_id = 14;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang W - Tujuan";
        $log->data_old = json_encode($purpose);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $purpose->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    public function requester_index(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 14;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang W - Pemohon";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formw = FormW::findOrFail($request->id);
            $requesters = Officer::whereHas('formw_requester.formw', function($formw) use($request) {
                                    return $formw->where('formw_id', $request->id);
                                });

            return datatables()->of($requesters)
                ->editColumn('designation.name', function($requester) {
                    return $requester->designation->name;
                })
                ->editColumn('action', function ($requester) {
                    $button = "";
                    $button .= '<button type="button" class="btn btn-danger btn-xs" onclick="removeRequester('.$requester->id.')"><i class="fa fa-times"></i></button>';

                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 14;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang W - Pemohon";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('incorporation.consultation.formw.tab1', compact('requesters'));
    }

    public function requester_insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'officer_id' => 'unique:formw_requester,officer_id,null,null,formw_id,'.$request->id,
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $requester = FormWRequester::create([
            'formw_id' => $request->id,
            'officer_id' => $request->officer_id,
        ]);

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang W - Pemohon";
        $log->data_new = json_encode($requester);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.']);
    }

    public function requester_delete(Request $request) {

        $requester = FormWRequester::where('officer_id', $request->officer_id)->firstOrFail();

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang W - Pemohon";
        $log->data_old = json_encode($requester);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        FormWRequester::where('officer_id', $request->officer_id)->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $errors = ($this->getErrors($request->id))['w'];
        //return response()->json(['errors' => $errors], 422);

        if(count($errors) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 14;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang W - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formw = FormW::findOrFail($request->id);

            $formw->logs()->updateOrCreate(
                [
                    'module_id' => 14,
                    'activity_type_id' => 11,
                    'filing_status_id' => $formw->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $formw->filing_status_id = 2;
            $formw->is_editable = 0;
            $formw->save();

            $formw->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 14,
            ]);

            Mail::to($formw->created_by->email)->send(new Sent($formw, 'Permohonan Penggabungan dengan Badan Perunding Luar Malaysia'));

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
        $log->module_id = 14;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang W - Butiran Pegawai";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formw = FormW::findOrFail($request->id);
        $officers = $formw->officers()->with(['designation', 'address'])->get();

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

        $formw = FormW::findOrFail($request->id);
        $officer = $formw->officers()->create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'name' => $request->name,
            'designation_id' => $request->designation_id,
            'age' => $request->age,
            'date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->toDateTimeString(),
            'occupation' => $request->occupation,
            'address_id' => $address->id,
            'created_by_user_id' => $request->created_by_user_id,
        ]);

        $count = $formw->officers->count();

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang W - Butiran Pegawai";
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
        $log->module_id = 14;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang W - Butiran Pegawai";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formw = FormW::findOrFail($request->id);
        $officer = Officer::findOrFail($request->officer_id);
        $states = MasterState::all();
        $designations = MasterDesignation::all();

        return view('incorporation.consultation.formw.tab2.edit', compact('formw', 'officer', 'states', 'designations'));
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
        $log->module_id = 14;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang W - Butiran Pegawai";
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

        $formw = FormW::findOrFail($request->id);
        $officer = Officer::findOrFail($request->officer_id);

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang W - Butiran Pegawai";
        $log->data_old = json_encode($officer);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $officer->delete();

        $count = $formw->officers->count();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.', 'count' => $count]);
    }
    //Officer CRUD END

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($formw, $target) {

        $check = $formw->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($formw->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormW')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $formw->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formw->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($formw->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormW')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $formw->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formw->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($formw, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));
        }
        else if($target == "pw") {
            if($formw->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $formw->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formw->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($formw, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));
        }
        else if($target == "pthq") {
            if($formw->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormW')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $formw->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formw->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($formw->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormW')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $formw->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formw->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($formw, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));
        }
        else if($target == "pkpg") {
            if($formw->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',12)->first();

            $formw->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formw->filing_status_id,
                    'assigned_to_user_id' => $pkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpg->user->email)->send(new Distributed($formw, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));
        }
        else if($target == "kpks") {
            if($formw->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $formw->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formw->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($formw, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $formw = FormW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang W - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formw.process.document-receive', $formw->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang W - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formw = FormW::findOrFail($request->id);

        $formw->filing_status_id = 3;
        $formw->save();

        $formw->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 14,
            ]
        );

        $formw->logs()->updateOrCreate(
            [
                'module_id' => 14,
                'activity_type_id' => 12,
                'filing_status_id' => $formw->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($formw, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($formw, 'ppw');
            Mail::to($formw->created_by->email)->send(new Received(auth()->user(), $formw, 'Pengesahan Penerimaan Permohonan Penggabungan dengan Badan Perunding'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($formw, 'pphq');
            Mail::to($formw->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formw, 'Pengesahan Penerimaan Permohonan Penggabungan dengan Badan Perunding'));
            Mail::to($formw->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formw, 'Pengesahan Penerimaan Permohonan Penggabungan dengan Badan Perunding'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $formw = FormW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang W - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formw.process.query.item', $formw->id);
        $route2 = route('formw.process.query', $formw->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $formw = FormW::findOrFail($request->id);

        if(count($formw->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang W - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formw->filing_status_id = 5;
        $formw->is_editable = 1;
        $formw->save();

        $log2 = $formw->logs()->updateOrCreate(
            [
                'module_id' => 14,
                'activity_type_id' => 13,
                'filing_status_id' => $formw->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $formw->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formw, 'Kuiri Permohonan Borang W oleh PW'));
        } else if(auth()->user()->hasRole('pkpg')) {
            // Send to PPHQ
            $log = $formw->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formw, 'Kuiri Permohonan Borang W oleh PKPG'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to PKPG
            $log = $formw->logs()->where('role_id', 12)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formw, 'Kuiri Permohonan Borang W oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($formw->created_by->email)->send(new Queried(auth()->user(), $formw, 'Kuiri Permohonan Borang W'));
        }

        $formw->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 14;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang W - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formw = FormW::findOrFail($request->id);

            $queries = $formw->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $formw = FormW::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 14;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang W - Kuiri";
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
            $query = $formw->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 14;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang W - Kuiri";
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
        $log->module_id = 14;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang W - Kuiri";
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

        $formw = FormW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang W - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $formw->logs()->where('activity_type_id',14)->where('filing_status_id', $formw->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('formw.process.recommend', $formw->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang W - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formw = FormW::findOrFail($request->id);
        $formw->filing_status_id = 6;
        $formw->is_editable = 0;
        $formw->save();

        $formw->logs()->updateOrCreate(
            [
                'module_id' => 14,
                'activity_type_id' => 14,
                'filing_status_id' => $formw->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($formw, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($formw, 'pkpg');
        else if(auth()->user()->hasRole('pkpg'))
            $this->distribute($formw, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($formw->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $formw, 'Serahan Permohonan Penggabungan dengan Badan Perunding'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $formw = FormW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang W - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formw.process.delay', $formw->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang W - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formw = FormW::findOrFail($request->id);
        $formw->filing_status_id = 7;
        $formw->is_editable = 0;
        $formw->save();

        $formw->logs()->updateOrCreate(
            [
                'module_id' => 14,
                'activity_type_id' => 15,
                'filing_status_id' => $formw->filing_status_id,
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

        $form = $formw = FormW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang W - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("formw.process.result.reject", $form->id);
        $route_approve = route("formw.process.result.approve", $form->id);
        $route_delay = route("formw.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $formw = FormW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang W - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formw.process.result.approve', $formw->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang W - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formw = FormW::findOrFail($request->id);
        $formw->filing_status_id = 9;
        $formw->is_editable = 0;
        $formw->save();

        $formw->logs()->updateOrCreate(
            [
                'module_id' => 14,
                'activity_type_id' => 16,
                'filing_status_id' => $formw->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formw->created_by->email)->send(new ApprovedKS($formw, 'Status Permohonan Penggabungan dengan Badan Berkanun Luar Malaysia'));
        Mail::to($formw->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formw, 'Status Permohonan Penggabungan dengan Badan Berkanun Luar Malaysia'));
        Mail::to($formw->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formw, 'Status Permohonan Penggabungan dengan Badan Berkanun Luar Malaysia'));
        Mail::to($formw->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formw, 'Status Permohonan Penggabungan dengan Badan Berkanun Luar Malaysia'));
        Mail::to($formw->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($formw, 'Sedia Dokumen Kelulusan Penggabungan dengan Badan Berkanun Luar Malaysia'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $formw = FormW::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang W - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formw.process.result.reject', $formw->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 14;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang W - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formw = FormW::findOrFail($request->id);
        $formw->filing_status_id = 8;
        $formw->is_editable = 0;
        $formw->save();

        $formw->logs()->updateOrCreate(
            [
                'module_id' => 14,
                'activity_type_id' => 16,
                'filing_status_id' => $formw->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formw->created_by->email)->send(new Rejected($formw, 'Status Permohonan Penggabungan dengan Badan Berkanun Luar Malaysia'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function download(Request $request) {

        $filing = FormW::findOrFail($request->id);                                                      // Change here
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
        $log->module_id = 14;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/formwww/formw.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate list
        $purposes = $filing->purposes;

        $document->cloneBlockString('list', count($purposes));

        foreach($purposes as $index => $purpose){
            $content = preg_replace('~\R~u', '<w:br/>', $purpose->purpose);
            $document->setValue('objective', ucfirst($content), 1);
        }

        // Generate table requesters
        $rows = $filing->requesters;
        $document->cloneRow('no', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), ($index+1));
            $document->setValue('applicant_designation#'.($index+1), ($row->designation ? htmlspecialchars(strtoupper($row->designation->name)) : ''));
            $document->setValue('applicant_name#'.($index+1), htmlspecialchars(strtoupper($row->name)));
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
        $file_name = uniqid().'_'.'Borang W';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
