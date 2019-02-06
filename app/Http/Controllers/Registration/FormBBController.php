<?php

namespace App\Http\Controllers\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OtherModel\Address;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\MasterModel\MasterSectorCategory;
use App\MasterModel\MasterFederationType;
use App\MasterModel\MasterConstitutionTemplate;
use App\MasterModel\MasterMeetingType;
use App\MasterModel\MasterSector;
use App\MasterModel\MasterState;
use App\MasterModel\MasterCountry;
use App\MasterModel\MasterDesignation;
use App\FilingModel\Officer;
use App\FilingModel\FormBB;
use App\LogModel\LogFiling;
use App\LogModel\LogSystem;
use App\FilingModel\Query;
use App\FilingModel\FormO;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\FormBB\Sent;
use App\Mail\FormBB\Delayed;
use App\Mail\FormBB\Approved;
use App\Mail\FormBB\Rejected;
use App\Mail\FormBB\NotReceived;
use App\Mail\FormBB\ReminderMeeting;
use App\Mail\FormBB\DocumentApproved;
use App\UnionFederation;
use App\UserUnion;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class FormBBController extends Controller
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

        if(auth()->user()->hasRole('ks')) {
            if(auth()->user()->entity->formbb) {
                $formbb = auth()->user()->entity->formbb;
            }
            else {
                $tenure = auth()->user()->entity->tenures()->create([]);
                $address = Address::create([]);
                $formbb = FormBB::create([
                    'tenure_id' => $tenure->id,
                    'user_federation_id' => auth()->user()->entity->id,
                    'address_id' => $address->id,
                    'created_by_user_id' => auth()->id(),
                    'applied_at' => Carbon::now(),
                ]);
            }
        }
        else
            $formbb = FormBB::findOrFail($request->id);

        $errors_bb2 = count(($this->getErrors($formbb))['bb2']);
        $errors_bb3 = count(($this->getErrors($formbb))['bb3']);
        // dd($errors_bb2);
        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan Borang BB - Permohonan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('registration.formbb.index', compact('formbb','errors_bb2','errors_bb3'));
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 9;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang BB";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formbb = FormBB::with(['federation','status'])->where('filing_status_id', '>', 1);

            if(auth()->user()->hasRole('ks')) {
                $formbb = $formbb->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $formbb = $formbb->where(function($formbb) {
                    return $formbb->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($formbb){
                        if(auth()->user()->hasRole('ptw'))
                            return $formbb->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $formbb->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $formbb = $formbb->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($formbb)
                 ->editColumn('applied_at', function ($formbb) {
                    return date('d/m/Y', strtotime($formbb->applied_at));
                })
                ->editColumn('status.name', function ($formbb) {
                    if($formbb->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$formbb->status->name.'</span>';
                    else if($formbb->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$formbb->status->name.'</span>';
                    else if($formbb->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$formbb->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$formbb->status->name.'</span>';
                })
                ->editColumn('letter', function($formbb) {
                    $result = "";
                    if($formbb->filing_status_id == 9){
                        $result .= letterButton(6, get_class($formbb), $formbb->id);
                        $result .= letterButton(7, get_class($formbb), $formbb->id);
                        $result .= letterButton(8, get_class($formbb), $formbb->id);
                        $result .= letterButton(9, get_class($formbb), $formbb->id);
                    }
                    elseif($formbb->filing_status_id == 8)
                        $result .= letterButton(10, get_class($formbb), $formbb->id);
                    return $result;
                })
                ->editColumn('action', function ($formbb) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($formbb)).'\','.$formbb->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $formbb->is_editable)) && $formbb->filing_status_id < 7)
                        $button .= '<a href="'.route('formbb', ['id' => $formbb->id]).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';

                    if( ((auth()->user()->hasRole('ptw') && $formbb->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $formbb->distributions->count() == 3)) && $formbb->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$formbb->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';

                    if(auth()->user()->hasRole('pthq') && $formbb->sector_id <> 3 && $formbb->filing_status_id < 7)
                        $button .= '<a onclick="category('.$formbb->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Kategori</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw', 'pphq','pw', 'pkpg', 'kpks']) && $formbb->filing_status_id < 8)
                        $button .= '<a onclick="query('.$formbb->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg']) && $formbb->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$formbb->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';

                    if(auth()->user()->hasRole('kpks') && $formbb->filing_status_id < 8)
                        $button .= '<a onclick="process('.$formbb->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 9;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang BB";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }
        return view('registration.formbb.list');
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function review(Request $request) {
        return view('registration.formbb.review');
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function bb2_index(Request $request) {

        $federation_type = MasterFederationType::all();
        $sectors = MasterSector::all();
        $states = MasterState::all();
        $countries = MasterCountry::all();
        $designations = MasterDesignation::all();
        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();
        $formo = FormO::where('federation_name','LIKE', auth()->user()->entity->name)->where('filing_status_id', '>', 1)->get();

        if(auth()->user()->hasRole('ks')) {
            if(auth()->user()->entity->formbb) {
                $formbb = auth()->user()->entity->formbb;
            }
            else {
                $tenure = auth()->user()->entity->tenures()->create([]);
                $address = Address::create([]);
                $formbb = FormBB::create([
                    'tenure_id' => $tenure->id,
                    'user_federation_id' => auth()->user()->entity->id,
                    'address_id' => $address->id,
                    'created_by_user_id' => auth()->id(),
                ]);

                foreach($formo as $o) {
                    $o->union()->update(['user_federation_id' => auth()->user()->entity->id]);
                }
            }
        }
        else
            $formbb = FormBB::findOrFail($request->id);

        return view('registration.formbb.bb2.index', compact('formbb', 'federation_type', 'sectors', 'states', 'countries', 'unions', 'designations','meeting_types','formo'));
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function bb3_index(Request $request) {

        if(auth()->user()->hasRole('ks')) {
            $formbb = auth()->user()->entity->formbb;
        }
        else
            $formbb = FormBB::findOrFail($request->id);


        if($formbb->bb3) {
            $formbb3 = $formbb->bb3;
        }
        else {
            $formbb3 = auth()->user()->entity->formbb->bb3()->create([
                'created_by_user_id' => auth()->id(),
            ]);
        }

        return view('registration.formbb.bb3.index', compact('formbb','formbb3'));
    }

    //Officer CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function officer_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang BB - Butiran Pegawai";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        if(auth()->user()->hasRole('ks'))
            $formbb = auth()->user()->entity->formbb;
        else
            $formbb = FormBB::findOrFail($request->id);

        $officers = $formbb->tenure->officers()->with(['designation', 'address'])->get();

        while($officers->count() < 7)
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
            ->editColumn('action', function ($officer) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="editOfficer('.$officer->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                if($officer->id)
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
            'name' => 'required|string',
            'identification_no' => 'required|string',
            'occupation' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create($request->all());
        $request->request->add(['address_id' => $address->id]);

        if(auth()->user()->hasRole('ks'))
            $formbb = auth()->user()->entity->formbb;
        else
            $formbb = FormBB::findOrFail($request->id);

        if($request->input('is_malaysian') == 1) {
            $malaysia = MasterCountry::findOrFail(1);
            $request->merge(['nationality_country_id' => $malaysia->id]);
        }

        $officer = $formbb->tenure->officers()->save(new Officer($request->all()));

        $count = $formbb->tenure->officers->count();

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang BB - Butiran Pegawai";
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
        $log->module_id = 9;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang BB - Butiran Pegawai";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $officer = Officer::findOrFail($request->id);
        $states = MasterState::all();
        $countries = MasterCountry::all();
        $designations = MasterDesignation::all();

        return view('registration.formbb.bbb2.tabb2.edit', compact('officer', 'states', 'countries', 'designations'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function officer_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'identification_no' => 'required|string',
            'occupation' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $officer = Officer::findOrFail($request->id);
        $address = Address::findOrFail($officer->address_id)->update($request->all());

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang BB - Butiran Pegawai";
        $log->data_old = json_encode($officer);

        $officer->update($request->all());
        $officer->address()->update($request->all());

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

        $officer = Officer::findOrFail($request->id);

        if(auth()->user()->hasRole('ks'))
            $formbb = auth()->user()->entity->formbb;
        else
            $formbb = FormBB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang BB - Butiran Pegawai";
        $log->data_old = json_encode($officer);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $officer->delete();

        $count = $formbb->tenure->officers->count();


       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.', 'count' => $count]);
    }
    //Officer CRUD END

    public function praecipe(Request $request) {

        if(auth()->user()->hasRole('ks')) {
            $formbb = auth()->user()->entity->formbb;
        }
        else
            $formbb = FormBB::findOrFail($request->id);

        $pdf = PDF::loadView('registration.formbb.praecipe', compact('formbb'));
        return $pdf->setPaper('A4')->setOrientation('portrait')->download('praecipe.pdf');
    }


    private function getErrors($formbb) {

        $errors = [];

        if(!$formbb) {
            $errors['bb2'] = [null,null,null,null,null,null,null,null,null];
            $errors['bb3'] = [null,null,null,null,null,null,null];
        }
        else {
            $validate_formbb2 = Validator::make($formbb->toArray(), [
                'federation_type_id' => 'required|integer',
                'sector_id' => 'required|integer',
                'resolved_at' => 'required',
                'meeting_type_id' => 'required|integer',
            ]);

            $errors_bb2 = [];

            if ($validate_formbb2->fails())
                $errors_bb2 = array_merge($errors_bb2, $validate_formbb2->errors()->toArray());

            $validate_address = Validator::make($formbb->address->toArray(), [
                'address1' => 'required|string',
                'postcode' => 'required|digits:5',
                'district_id' => 'required|integer',
                'state_id' => 'required|integer',
            ]);

            if ($validate_address->fails())
                $errors_bb2 = array_merge($errors_bb2, $validate_address->errors()->toArray());

            if($formbb->tenure->officers->count() < 7)
                $errors_bb2 = array_merge($errors_bb2, ['officers' => ['Jumlah pegawai kurang dari 7 orang.']]);

            $errors['bb2'] = $errors_bb2;

            //////////////////////////////////////////////////////////////////////////////////////////////////

            if(!$formbb->bb3) {
                $errors['bb3'] = [null,null,null,null,null,null,null];
            }
            else {

                $validate_formbb3 = Validator::make($formbb->bb3->toArray(), [
                    'entrance_fee' => 'required|numeric',
                    'yearly_fee' => 'required|numeric',
                    'convention_yearly' => 'required|integer',
                    'first_member' => 'required|integer',
                    'next_member' => 'required|integer',
                    'max_savings' => 'required|numeric',
                    'max_expenses' => 'required|numeric',
                ]);

                $errors_bb3 = [];

                if ($validate_formbb3->fails())
                    $errors_bb3 = array_merge($errors_bb3, $validate_formbb3->errors()->toArray());

                $errors['bb3'] = $errors_bb3;
            }

        }

        return $errors;
    }

    private function generateConstitution($formbb) {

        $constitutionTemplates = MasterConstitutionTemplate::where('constitution_type_id', 3)->get();
        $form = $formbb->bb3;

        $constitution = $formbb->federation->constitutions()->create([
            'created_by_user_id' => auth()->id(),
        ]);

        $log_connection = [];

        foreach($constitutionTemplates as $template) {
            preg_match_all('/(?<replace>\_(?<variable>\w*)\_)/', $template->content, $matches);
            $vars_array = $matches['variable'];
            $replace = $matches['replace'];

            if($vars_array)
                foreach($vars_array as $index => $var) {
                    if($var == "entity_name") {
                        $template->content = str_replace($replace[$index], strtoupper($formbb->tenure->entity->name), $template->content);

                    } else if($var == "address") {
                        $address = "";
                        $address .= $formbb->address->address1
                                    .($formbb->address->address2 ? ', '.$formbb->address->address2 : '')
                                    .($formbb->address->address3 ? ', '.$formbb->address->address3 : '')
                                    .', '.$formbb->address->postcode.' '
                                    .($formbb->address->district ? $formbb->address->district->name : '')
                                    .', '.($formbb->address->state ? $formbb->address->state->name : '');
                        $template->content = str_replace($replace[$index], $address, $template->content);

                    } else if(stripos($var, "convention_yearly") !== false) {
                        $obj = object_get($form, "convention_yearly");
                        if($obj == 1) {
                            $template->content = str_replace($replace[$index]." ", "", $template->content);

                        } else if($obj == 2) {
                            $template->content = str_replace($replace[$index], checkCaps($var, "Dwi"), $template->content);

                        } else {
                            $template->content = str_replace($replace[$index], checkCaps($var, "Tiga"), $template->content);
                        }

                    } else if(strpos($var, "text") !== false) {
                        $var = str_replace("_text", "", $var);

                        if(strpos($var, "max") !== false)
                            $template->content = str_replace($replace[$index], decimalToRinggit(object_get($form, $var)), $template->content);
                        else
                            $template->content = str_replace($replace[$index], numberToWords(object_get($form, $var)), $template->content);
                    } else {
                        $template->content = str_replace($replace[$index],  checkCaps($var, object_get($form, $var)), $template->content);
                    }

                }

            $item = $constitution->items()->create([
                'code' => $template->code,
                'content' => $template->content,
                'parent_constitution_item_id' => $template->parent_constitution_template_id ? $log_connection[$template->parent_constitution_template_id] : null,
                'below_constitution_item_id' => $template->below_constitution_template_id ? $log_connection[$template->below_constitution_template_id] : null,
                'constitution_template_id' => $template->id,
            ]);

            $log_connection[$template->id] = $item->id;
        }

        return $constitution;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        if(auth()->user()->hasRole('ks'))
            $formbb = auth()->user()->entity->formbb;
        else
            $formbb = FormBB::findOrFail($request->id);

        $errors =  count(($this->getErrors($formbb))['bb2']) + count(($this->getErrors($formbb))['bb3']);
        // return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 9;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang BB - Hantar Permohonan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formbb->applied_at = date('Y-m-d');
            $formbb->filing_status_id = 2;
            $formbb->is_editable = 0;
            $formbb->save();

            $constitution = $this->generateConstitution($formbb);

            $formbb->logs()->updateOrCreate(
                [
                    'module_id' => 9,
                    'activity_type_id' => 11,
                    'filing_status_id' => $formbb->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $formbb->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 9,
            ]);

            Mail::to($formbb->created_by->email)->send(new Sent($formbb, 'Penghantaran Borang BB'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($formbb, $target) {

        $check = $formbb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($formbb->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormBB')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $formbb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formbb->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($formbb->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormBB')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $formbb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formbb->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($formbb, 'Serahan Borang BB'));
        }
        else if($target == "pw") {
            if($formbb->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $formbb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formbb->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($formbb, 'Serahan Borang BB'));
        }
        else if($target == "pthq") {
            if($formbb->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormBB')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $formbb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formbb->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($formbb->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormBB')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $formbb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formbb->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($formbb, 'Serahan Borang BB'));
        }
        else if($target == "pkpg") {
            if($formbb->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',12)->first();

            $formbb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formbb->filing_status_id,
                    'assigned_to_user_id' => $pkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpg->user->email)->send(new Distributed($formbb, 'Serahan Borang BB'));
        }
        else if($target == "kpks") {
            if($formbb->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $formbb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formbb->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($formbb, 'Serahan Borang BB'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $formbb = FormBB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang BB - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formbb.process.document-receive', $formbb->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang BB - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formbb = FormBB::findOrFail($request->id);

        $formbb->filing_status_id = 3;
        $formbb->save();

        $formbb->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 9,
            ]
        );

        $formbb->logs()->updateOrCreate(
            [
                'module_id' => 9,
                'activity_type_id' => 12,
                'filing_status_id' => $formbb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($formbb, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($formbb, 'ppw');
            Mail::to($formbb->created_by->email)->send(new Received(auth()->user(), $formbb, 'Pengesahan Penerimaan Borang BB'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($formbb, 'pphq');
            Mail::to($formbb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formbb, 'Pengesahan Penerimaan Borang BB'));
            Mail::to($formbb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formbb, 'Pengesahan Penerimaan Borang BB'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $formbb = FormBB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang BB - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formbb.process.query.item', $formbb->id);
        $route2 = route('formbb.process.query', $formbb->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $formbb = FormBB::findOrFail($request->id);

        if(count($formbb->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang BB - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formbb->filing_status_id = 5;
        $formbb->is_editable = 1;
        $formbb->save();

        $log2 = $formbb->logs()->updateOrCreate(
            [
                'module_id' => 9,
                'activity_type_id' => 13,
                'filing_status_id' => $formbb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $formbb->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formbb, 'Kuiri Permohonan Borang BB oleh PW'));
        } else if(auth()->user()->hasRole('pkpg')) {
            // Send to PPHQ
            $log = $formbb->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formbb, 'Kuiri Permohonan Borang BB oleh PKPG'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to PKPG
            $log = $formbb->logs()->where('role_id', 12)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formbb, 'Kuiri Permohonan Borang BB oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($formbb->created_by->email)->send(new Queried(auth()->user(), $formbb, 'Kuiri Permohonan Borang B'));
        }

        $formbb->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 9;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang BB - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formbb = FormBB::findOrFail($request->id);

            $queries = $formbb->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $formbb = FormBB::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 9;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang BB - Kuiri";
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
            $query = $formbb->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 9;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang BB - Kuiri";
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
        $log->module_id = 9;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang BB - Kuiri";
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

        $formbb = FormBB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang BB - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $formbb->logs()->where('activity_type_id',14)->where('filing_status_id', $formbb->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('formbb.process.recommend', $formbb->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang BB - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formbb = FormBB::findOrFail($request->id);
        $formbb->filing_status_id = 6;
        $formbb->is_editable = 0;
        $formbb->save();

        $formbb->logs()->updateOrCreate(
            [
                'module_id' => 9,
                'activity_type_id' => 14,
                'filing_status_id' => $formbb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($formbb, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($formbb, 'pkpg');
        else if(auth()->user()->hasRole('pkpg'))
            $this->distribute($formbb, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($formbb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $formbb, 'Serahan Borang BB ke Ibu Pejabat'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_category_edit(Request $request) {

        $formbb = FormBB::findOrFail($request->id);
        $sector_categories = MasterSectorCategory::where('sector_id', $formbb->sector_id)->get();

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Borang BB - Kategori Sektor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formbb.process.category', $formbb->id);
        $form = $formb;

        return view('general.modal.sector-category', compact('form','route','sector_categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_category_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang BB - Kategori Sektor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formbb = FormBB::findOrFail($request->id);

        $formbb->update($request->all());

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $formbb = FormBB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang BB - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formbb.process.delay', $formbb->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang BB - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formbb = FormBB::findOrFail($request->id);
        $formbb->filing_status_id = 7;
        $formbb->is_editable = 0;
        $formbb->save();

        $formbb->logs()->updateOrCreate(
            [
                'module_id' => 9,
                'activity_type_id' => 15,
                'filing_status_id' => $formbb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formbb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pkpg'); })->first()->assigned_to->email)->send(new Delayed($formbb, 'Penangguhan Kelulusan Borang BB'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result(Request $request) {

        $form = $formbb = FormBB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang BB - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("formbb.process.result.reject", $form->id);
        $route_approve = route("formbb.process.result.approve", $form->id);
        $route_delay = route("formbb.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $formbb = FormBB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang BB - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formbb.process.result.approve', $formbb->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang BB - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formbb = FormBB::findOrFail($request->id);
        $formbb->filing_status_id = 9;
        $formbb->is_editable = 0;
        $formbb->save();

        $formbb->logs()->updateOrCreate(
            [
                'module_id' => 9,
                'activity_type_id' => 16,
                'filing_status_id' => $formbb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formbb->created_by->email)->send(new Approved($formbb, 'Status Borang BB'));
        Mail::to($formbb->created_by->email)->send(new ReminderMeeting($formbb, 'Peringatan Mesyuarat Agung'));
        
        Mail::to($formbb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($formbb, 'Sedia Dokumen Kelulusan Borang BB'));

        // Set constitution status 1
        $formbb->federation->constitutions->first()->update(['filing_status_id' => 9]);
        // Set registration_no and province_office_id
        $formbb->federation->addresses()->create(['address_id' => $formbb->address_id]);
        $formbb->federation->update([
            'registration_no' => uniqid(),
            'province_office_id' => $formbb->address->state->province_office_id,
        ]);
        // Assign role to KS
        $formbb->created_by->assignRole('federation');

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Persekutuan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $formbb = FormBB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang BB - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formbb.process.result.reject', $formbb->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 9;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang BB - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formbb = FormBB::findOrFail($request->id);
        $formbb->filing_status_id = 8;
        $formbb->is_editable = 0;
        $formbb->save();

        $formbb->logs()->updateOrCreate(
            [
                'module_id' => 9,
                'activity_type_id' => 16,
                'filing_status_id' => $formbb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formbb->created_by->email)->send(new Rejected($formbb, 'Status Borang BB'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Persekutuan Kesatuan Sekerja ini telah ditolak. Persekutuan Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function download(Request $request) {

        $filing = FormBB::findOrFail($request->id);                                                      // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->federation->name),
            'entity_address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ', '.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars($filing->address->address3) : '').
                ', '.htmlspecialchars($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars($filing->address->district->name) : '').
                ($filing->address->state ? ', '.htmlspecialchars($filing->address->state->name) : ''),
            'registered_day' => htmlspecialchars(strftime('%e' , strtotime($filing->federation->registered_at))),
            'registered_month_year' => htmlspecialchars(strftime('%B %Y' , strtotime($filing->federation->registered_at))),
            'federation_type' => $filing->federation_type ? htmlspecialchars($filing->federation_type->name) : '',
            'sector_type' => $filing->federation->sector ? htmlspecialchars($filing->federation->sector->name) : '',
            'sector' => $filing->federation->industry_type ? htmlspecialchars($filing->federation->industry_type->name) : '',
            'secretary_name' => htmlspecialchars(strtoupper($filing->federation->user->name)),
            'today_day' => htmlspecialchars(strftime('%e')),
            'today_month_year' =>  htmlspecialchars(strftime('%B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 9;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/formbb/formbb2.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }
                // Generate list
        $unions = $filing->federation->unions;
        if(count($unions) > 0){
            $document->cloneBlockString('list1', count($unions)-1);

            foreach($unions as $index => $union){
                $content = preg_replace('~\R~u', '<w:br/>', $union->name);
                $document->setValue('union_name_list', strtoupper($content), 1);
            }
        }
        else{
            $document->deleteBlockString('list1');
            $document->setValue('union_name_list', '-', 1);
        }

        // Generate list
        $officers = $filing->tenure->officers;

        $document->cloneBlockString('list2', count($officers));

        foreach($officers as $index => $officer){
            $content = preg_replace('~\R~u', '<w:br/>', $officer->name);
            $document->setValue('requester_name_list', strtoupper($content), 1);
        }

        // Generate table officer
        $rows2 = $filing->tenure->officers;
        $document->cloneRow('officer_designation', count($rows2));

        foreach($rows2 as $index => $row2) {
            $document->setValue('officer_designation#'.($index+1), ($row2->designation ? htmlspecialchars(strtoupper($row2->designation->name)) : ''));
            $document->setValue('officer_name#'.($index+1), htmlspecialchars(strtoupper($row2->name)));
            $document->setValue('officer_ic#'.($index+1), htmlspecialchars(strtoupper($row2->identification_no)));
            $document->setValue('officer_age#'.($index+1), htmlspecialchars(strtoupper($row2->age)));
            $document->setValue('officer_address#'.($index+1), htmlspecialchars(strtoupper($row2->address->address1)).
                ($row2->address->address2 ? ', '.htmlspecialchars(strtoupper($row2->address->address2)) : '').
                ($row2->address->address3 ? ', '.htmlspecialchars(strtoupper($row2->address->address3)) : '').
                ', '.($row2->address->postcode).
                ($row2->address->district ? ' '.htmlspecialchars(strtoupper($row2->address->district->name)) : '').
                ($row2->address->state ? ', '.htmlspecialchars(strtoupper($row2->address->state->name)) : '')
            );
            $document->setValue('officer_occupation#'.($index+1), htmlspecialchars(strtoupper($row2->occupation)));
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang BB2';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function bb3_download(Request $request) {

        $filing = FormBB::findOrFail($request->id);                                                    // Change here

        $convention_yearly = '';
        if($filing->bb3->convention_yearly == 1)
            $convention_yearly = 'Satu';
        elseif($filing->bb3->convention_yearly == 2)
            $convention_yearly = 'Dwi';
        elseif($filing->bb3->convention_yearly == 3)
            $convention_yearly = 'Tiga';

        $data = [
            'entity_name_uppercase' => htmlspecialchars(strtoupper($filing->federation->name)),
            'entity_name' => htmlspecialchars($filing->federation->name),
            'entity_address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ', '.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars($filing->address->address3) : '').
                ', '.($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars($filing->address->district->name) : '').
                ($filing->address->state ? ', '.htmlspecialchars($filing->address->state->name) : ''),
            'registration_no' => htmlspecialchars($filing->federation->registration_no),
            'entrance_fee' => htmlspecialchars($filing->bb3->entrance_fee),
            'yearly_fee' => htmlspecialchars($filing->bb3->yearly_fee),
            'convention_yearly' => htmlspecialchars($convention_yearly),
            'convention_yearly_uppercase' => htmlspecialchars(strtoupper($convention_yearly)),
            'first_member' => htmlspecialchars($filing->bb3->first_member),
            'next_member' => htmlspecialchars($filing->bb3->next_member),
            'max_savings' => htmlspecialchars($filing->bb3->max_savings),
            'max_expenses' => htmlspecialchars($filing->bb3->max_expenses),
            'max_savings_word' => htmlspecialchars(ucwords(decimalToRinggit($filing->bb3->max_savings))),
            'max_expenses_word' => htmlspecialchars(ucwords(decimalToRinggit($filing->bb3->max_expenses))),
        ];

        $log = new LogSystem;
        $log->module_id = 9;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/formbb/formbb3.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang BB3';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

}
