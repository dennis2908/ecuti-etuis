<?php

namespace App\Http\Controllers\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OtherModel\Address;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\MasterModel\MasterConstitutionTemplate;
use App\MasterModel\MasterSectorCategory;
use App\MasterModel\MasterDesignation;
use App\MasterModel\MasterMeetingType;
use App\MasterModel\MasterUnionType;
use App\MasterModel\MasterCountry;
use App\MasterModel\MasterSector;
use App\MasterModel\MasterState;
use App\LogModel\LogFiling;
use App\LogModel\LogSystem;
use App\FilingModel\Query;
use App\FilingModel\FormB;
use App\FilingModel\Tenure;
use App\FilingModel\Officer;
use App\FilingModel\Requester;
use App\FilingModel\Distribution;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\FormB\Sent;
use App\Mail\FormB\Delayed;
use App\Mail\FormB\Approved;
use App\Mail\FormB\Rejected;
use App\Mail\FormB\NotReceived;
use App\Mail\FormB\ReminderMeeting;
use App\Mail\FormB\DocumentApproved;
use Carbon\Carbon;
use App\UserStaff;
use App\User;
use Validator;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class FormBController extends Controller
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
            if(auth()->user()->entity->formb) {
                $formb = auth()->user()->entity->formb;
            }
            else {
                $tenure = auth()->user()->entity->tenures()->create([]);
                $address = Address::create([]);
                $formb = FormB::create([
                    'tenure_id' => $tenure->id,
                    'user_union_id' => auth()->user()->entity->id,
                    'address_id' => $address->id,
                    'created_by_user_id' => auth()->id(),
                    'applied_at' => Carbon::now(),
                ]);
            }
        }
        else
            $formb = FormB::findOrFail($request->id);

        $errors_b2 = count(($this->getErrors($formb))['b2']);

        if($formb){
            if($formb->has_branch == '0')
                $errors_b3 = count(($this->getErrors($formb))['b3']);
            elseif($formb->has_branch == '1')
                $errors_b4 = count(($this->getErrors($formb))['b4']);
        }

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan Borang B - Permohonan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();



        return view('registration.formb.index', compact('formb','errors_b2', 'errors_b3','errors_b4'));
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 7;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang B";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formb = FormB::with(['union','status'])->where('filing_status_id', '>', 1);

            if(auth()->user()->hasRole('ks')) {
                $formb = $formb->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $formb = $formb->where(function($formb) {
                    return $formb->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($formb){
                        if(auth()->user()->hasRole('ptw'))
                            return $formb->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $formb->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $formb = $formb->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($formb)
                 ->editColumn('applied_at', function ($formb) {
                    return $formb->applied_at ? date('d/m/Y', strtotime($formb->applied_at)) : '';
                })
                ->editColumn('status.name', function ($formb) {
                    if($formb->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$formb->status->name.'</span>';
                    else if($formb->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$formb->status->name.'</span>';
                    else if($formb->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$formb->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$formb->status->name.'</span>';
                })
                ->editColumn('letter', function($formb) {
                    $result = "";
                    if($formb->filing_status_id == 9){
                        $result .= letterButton(1, get_class($formb), $formb->id);
                        $result .= letterButton(2, get_class($formb), $formb->id);
                        $result .= letterButton(3, get_class($formb), $formb->id);
                        $result .= letterButton(4, get_class($formb), $formb->id);
                    }
                    elseif($formb->filing_status_id == 8)
                        $result .= letterButton(5, get_class($formb), $formb->id);
                    return $result;
                })
                ->editColumn('action', function ($formb) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($formb)).'\','.$formb->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $formb->is_editable)) && $formb->filing_status_id < 7)
                        $button .= '<a href="'.route('formb', ['id' => $formb->id]).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';

                    if( ((auth()->user()->hasRole('ptw') && $formb->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $formb->distributions->count() == 3)) && $formb->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$formb->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';

                    if(auth()->user()->hasRole('pthq') && $formb->sector_id <> 3 && $formb->filing_status_id < 7)
                        $button .= '<a onclick="category('.$formb->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Kategori</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw', 'pphq','pw', 'pkpg', 'kpks']) && $formb->filing_status_id < 8)
                        $button .= '<a onclick="query('.$formb->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg']) && $formb->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$formb->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';

                    if(auth()->user()->hasRole('kpks') && $formb->filing_status_id < 8)
                        $button .= '<a onclick="process('.$formb->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 7;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang B";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }
        return view('registration.formb.list');
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function review(Request $request) {
        return view('registration.formb.review');
    }

    private function getErrors($formb) {

        $errors = [];

        if(!$formb) {
            $errors['b2'] = [null,null,null,null,null,null,null,null,null,null,null,null];
            $errors['b3'] = [null,null,null,null,null,null,null,null,null,null];
            $errors['b4'] = [null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null];
        }
        else {
            $validate_formb = Validator::make($formb->toArray(), [
                'has_branch' => 'required|integer',
                'union_type_id' => 'required|integer',
                'sector_id' => 'required|integer',
                'total_member' => 'required|integer',
                'resolved_at' => 'required',
                'meeting_type_id' => 'required|integer',
            ]);

            $errors_b2 = [];

            if ($validate_formb->fails())
                $errors_b2 = array_merge($errors_b2, $validate_formb->errors()->toArray());

            $validate_address = Validator::make($formb->address->toArray(), [
                'address1' => 'required|string',
                'postcode' => 'required|digits:5',
                'district_id' => 'required|integer',
                'state_id' => 'required|integer',
            ]);

            if ($validate_address->fails())
                $errors_b2 = array_merge($errors_b2, $validate_address->errors()->toArray());

            if($formb->requesters->count() < 7)
                $errors_b2 = array_merge($errors_b2, ['requesters' => ['Jumlah pemohon kurang dari 7 orang.']]);

            if($formb->tenure->officers->count() < 7)
                $errors_b2 = array_merge($errors_b2, ['officers' => ['Jumlah pegawai kurang dari 7 orang.']]);

            $errors['b2'] = $errors_b2;
            /////////////////////////////////////////////////////////////////////////////////////////////
            if($formb->has_branch == '1') {
                if(!$formb->b4) {
                    $errors['b4'] = [null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null];
                }
                else {

                    $validate_formb4 = Validator::make($formb->b4->toArray(), [
                        'membership_target' => 'required|string',
                        'paid_by' => 'required|string',
                        'entrance_fee' => 'required|numeric',
                        'monthly_fee' => 'required|numeric',
                        'workplace' => 'required|string',
                        'fixed_fee' => 'required|numeric',
                        'percentage_fee' => 'required|numeric',
                        'conference_yearly' => 'required|integer',
                        'rep_yearly' => 'required|integer',
                        'meeting_yearly' => 'required|integer',
                        'first_member' => 'required|integer',
                        'next_member' => 'required|integer',
                        'max_rep' => 'required|integer',
                        'max_savings' => 'required|numeric',
                        'max_expenses' => 'required|numeric',
                        'min_member' => 'required|integer',
                        'low_member' => 'required|integer',
                        'total_ajk' => 'required|integer',
                        'ajk_yearly' => 'required|integer',
                        'branch_max_savings' => 'required|numeric',
                        'branch_max_expenses' => 'required|numeric',
                    ]);

                    $errors_b4 = [];

                    if ($validate_formb4->fails())
                        $errors_b4 = array_merge($errors_b4, $validate_formb4->errors()->toArray());

                    $errors['b4'] = $errors_b4;
                }
            }
            else {
                if(!$formb->b3) {
                    $errors['b3'] = [null,null,null,null,null,null,null,null,null,null];
                }
                else {

                    $validate_formb3 = Validator::make($formb->b3->toArray(), [
                        'membership_target' => 'required|string',
                        'paid_by' => 'required|string',
                        'entrance_fee' => 'required|numeric',
                        'monthly_fee' => 'required|numeric',
                        'workplace' => 'required|string',
                        'meeting_yearly' => 'required|integer',
                        'total_ajk' => 'required|integer',
                        'ajk_yearly' => 'required|integer',
                        'max_savings' => 'required|numeric',
                        'max_expenses' => 'required|numeric',
                    ]);

                    $errors_b3 = [];

                    if ($validate_formb3->fails())
                        $errors_b3 = array_merge($errors_b3, $validate_formb3->errors()->toArray());

                    $errors['b3'] = $errors_b3;
                }
            }

        }

        return $errors;
    }

    private function generateConstitution($formb) {

        if($formb->b3 && $formb->has_branch != 1) {
            $constitutionTemplates = MasterConstitutionTemplate::where('constitution_type_id', 1)->get();
            $form = $formb->b3;
        }
        elseif ($formb->b4) {
            $constitutionTemplates = MasterConstitutionTemplate::where('constitution_type_id', 2)->get();
            $form = $formb->b4;
        }

        $constitution = $formb->union->constitutions()->create([
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
                        $template->content = str_replace($replace[$index], strtoupper($formb->tenure->entity->name), $template->content);

                    } else if($var == "address") {
                        $address = "";
                        $address .= $formb->address->address1
                                    .($formb->address->address2 ? ', '.$formb->address->address2 : '')
                                    .($formb->address->address3 ? ', '.$formb->address->address3 : '')
                                    .', '.$formb->address->postcode.' '
                                    .($formb->address->district ? $formb->address->district->name : '')
                                    .', '.($formb->address->state ? $formb->address->state->name : '');
                        $template->content = str_replace($replace[$index], $address, $template->content);

                    } else if(stripos($var, "yearly") !== false || stripos($var, "work") !== false ) {
                        if(stripos($var, "meeting") !== false) {
                            $obj = object_get($form, "meeting_yearly");
                        } else if(stripos($var, "ajk") !== false){
                            $obj = object_get($form, "ajk_yearly");
                        } else if(stripos($var, "conference") !== false) {
                            $obj = object_get($form, "conference_yearly");
                        } else if(stripos($var, "rep") !== false) {
                            $obj = object_get($form, "rep_yearly");
                        } else {
                            $obj = object_get($form, "workplace");
                        }

                        if($obj == 1) {
                            $template->content = str_replace($replace[$index]." ", "", $template->content);

                        } else if($obj == 2) {
                            $template->content = str_replace($replace[$index], checkCaps($var, "Dwi"), $template->content);

                        } else if($obj == 3) {
                            $template->content = str_replace($replace[$index], checkCaps($var, "Tiga"), $template->content);
                        } else {
                            $template->content = str_replace($replace[$index], checkCaps($var, $obj), $template->content);
                        }

                    } else if(strpos($var, "text") !== false) {
                        $var = str_replace("_text", "", $var);

                        if(strpos($var, "max") !== false)
                            $template->content = str_replace($replace[$index], decimalToRinggit(object_get($form, $var)), $template->content);
                        else
                            $template->content = str_replace($replace[$index], numberToWords(object_get($form, $var)), $template->content);
                    } else {
                        $template->content = str_replace($replace[$index], checkCaps($var, object_get($form, $var)), $template->content);
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
            $formb = auth()->user()->entity->formb;
        else
            $formb = FormB::findOrFail($request->id);

        if($formb->has_branch)
            $errors = count(($this->getErrors($formb))['b2']) + count(($this->getErrors($formb))['b4']);
        else
            $errors = count(($this->getErrors($formb))['b2']) + count(($this->getErrors($formb))['b3']);

        // return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 7;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang B - Hantar Permohonan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formb->applied_at = date('Y-m-d');
            $formb->filing_status_id = 2;
            $formb->is_editable = 0;
            $formb->save();

            $constitution = $this->generateConstitution($formb);

            $formb->logs()->updateOrCreate(
                [
                    'module_id' => 7,
                    'activity_type_id' => 11,
                    'filing_status_id' => $formb->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $formb->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 7,
            ]);

            Mail::to($formb->created_by->email)->send(new Sent($formb, 'Penghantaran Borang B'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($formb, $target) {

        $check = $formb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($formb->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormB')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $formb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formb->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($formb->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormB')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $formb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formb->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($formb, 'Serahan Borang B'));
        }
        else if($target == "pw") {
            if($formb->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $formb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formb->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($formb, 'Serahan Borang B'));
        }
        else if($target == "pthq") {
            if($formb->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormB')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $formb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formb->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($formb->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormB')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $formb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formb->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($formb, 'Serahan Borang B'));
        }
        else if($target == "pkpg") {
            if($formb->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',12)->first();

            $formb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formb->filing_status_id,
                    'assigned_to_user_id' => $pkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpg->user->email)->send(new Distributed($formb, 'Serahan Borang B'));
        }
        else if($target == "kpks") {
            if($formb->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $formb->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formb->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($formb, 'Serahan Borang B'));
        }
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function b2_index(Request $request) {

        $union_type = MasterUnionType::all();
        $sectors = MasterSector::all();
        $states = MasterState::all();
        $countries = MasterCountry::all();
        $designations = MasterDesignation::all();
        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();

        if(auth()->user()->hasRole('ks')) {
            $formb = auth()->user()->entity->formb;
        }
        else
            $formb = FormB::findOrFail($request->id);

        return view('registration.formb.b2.index', compact('formb','union_type','sectors','states','countries', 'designations','meeting_types'));
    }

    //Requester CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function requester_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang B - Butiran Pemohon";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        if(auth()->user()->hasRole('ks'))
            $formb = auth()->user()->entity->formb;
        else
            $formb = FormB::findOrFail($request->id);

        $requesters = $formb->requesters()->with(['address'])->get();

        while($requesters->count() < 7)
            $requesters->push(new Requester(['name' => '', 'identification_no ' => '', 'occupation' => '']));

        return datatables()->of($requesters)
            ->editColumn('address', function ($requester) {
                if($requester->address)
                    return $requester->address->address1.
                        ($requester->address->address2 ? ',<br>'.$requester->address->address2 : '').
                        ($requester->address->address3 ? ',<br>'.$requester->address->address3 : '').
                        ',<br>'.
                        $requester->address->postcode.' '.
                        ($requester->address->district ? $requester->address->district->name : '').', '.
                        ($requester->address->state ? $requester->address->state->name : '');
                else
                    return "";
            })
            ->editColumn('action', function ($requester) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="edit('.$requester->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                if($requester->id)
                    $button .= '<a onclick="remove('.$requester->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function requester_insert(Request $request) {
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
            $formb = auth()->user()->entity->formb;
        else
            $formb = FormB::findOrFail($request->id);

        $requester = $formb->requesters()->save(new Requester($request->all()));

        $count = $formb->requesters->count();

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang B - Butiran Pemohon";
        $log->data_new = json_encode($requester);
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
    public function requester_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang B - Butiran Pemohon";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $requester = Requester::findOrFail($request->id);
        $states = MasterState::all();

        return view('registration.formb.b2.tab2.edit', compact('requester', 'states'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function requester_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'identification_no' => 'required|string',
            'occupation' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $requester = Requester::findOrFail($request->id);
        $address = Address::findOrFail($requester->address_id)->update($request->all());

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang B - Butiran Pemohon";
        $log->data_old = json_encode($requester);

        $requester->update($request->all());

        $log->data_new = json_encode($requester);
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
    public function requester_delete(Request $request) {

        $requester = Requester::findOrFail($request->id);

        if(auth()->user()->hasRole('ks'))
            $formb = auth()->user()->entity->formb;
        else
            $formb = FormB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang B - Butiran Pemohon";
        $log->data_old = json_encode($requester);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $requester->delete();

        $count = $formb->requesters->count();


       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.', 'count' => $count]);
    }
    //Requester CRUD END

    //Officer CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function officer_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang B - Butiran Pegawai";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        if(auth()->user()->hasRole('ks'))
            $formb = auth()->user()->entity->formb;
        else
            $formb = FormB::findOrFail($request->id);

        $officers = $formb->tenure->officers()->with(['designation', 'address'])->get();

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
            'birth_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //dd(Carbon::createFromFormat('d/m/Y', '28/08/1994')->diffInYears(Carbon::now()));
        $address = Address::create($request->all());
        $request->request->add(['address_id' => $address->id]);
        $request->request->add(['held_at' => auth()->user()->entity->registered_at]);
        $request->request->add(['date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->birth_date)->toDateString()]);
        $request->request->add(['age' => Carbon::createFromFormat('d/m/Y', $request->birth_date)->diffInYears(Carbon::now())]);

        if(auth()->user()->hasRole('ks'))
            $formb = auth()->user()->entity->formb;
        else
            $formb = FormB::findOrFail($request->id);

        if($request->input('is_malaysian') == 1) {
            $malaysia = MasterCountry::findOrFail(1);
            $request->merge(['nationality_country_id' => $malaysia->id]);
        }

        $officer = $formb->tenure->officers()->save(new Officer($request->all()));

        $count = $formb->tenure->officers->count();

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang B - Butiran Pegawai";
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
        $log->module_id = 7;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang B - Butiran Pegawai";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $officer = Officer::findOrFail($request->id);
        $states = MasterState::all();
        $countries = MasterCountry::all();
        $designations = MasterDesignation::all();

        return view('registration.formb.b2.tab3.edit', compact('officer', 'states', 'countries', 'designations'));
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
            'birth_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $officer = Officer::findOrFail($request->id);
        $request->request->add(['date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->birth_date)->toDateString()]);
        $request->request->add(['age' => Carbon::createFromFormat('d/m/Y', $request->birth_date)->diffInYears(Carbon::now())]);

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang B - Butiran Pegawai";
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
            $formb = auth()->user()->entity->formb;
        else
            $formb = FormB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang B - Butiran Pegawai";
        $log->data_old = json_encode($officer);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $officer->delete();

        $count = $formb->tenure->officers->count();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.', 'count' => $count]);
    }
    //Officer CRUD END

    public function praecipe(Request $request) {
        
        if(auth()->user()->hasRole('ks')) {
            $formb = auth()->user()->entity->formb;
        }
        else
            $formb = FormB::findOrFail($request->id);

        $pdf = PDF::loadView('registration.formb.praecipe', compact('formb'));
        return $pdf->setPaper('A4')->setOrientation('portrait')->download('praecipe.pdf');
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $formb = FormB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang B - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formb.process.document-receive', $formb->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang B - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formb = FormB::findOrFail($request->id);

        $formb->filing_status_id = 3;
        $formb->save();

        $formb->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 7,
            ]
        );

        $formb->logs()->updateOrCreate(
            [
                'module_id' => 7,
                'activity_type_id' => 12,
                'filing_status_id' => $formb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($formb, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($formb, 'ppw');
            Mail::to($formb->created_by->email)->send(new Received(auth()->user(), $formb, 'Pengesahan Penerimaan Borang B'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($formb, 'pphq');
            Mail::to($formb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formb, 'Pengesahan Penerimaan Borang B'));
            Mail::to($formb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formb, 'Pengesahan Penerimaan Borang B'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $formb = FormB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang B - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formb.process.query.item', $formb->id);
        $route2 = route('formb.process.query', $formb->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $formb = FormB::findOrFail($request->id);

        if(count($formb->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang B - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formb->filing_status_id = 5;
        $formb->is_editable = 1;
        $formb->save();

        $log2 = $formb->logs()->updateOrCreate(
            [
                'module_id' => 7,
                'activity_type_id' => 13,
                'filing_status_id' => $formb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $formb->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formb, 'Kuiri Permohonan Borang B oleh PW'));
        } else if(auth()->user()->hasRole('pkpg')) {
            // Send to PPHQ
            $log = $formb->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formb, 'Kuiri Permohonan Borang B oleh PKPG'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to PKPG
            $log = $formb->logs()->where('role_id', 12)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formb, 'Kuiri Permohonan Borang B oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($formb->created_by->email)->send(new Queried(auth()->user(), $formb, 'Kuiri Permohonan Borang B'));
        }

        $formb->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 7;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang B - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formb = FormB::findOrFail($request->id);

            $queries = $formb->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $formb = FormB::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 7;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang B - Kuiri";
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
            $query = $formb->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 7;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang B - Kuiri";
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
        $log->module_id = 7;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang B - Kuiri";
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

        $formb = FormB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang B - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $formb->logs()->where('activity_type_id',14)->where('filing_status_id', $formb->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('formb.process.recommend', $formb->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang B - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formb = FormB::findOrFail($request->id);
        $formb->filing_status_id = 6;
        $formb->is_editable = 0;
        $formb->save();

        $formb->logs()->updateOrCreate(
            [
                'module_id' => 7,
                'activity_type_id' => 14,
                'filing_status_id' => $formb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($formb, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($formb, 'pkpg');
        else if(auth()->user()->hasRole('pkpg'))
            $this->distribute($formb, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($formb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $formb, 'Serahan Borang B ke Ibu Pejabat'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_category_edit(Request $request) {

        $formb = FormB::findOrFail($request->id);
        $sector_categories = MasterSectorCategory::where('sector_id', $formb->sector_id)->get();

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Borang B - Kategori Sektor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formb.process.category', $formb->id);
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
        $log->module_id = 7;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang B - Kategori Sektor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formb = FormB::findOrFail($request->id);

        $formb->update($request->all());

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $formb = FormB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang B - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formb.process.delay', $formb->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang B - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formb = FormB::findOrFail($request->id);
        $formb->filing_status_id = 7;
        $formb->is_editable = 0;
        $formb->save();

        $formb->logs()->updateOrCreate(
            [
                'module_id' => 7,
                'activity_type_id' => 15,
                'filing_status_id' => $formb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pkpg'); })->first()->assigned_to->email)->send(new Delayed($formb, 'Penangguhan Kelulusan Borang B'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result(Request $request) {

        $form = $formb = FormB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang B - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("formb.process.result.reject", $form->id);
        $route_approve = route("formb.process.result.approve", $form->id);
        $route_delay = route("formb.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $formb = FormB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang B - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formb.process.result.approve', $formb->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang B - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formb = FormB::findOrFail($request->id);
        $formb->filing_status_id = 9;
        $formb->is_editable = 0;
        $formb->save();

        $formb->logs()->updateOrCreate(
            [
                'module_id' => 7,
                'activity_type_id' => 16,
                'filing_status_id' => $formb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formb->created_by->email)->send(new Approved($formb, 'Status Borang B'));
        Mail::to($formb->created_by->email)->send(new ReminderMeeting($formb, 'Peringatan Mesyuarat Agung'));
        
        Mail::to($formb->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($formb, 'Sedia Dokumen Kelulusan Borang B'));

        // Set constitution status 1
        $formb->union->constitutions->first()->update(['filing_status_id' => 9]);
        // Set registration_no and province_office_id
        $formb->union->addresses()->create(['address_id' => $formb->address_id]);
        $formb->union->update([
            'registration_no' => uniqid(),
            'province_office_id' => $formb->address->state->province_office_id,
        ]);
        // Assign role to KS
        $formb->created_by->assignRole('union');


        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $formb = FormB::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang B - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formb.process.result.reject', $formb->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 7;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang B - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formb = FormB::findOrFail($request->id);
        $formb->filing_status_id = 8;
        $formb->is_editable = 0;
        $formb->save();

        $formb->logs()->updateOrCreate(
            [
                'module_id' => 7,
                'activity_type_id' => 16,
                'filing_status_id' => $formb->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formb->created_by->email)->send(new Rejected($formb, 'Status Borang B'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function b3_index(Request $request) {

        if(auth()->user()->hasRole('ks')) {
            $formb = auth()->user()->entity->formb;
        }
        else
            $formb = FormB::findOrFail($request->id);


        if($formb->b3) {
            $formb3 = $formb->b3;
        }
        else {
            $formb3 = auth()->user()->entity->formb->b3()->create([
                'created_by_user_id' => auth()->id(),
            ]);
        }

        return view('registration.formb.b3.index', compact('formb','formb3'));
    }

    public function b4_index(Request $request) {

        if(auth()->user()->hasRole('ks')) {
            $formb = auth()->user()->entity->formb;
        }
        else
            $formb = FormB::findOrFail($request->id);


        if($formb->b4) {
            $formb4 = $formb->b4;
        }
        else {
            $formb4 = auth()->user()->entity->formb->b4()->create([
                'created_by_user_id' => auth()->id(),
            ]);
        }

        return view('registration.formb.b4.index', compact('formb','formb4'));
    }

    public function download(Request $request) {

        $filing = FormB::findOrFail($request->id);                                                      // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->union->name),
            'entity_address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ', '.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars($filing->address->address3) : '').
                ', '.($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars($filing->address->district->name) : '').
                ($filing->address->state ? ', '.htmlspecialchars($filing->address->state->name) : ''),
            'established_day' => htmlspecialchars(strftime('%e' , strtotime($filing->union->registered_at))),
            'established_month_year' => htmlspecialchars(strftime('%B %Y' , strtotime($filing->union->registered_at))),
            'union_type' => $filing->union_type ? htmlspecialchars($filing->union_type->name) : '',
            'sector_type' => $filing->union->industry_type ? htmlspecialchars($filing->union->industry_type->name) : '',
            'sector' => $filing->sector ? htmlspecialchars($filing->sector->name) : '',
            'total_member' => htmlspecialchars($filing->total_member),
            'meeting_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'today_day' => htmlspecialchars(strftime('%e')),
            'today_month_year' =>  htmlspecialchars(strftime('%B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 7;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/formb/formb2.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate list
        $requesters = $filing->requesters;

        $document->cloneBlockString('list', count($requesters)-1);

        foreach($requesters as $index => $requester){
            $content = preg_replace('~\R~u', '<w:br/>', $requester->name);
            $document->setValue('requester_name_list', strtoupper($content), 1);
        }

        // Generate table requester
        $rows = $filing->requesters;
        $document->cloneRow('no', count($rows));

        foreach($rows as $index => $row) {
            if($index == 0)
                $document->setValue('signed_by#'.($index+1), 'Ditandatangani:');
            else
                $document->setValue('signed_by#'.($index+1), '');

            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('requester_name#'.($index+1), htmlspecialchars(strtoupper($row->name)));
            $document->setValue('requester_occupation#'.($index+1), htmlspecialchars(strtoupper($row->occupation)));
            $document->setValue('requester_address#'.($index+1), htmlspecialchars(strtoupper($row->address->address1)).
                ($row->address->address2 ? ', '.htmlspecialchars(strtoupper($row->address->address2)) : '').
                ($row->address->address3 ? ', '.htmlspecialchars(strtoupper($row->address->address3)) : '').
                ', '.($row->address->postcode).
                ($row->address->district ? ' '.htmlspecialchars(strtoupper($row->address->district->name)) : '').
                ($row->address->state ? ', '.htmlspecialchars(strtoupper($row->address->state->name)) : '')
            );
        }

        // Generate table officer
        $rows2 = $filing->tenure->officers;
        $document->cloneRow('officer_designation', count($rows2));

        foreach($rows2 as $index => $row2) {
            $document->setValue('officer_designation#'.($index+1), ($row2->designation ? htmlspecialchars(strtoupper($row2->designation->name)) : ''));
            $document->setValue('officer_name#'.($index+1), htmlspecialchars(strtoupper($row2->name)));
            $document->setValue('officer_identification_no#'.($index+1), htmlspecialchars(strtoupper($row2->identification_no)));
            $document->setValue('officer_age#'.($index+1), htmlspecialchars(strtoupper($row2->age)));
            $document->setValue('officer_address#'.($index+1), htmlspecialchars(strtoupper($row2->address->address1)).
                ($row2->address->address2 ? ', '.htmlspecialchars(strtoupper($row2->address->address2)) : '').
                ($row2->address->address3 ? ', '.htmlspecialchars(strtoupper($row2->address->address3)) : '').
                ', '.($row2->address->postcode).
                ($row2->address->district ? ' '.htmlspecialchars(strtoupper($row2->address->district->name)) : '').
                ($row2->address->state ? ', '.htmlspecialchars(strtoupper($row2->address->state->name)) : '')
            );
            $document->setValue('officer_occupation#'.($index+1), htmlspecialchars(strtoupper($row2->occupation)));
            $document->setValue('officer_previous_designation#'.($index+1), ($row2->previous_designation ? htmlspecialchars(strtoupper($row2->previous_designation->name)) : ''));
            $document->setValue('officer_conviction#'.($index+1), htmlspecialchars(strtoupper($row2->conviction)));
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang B2';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function b3_download(Request $request) {

        $filing = FormB::findOrFail($request->id);                                                    // Change here

        $meeting_yearly = '';
        if($filing->b3->meeting_yearly == 1)
            $meeting_yearly = 'Satu';
        elseif($filing->b3->meeting_yearly == 2)
            $meeting_yearly = 'Dwi';
        elseif($filing->b3->meeting_yearly == 3)
            $meeting_yearly = 'Tiga';

        $data = [
            'entity_name_uppercase' => htmlspecialchars(strtoupper($filing->union->name)),
            'entity_name' => htmlspecialchars($filing->union->name),
            'entity_address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ', '.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars($filing->address->address3) : '').
                ', '.($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars($filing->address->district->name) : '').
                ($filing->address->state ? ', '.htmlspecialchars($filing->address->state->name) : ''),
            'registration_no' => htmlspecialchars($filing->union->registration_no),
            'membership_target' => htmlspecialchars($filing->b3->membership_target),
            'paid_by' => htmlspecialchars($filing->b3->paid_by),
            'entrance_fee' => htmlspecialchars($filing->b3->entrance_fee),
            'monthly_fee' => htmlspecialchars($filing->b3->monthly_fee),
            'workplace' => htmlspecialchars($filing->b3->workplace),
            'meeting_yearly' => htmlspecialchars($meeting_yearly),
            'meeting_yearly_uppercase' => htmlspecialchars(strtoupper($meeting_yearly)),
            'total_ajk' => htmlspecialchars($filing->b3->total_ajk),
            'total_ajk_word' => htmlspecialchars(numberToWords($filing->b3->total_ajk)),
            'ajk_yearly' => htmlspecialchars($filing->b3->ajk_yearly),
            'max_savings' => htmlspecialchars($filing->b3->max_savings),
            'max_expenses' => htmlspecialchars($filing->b3->max_expenses),
            'max_savings_word' => htmlspecialchars(ucwords(decimalToRinggit($filing->b3->max_savings))),
            'max_expenses_word' => htmlspecialchars(ucwords(decimalToRinggit($filing->b3->max_expenses))),
        ];

        $log = new LogSystem;
        $log->module_id = 7;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/formb/formb3.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang B3';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function b4_download(Request $request) {

        $filing = FormB::findOrFail($request->id);                                                    // Change here

        $conference_yearly = '';
        if($filing->b4->conference_yearly == 1)
            $conference_yearly = 'Satu';
        elseif($filing->b4->conference_yearly == 2)
            $conference_yearly = 'Dwi';
        elseif($filing->b4->conference_yearly == 3)
            $conference_yearly = 'Tiga';

        $meeting_yearly = '';
        if($filing->b4->meeting_yearly == 1)
            $meeting_yearly = 'Satu';
        elseif($filing->b4->meeting_yearly == 2)
            $meeting_yearly = 'Dwi';
        elseif($filing->b4->meeting_yearly == 3)
            $meeting_yearly = 'Tiga';

        $data = [
            'entity_name_uppercase' => htmlspecialchars(strtoupper($filing->union->name)),
            'entity_name' => htmlspecialchars($filing->union->name),
            'entity_address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ', '.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars($filing->address->address3) : '').
                ', '.($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars($filing->address->district->name) : '').
                ($filing->address->state ? ', '.htmlspecialchars($filing->address->state->name) : ''),
            'registration_no' => htmlspecialchars($filing->union->registration_no),
            'membership_target' => htmlspecialchars($filing->b4->membership_target),
            'paid_by' => htmlspecialchars($filing->b4->paid_by),
            'entrance_fee' => htmlspecialchars($filing->b4->entrance_fee),
            'monthly_fee' => htmlspecialchars($filing->b4->monthly_fee),
            'fixed_fee' => htmlspecialchars($filing->b4->fixed_fee),
            'percentage_fee' => htmlspecialchars($filing->b4->percentage_fee),
            'workplace' => htmlspecialchars($filing->b4->workplace),
            'conference_yearly' => htmlspecialchars($conference_yearly),
            'conference_yearly_uppercase' => htmlspecialchars(strtoupper($conference_yearly)),
            'rep_yearly' => htmlspecialchars($filing->b4->rep_yearly),
            'meeting_yearly' => htmlspecialchars($meeting_yearly),
            'meeting_yearly_uppercase' => htmlspecialchars(strtoupper($meeting_yearly)),
            'first_member' => htmlspecialchars($filing->b4->first_member),
            'next_member' => htmlspecialchars($filing->b4->next_member),
            'max_rep' => htmlspecialchars($filing->b4->max_rep),
            'max_savings' => htmlspecialchars($filing->b4->max_savings),
            'max_expenses' => htmlspecialchars($filing->b4->max_expenses),
            'max_savings_word' => htmlspecialchars(ucwords(decimalToRinggit($filing->b4->max_savings))),
            'max_expenses_word' => htmlspecialchars(ucwords(decimalToRinggit($filing->b4->max_expenses))),
            'min_member' => htmlspecialchars($filing->b4->min_member),
            'low_member' => htmlspecialchars($filing->b4->low_member),
            'total_ajk' => htmlspecialchars($filing->b4->total_ajk),
            'ajk_yearly' => htmlspecialchars($filing->b4->ajk_yearly),
            'branch_max_savings' => htmlspecialchars($filing->b4->branch_max_savings),
            'branch_max_expenses' => htmlspecialchars($filing->b4->branch_max_expenses),
        ];

        $log = new LogSystem;
        $log->module_id = 7;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/formb/formb4.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang B4';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

}
