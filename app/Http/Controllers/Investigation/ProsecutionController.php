<?php

namespace App\Http\Controllers\Investigation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\OtherModel\Attachment;
use App\FilingModel\Prosecution;
use App\FilingModel\ProsecutionPDW01;
use App\FilingModel\ProsecutionPDW02;
use App\FilingModel\ProsecutionPDW13;
use App\FilingModel\ProsecutionPDW13Accused;
use App\FilingModel\ProsecutionPDW14;
use App\MasterModel\MasterProvinceOffice;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\Prosecution\ResultUpdated;
use App\Mail\Prosecution\ApprovedPUU;
use App\Mail\Prosecution\RejectedPUU;
use App\Mail\Prosecution\AppointedIO;
use App\Mail\Prosecution\AppointedPO;
use App\Mail\Prosecution\Sent;
use App\FilingModel\Query;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;

class ProsecutionController extends Controller
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

        $prosecution = Prosecution::findOrFail($request->id);

        $error_list = $this->getErrors($prosecution);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan Kertas Siasatan - Pendakwaan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('investigation.prosecution.index', compact('prosecution', 'pdw02', 'pdw13', 'pdw14', 'error_list'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 30;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Kertas Siasatan";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $prosecutions = Prosecution::with(['status']);

            if(!auth()->user()->hasRole('pkpp'))
                $prosecutions = $prosecutions->where('filing_status_id', '>', 1);

            if(auth()->user()->hasRole('ptw')) {
                $prosecutions = $prosecutions->where(function($prosecutions) {
                    return $prosecutions->doesntHave('distributions')->whereHas('pdw01', function($pdw01) {
                        return $pdw01->where('province_office_id', auth()->user()->entity->province_office_id);
                    });
                })->orWhere(function($prosecutions) {
                    return $prosecutions->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    });
                });
            }
            else if(auth()->user()->hasRole('pthq')) {
                $prosecutions = $prosecutions->where(function($prosecutions) {
                    return $prosecutions->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhereHas('logs', function($logs) {
                        return $logs->where('role_id', 8)->where('activity_type_id', 14);
                    });
                });
            }
            else {
                $prosecutions = $prosecutions->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                })
                ->orWhere('created_by_user_id', auth()->id())
                ->orWhereHas('pdw02', function($pdw02) {
                    return $pdw02->where('io_user_id', auth()->id());
                })
                ->orWhereHas('pdw14', function($pdw14) {
                    return $pdw14->where('po_user_id', auth()->id());
                });
            }

            return datatables()->of($prosecutions)
                ->editColumn('pdw01.subject', function ($prosecution) {
                    return $prosecution->pdw01->subject;
                })
                ->editColumn('applied_at', function ($prosecution) {
                    return $prosecution->applied_at ? date('d/m/Y', strtotime($prosecution->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($prosecution) {
                    if($prosecution->filing_status_id == 9 || $prosecution->filing_status_id == 10)
                        return '<span class="badge badge-success">'.$prosecution->status->name.'</span>';
                    else if($prosecution->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$prosecution->status->name.'</span>';
                    else if($prosecution->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$prosecution->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$prosecution->status->name.'</span>';
                })
                ->editColumn('letter', function($prosecution) {
                    $result = "";
                    if($prosecution->filing_status_id > 7  )
                        $result .= letterButton(55, get_class($prosecution), $prosecution->id);
                    return $result;
                    // return '<a href="{{ url('files/investigation/pdw/12.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Surat Syor Pendakwaan</a><br> ';
                })
                ->editColumn('action', function ($prosecution) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($prosecution)).'\','.$prosecution->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['pkpp']) && $prosecution->pdw01->is_editable && $prosecution->filing_status_id < 7)
                        $button .= '<a href="'.route('prosecution.pdw01.form', $prosecution->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ptw', 'ppw', 'pw', 'pthq']) && $prosecution->is_editable && $prosecution->filing_status_id < 12)
                        $button .= '<a href="'.route('prosecution.form', $prosecution->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini</a><br>';
                    
                    if( (auth()->user()->hasRole('pthq') && $prosecution->distributions->count() == 3) && $prosecution->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$prosecution->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['pw', 'pphq','pkpp', 'kpks']) && $prosecution->filing_status_id < 8)
                        $button .= '<a onclick="query('.$prosecution->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw','pphq','pkpp']) && $prosecution->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$prosecution->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $prosecution->filing_status_id < 8)
                        $button .= '<a onclick="result('.$prosecution->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    if(auth()->user()->hasRole('pkpp') && $prosecution->filing_status_id == 12)
                        $button .= '<a onclick="result_puu('.$prosecution->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Keputusan PUU</a><br>';
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 30;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Kertas Siasatan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('investigation.prosecution.list');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdw01_index(Request $request) {

        $prosecution = Prosecution::create([
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $pdw01 = $prosecution->pdw01()->create([
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $provinces = MasterProvinceOffice::all();

        return view('investigation.prosecution.pdw01', compact('prosecution', 'pdw01', 'provinces'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdw01_edit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);
        $pdw01 = $prosecution->pdw01;

        $provinces = MasterProvinceOffice::all();

        return view('investigation.prosecution.pdw01', compact('prosecution', 'pdw01', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function pdw01_update(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $validator = Validator::make($prosecution->pdw01->toArray(), [
            'subject' => 'required|string',
            'province_office_id' => 'required|integer',
            'fault' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Kertas Siasatan - PDW01";
        $log->data_old = json_encode($prosecution->pdw01);

        $request->request->add(['is_editable' => 0]);
        $prosecution->pdw01()->update($request->all());

        $setting = \App\OtherModel\Setting::firstOrCreate(
            [ 'meta_key' => 'refno_PDW_'.date('Y') ],
            [ 'meta_value' => 1 ]
        );

        $prosecution->pdw01->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
                'module_id' => 30,
            ],
            [
                'reference_no' => 'PDW/'.date('Y').'/'.(auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? sprintf("%02d", auth()->user()->entity->province_office->address->state_id) : 'HQ').'/'.$setting->meta_value,
            ]
        );

        $log->data_new = json_encode($prosecution->pdw01);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $prosecution->filing_status_id = 3;
        $prosecution->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdw02_index(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $pdw02 = $prosecution->pdw02()->firstOrCreate([
            'prosecution_id' => $prosecution->id,
        ],[
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $provinces = MasterProvinceOffice::all();
        $investigators = User::where('user_status_id', 1)
                             ->where('user_type_id', 2)
                             ->whereHas('entity_staff', function ($entity) {
                                 return $entity->whereIn('role_id', [7,8])
                                                ->where('province_office_id', auth()->user()->entity->province_office_id);
                             })->get();

        return view('investigation.prosecution.pdw02', compact('prosecution', 'pdw02', 'provinces', 'investigators'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function pdw02_submit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $validator = Validator::make($prosecution->pdw02->toArray(), [
            'io_user_id' => 'required|integer',
            'applied_at' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Kertas Siasatan - PDW02";
        $log->data_old = json_encode($prosecution->pdw02);

        $prosecution->pdw02()->update($request->all());

        $setting = \App\OtherModel\Setting::firstOrCreate(
            [ 'meta_key' => 'refno_PDW_'.date('Y') ],
            [ 'meta_value' => 1 ]
        );

        $prosecution->pdw02->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
                'module_id' => 30,
            ],
            [
                'reference_no' => 'PDW/'.date('Y').'/'.(auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? sprintf("%02d", auth()->user()->entity->province_office->address->state_id) : 'HQ').'/'.$setting->meta_value,
            ]
        );

        $log->data_new = json_encode($prosecution->pdw02);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah disimpan.']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdw13_index(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $pdw13 = $prosecution->pdw13()->firstOrCreate([
            'prosecution_id' => $prosecution->id,
        ],[
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        return view('investigation.prosecution.pdw13.pdw13', compact('prosecution', 'pdw13'));
    }



    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function pdw13_submit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $validator = Validator::make($prosecution->pdw13->toArray(), [
            'facts' => 'required|string',
            'applied_at' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Kertas Siasatan - PDW13";
        $log->data_old = json_encode($prosecution->pdw13);

        $prosecution->pdw13()->update($request->all());

        $setting = \App\OtherModel\Setting::firstOrCreate(
            [ 'meta_key' => 'refno_PDW_'.date('Y') ],
            [ 'meta_value' => 1 ]
        );

        $prosecution->pdw13->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
                'module_id' => 30,
            ],
            [
                'reference_no' => 'PDW/'.date('Y').'/'.(auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? sprintf("%13d", auth()->user()->entity->province_office->address->state_id) : 'HQ').'/'.$setting->meta_value,
            ]
        );

        $log->data_new = json_encode($prosecution->pdw13);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah disimpan.']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdw14_index(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $pdw14 = $prosecution->pdw14()->firstOrCreate([
            'prosecution_id' => $prosecution->id,
        ],[
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        $provinces = MasterProvinceOffice::all();
        $prosecutors = User::where('user_status_id', 1)
                             ->where('user_type_id', 2)
                             ->whereHas('entity_staff', function ($entity) {
                                 return $entity->whereIn('role_id', [7,8])
                                                ->where('province_office_id', auth()->user()->entity->province_office_id);
                             })->get();

        return view('investigation.prosecution.pdw14', compact('prosecution', 'pdw14', 'provinces', 'prosecutors'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function pdw14_submit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $validator = Validator::make($prosecution->pdw14->toArray(), [
            'po_user_id' => 'required|integer',
            'applied_at' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Kertas Siasatan - PDW14";
        $log->data_old = json_encode($prosecution->pdw14);

        $prosecution->pdw14()->update($request->all());

        $setting = \App\OtherModel\Setting::firstOrCreate(
            [ 'meta_key' => 'refno_PDW_'.date('Y') ],
            [ 'meta_value' => 1 ]
        );

        $prosecution->pdw14->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
                'module_id' => 30,
            ],
            [
                'reference_no' => 'PDW/'.date('Y').'/'.(auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? sprintf("%14d", auth()->user()->entity->province_office->address->state_id) : 'HQ').'/'.$setting->meta_value,
            ]
        );

        $log->data_new = json_encode($prosecution->pdw14);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah disimpan.']);
    }

    // Accused CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function accused_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Kertas Siasatan - Butiran Tertuduh";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $prosecution = Prosecution::findOrFail($request->id);
        $accuseds = $prosecution->pdw13->accused;

        return datatables()->of($accuseds)
            ->editColumn('action', function ($accused) {
                $button = "";

                $button .= '<a onclick="editAccused('.$accused->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                $button .= '<a onclick="removeAccused('.$accused->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function accused_insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'accused' => 'required|string',
            'identification_no' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $prosecution = Prosecution::findOrFail($request->id);
        $pdw13 = $prosecution->pdw13;
        $accused = $pdw13->accused()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 4;
        $log->description = "Tambah Kertas Siasatan - Butiran Tertuduh";
        $log->data_new = json_encode($accused);
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
    public function accused_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Kertas Siasatan - Butiran Tertuduh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $accused = ProsecutionPDW13Accused::findOrFail($request->accused_id);
        $prosecution = Prosecution::findOrFail($request->id);
        $pdw13 = $prosecution->pdw13;

        return view('investigation.prosecution.pdw13.accused.edit', compact('accused', 'prosecution', 'pdw13'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function accused_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'accused' => 'required|string',
            'identification_no' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $accused = ProsecutionPDW13Accused::findOrFail($request->accused_id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Kertas Siasatan - Butiran Tertuduh";
        $log->data_old = json_encode($accused);

        $accused->update($request->all());

        $log->data_new = json_encode($accused);
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
    public function accused_delete(Request $request) {

        $accused = ProsecutionPDW13Accused::findOrFail($request->accused_id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 6;
        $log->description = "Padam Kertas Siasatan - Butiran Tertuduh";
        $log->data_old = json_encode($accused);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $accused->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    // Accused CRUD END

    private function getErrors($prosecution) {

        $errors = [];

        $errors_prosecution = [];

        $validate_prosecution = Validator::make($prosecution->toArray(), [
            'subpoena_approved_at' => 'required',
            'io_notes' => 'required',
            'po_notes' => 'required',
        ]);

        if ($validate_prosecution->fails())
            $errors_prosecution = array_merge($errors_prosecution, $validate_prosecution->errors()->toArray());

        $errors['prosecution'] = $errors_prosecution;

        /////////////////////////////////////////////////////////////////////////////////////////

        if(!$prosecution->pdw02) {
            $errors['pdw02'] = [null,null];
        }
        else {
            $errors_pdw02 = [];

            $validate_pdw02 = Validator::make($prosecution->pdw02->toArray(), [
                'io_user_id' => 'required',
                'applied_at' => 'required',
            ]);

            if ($validate_pdw02->fails())
                $errors_pdw02 = array_merge($errors_pdw02, $validate_pdw02->errors()->toArray());

            $errors['pdw02'] = $errors_pdw02;
        }

        /////////////////////////////////////////////////////////////////////////////////////////

        if(!$prosecution->pdw13) {
            $errors['pdw13'] = [null,null,null,null,null];
        }
        else {
            $errors_pdw13 = [];

            $validate_pdw13 = Validator::make($prosecution->pdw13->toArray(), [
                'facts' => 'required|string',
                'applied_at' => 'required',
            ]);

            if ($validate_pdw13->fails())
                $errors_pdw13 = array_merge($errors_pdw13, $validate_pdw13->errors()->toArray());

            if($prosecution->pdw13->accused->count() < 1)
                $errors_pdw13 = array_merge($errors_pdw13, ['accused' => ['Sila isi maklumat tertuduh.']]);

            $errors['pdw13'] = $errors_pdw13;
        }

        /////////////////////////////////////////////////////////////////////////////////////////

        if(!$prosecution->pdw14) {
            $errors['pdw14'] = [null,null];
        }
        else {
            $errors_pdw14 = [];

            $validate_pdw14 = Validator::make($prosecution->pdw14->toArray(), [
                'po_user_id' => 'required',
                'applied_at' => 'required',
            ]);

            if ($validate_pdw14->fails())
                $errors_pdw14 = array_merge($errors_pdw14, $validate_pdw14->errors()->toArray());

            $errors['pdw14'] = $errors_pdw14;
        }

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $error_list = $this->getErrors($prosecution);
        $errors = count($error_list['prosecution']) + count($error_list['pdw02']) + count($error_list['pdw13']) + count($error_list['pdw14']);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 30;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Kertas Siasatan - Hantar Pemfailan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $prosecution->logs()->updateOrCreate(
                [
                    'module_id' => 30,
                    'activity_type_id' => 11,
                    'filing_status_id' => $prosecution->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $prosecution->filing_status_id = 3;
            $prosecution->is_editable = 0;
            $prosecution->save();

            $prosecution->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 30,
            ]);

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Pemfailan anda telah dihantar.']);
        }
    }

    /**
     * Show the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function pdw01_attachment_index(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Kertas Siasatan - Dokumen Sokongan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attachments = [];

        foreach($prosecution->pdw01->attachments as $attachment) {
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
    public function pdw01_attachment_insert(Request $request) {
        if($request->file('file')->isValid()) {
            $path = Storage::disk('uploads')->putFileAs(
                'prosecution_pdw01',
                $request->file('file'),
                uniqid().'_'.$request->file('file')->getClientOriginalName()
            );

            $prosecution = Prosecution::findOrFail($request->id);

            $attachment = $prosecution->pdw01->attachments()->create([
                'name' => $request->file('file')->getClientOriginalName(),
                'url' => $path,
                'created_by_user_id' => auth()->id()
            ]);

            $log = new LogSystem;
            $log->module_id = 30;
            $log->activity_type_id = 4;
            $log->description = "Tambah Kertas Siasatan - Dokumen Sokongan";
            $log->data_old = json_encode($request->input());
            $log->data_new = json_encode($attachment);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            // Should be distribute after print, not after upload
            $this->distribute($prosecution, auth()->user()->entity->role->name);
            $this->distribute($prosecution, 'pw');

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah disimpan.', 'id' => $attachment->id]);
        }
    }

    /**
     * Delete resources from storage
     *
     * @return \Illuminate\Http\Response
     */
    public function pdw01_attachment_delete(Request $request) {
        $attachment = Attachment::findOrFail($request->attachment_id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 6;
        $log->description = "Padam Kertas Siasatan - Dokumen Sokongan";
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

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($prosecution, $target) {

        $check = $prosecution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($prosecution->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\Prosecution')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $prosecution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $prosecution->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($prosecution->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Prosecution')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $prosecution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $prosecution->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($prosecution, 'Serahan Kertas Siasatan (Pendakwaan)'));
        }
        else if($target == "pw") {
            if($prosecution->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $prosecution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $prosecution->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($prosecution, 'Serahan Kertas Siasatan (Pendakwaan)'));
        }
        else if($target == "pthq") {
            if($prosecution->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\Prosecution')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $prosecution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $prosecution->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($prosecution->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Prosecution')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $prosecution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $prosecution->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($prosecution, 'Serahan Kertas Siasatan (Pendakwaan)'));
        }
        else if($target == "pkpp") {
            if($prosecution->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $prosecution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $prosecution->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($prosecution, 'Serahan Kertas Siasatan (Pendakwaan)'));
        }
        else if($target == "kpks") {
            if($prosecution->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $prosecution->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $prosecution->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($prosecution, 'Serahan Kertas Siasatan (Pendakwaan)'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 16;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kertas Siasatan (Pendakwaan) - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('prosecution.process.document-receive', $prosecution->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kertas Siasatan (Pendakwaan) - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $prosecution = Prosecution::findOrFail($request->id);

        $prosecution->filing_status_id = 3;
        $prosecution->save();

        $prosecution->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 30,
            ]
        );

        $prosecution->logs()->updateOrCreate(
            [
                'module_id' => 30,
                'activity_type_id' => 12,
                'filing_status_id' => $prosecution->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($prosecution, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($prosecution, 'ppw');
            Mail::to($prosecution->created_by->email)->send(new Received(auth()->user(), $prosecution, 'Pengesahan Penerimaan Kertas Siasatan (Pendakwaan)'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($prosecution, 'pphq');
            Mail::to($prosecution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $prosecution, 'Pengesahan Penerimaan Kertas Siasatan (Pendakwaan)'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kertas Siasatan (Pendakwaan) - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('prosecution.process.query.item', $prosecution->id);
        $route2 = route('prosecution.process.query', $prosecution->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        if(count($prosecution->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kertas Siasatan (Pendakwaan) - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $prosecution->filing_status_id = 5;
        $prosecution->is_editable = 1;
        $prosecution->save();

        $log2 = $prosecution->logs()->updateOrCreate(
            [
                'module_id' => 30,
                'activity_type_id' => 13,
                'filing_status_id' => $prosecution->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $prosecution->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $prosecution, 'Kuiri Kertas Siasatan (Pendakwaan) oleh KPKS'));
        }
        else {
            // Send to IO
            Mail::to($prosecution->pdw02->io->email)->send(new Queried(auth()->user(), $prosecution, 'Kuiri Kertas Siasatan (Pendakwaan)'));
        }

        $prosecution->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 30;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Kertas Siasatan (Pendakwaan) - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $prosecution = Prosecution::findOrFail($request->id);

            $queries = $prosecution->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $prosecution = Prosecution::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 30;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Kertas Siasatan (Pendakwaan) - Kuiri";
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
            $query = $prosecution->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 30;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Kertas Siasatan (Pendakwaan) - Kuiri";
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
        $log->module_id = 30;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Kertas Siasatan (Pendakwaan) - Kuiri";
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

        $prosecution = Prosecution::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kertas Siasatan (Pendakwaan) - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $prosecution->logs()->where('activity_type_id',14)->where('filing_status_id', $prosecution->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('prosecution.process.recommend', $prosecution->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kertas Siasatan (Pendakwaan) - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $prosecution = Prosecution::findOrFail($request->id);
        $prosecution->filing_status_id = 6;
        $prosecution->is_editable = 0;
        $prosecution->save();

        $prosecution->logs()->updateOrCreate(
            [
                'module_id' => 30,
                'activity_type_id' => 14,
                'filing_status_id' => $prosecution->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($prosecution, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($prosecution, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($prosecution, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($prosecution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $prosecution, 'Serahan Kertas Siasatan (Pendakwaan)'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_status_edit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Kertas Siasatan - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('prosecution.process.status', $prosecution->id);

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
        $log->description = "Kemaskini Kertas Siasatan - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $prosecution = Prosecution::findOrFail($request->id);
        $prosecution->is_editable = 0;
        $prosecution->save();

        $log = $prosecution->logs()->create([
                'module_id' => 30,
                'activity_type_id' => 20,
                'filing_status_id' => $prosecution->filing_status_id,
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
    public function process_result_edit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Kertas Siasatan (Pendakwaan) - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('prosecution.process.result', $prosecution->id);

        return view('general.modal.result-prosecution', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Kertas Siasatan (Pendakwaan) - Keputusan";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $prosecution = Prosecution::findOrFail($request->id);
        $prosecution->filing_status_id = 12;
        $prosecution->is_editable = 0;
        $prosecution->save();

        $log = $prosecution->logs()->create([
            'module_id' => 30,
            'activity_type_id' => 16,
            'filing_status_id' => $prosecution->filing_status_id,
            'created_by_user_id' => auth()->id(),
            'role_id' => auth()->user()->entity->role_id,
        ]);

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result(Request $request) {

        $form = $prosecution = Prosecution::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kertas Siasatan - Keputusan PUU";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("prosecution.process.result.reject", $form->id);
        $route_approve = route("prosecution.process.result.approve", $form->id);

        return view('general.modal.result-puu', compact('route_reject','route_approve'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kertas Siasatan - Diperakukan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('prosecution.process.result.approve', $prosecution->id);

        return view('general.modal.acknowledge', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kertas Siasatan - Diperakukan";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $prosecution = Prosecution::findOrFail($request->id);
        $prosecution->filing_status_id = 9;
        $prosecution->is_editable = 0;
        $prosecution->save();

        $prosecution->logs()->updateOrCreate(
            [
                'module_id' => 30,
                'activity_type_id' => 16,
                'filing_status_id' => $prosecution->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($prosecution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovePUU($prosecution, 'Kertas Siasatan Diperakukan Oleh PUU'));
        Mail::to($prosecution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovePUU($prosecution, 'Kertas Siasatan Diperakukan Oleh PUU'));
        Mail::to($prosecution->pdw02->io->email)->send(new ApprovePUU($prosecution, 'Kertas Siasatan Diperakukan Oleh PUU'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Kertas siasatan ini telah diperakukan oleh PUU.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $prosecution = Prosecution::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kertas Siasatan - Tidak Diperakukan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('prosecution.process.result.reject', $prosecution->id);

        return view('general.modal.not-acknowledge', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kertas Siasatan - Tidak Diperakukan";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $prosecution = Prosecution::findOrFail($request->id);
        $prosecution->filing_status_id = 8;
        $prosecution->is_editable = 1;
        $prosecution->save();

        $prosecution->logs()->updateOrCreate(
            [
                'module_id' => 30,
                'activity_type_id' => 16,
                'filing_status_id' => $prosecution->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($prosecution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new RejectPUU($prosecution, 'Kertas Siasatan Tidak Diperakukan Oleh PUU'));
        Mail::to($prosecution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new RejectPUU($prosecution, 'Kertas Siasatan Tidak Diperakukan Oleh PUU'));
        Mail::to($prosecution->pdw02->io->email)->send(new RejectPUU($prosecution, 'Kertas Siasatan Tidak Diperakukan Oleh PUU'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Kertas siasatan ini tidak diperakukan. Kes ditutup.']);
    }

    public function download(Request $request) {

        $filing = Prosecution::findOrFail($request->id);  
                                         // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                               
            'reference_no' => $filing->pdw01->references ? htmlspecialchars($filing->pdw01->references->first()->reference_no) : '',        
            'letter_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->pdw01->created_at))),                                              
            'to_investigate_uppercase' => htmlspecialchars(strtoupper($filing->pdw01->subject)),
            'province_office_name_uppercase' => htmlspecialchars(strtoupper($filing->pdw01->province_office->name)),
            'report_reference_no' => htmlspecialchars($filing->pdw01->report_reference_no),
            'report_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->pdw01->report_date))),
            'fault' => htmlspecialchars($filing->pdw01->fault),
            'tagline' => htmlspecialchars(strtoupper('BERKHIDMAT UNTUK NEGARA')),
            'slogan' => htmlspecialchars('Pekerja Kreative Pencetus Inovatif'),
            'pkpp_name' => htmlspecialchars(strtoupper($filing->pdw01->created_by->name)),
        ];

        $log = new LogSystem;
        $log->module_id = 30;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/investigation/pdw01.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }
        
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Memo Arahan';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function pdw02_download(Request $request) {

        $filing = Prosecution::findOrFail($request->id);  
                                         // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                       
            'reference_no' => $filing->pdw02->references ? htmlspecialchars($filing->pdw02->references->first()->reference_no) : '',        
            'letter_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->pdw01->created_at))),                  
            'to_investigate_uppercase' => htmlspecialchars(strtoupper($filing->pdw01->subject)),                                    
            'case_no' => htmlspecialchars(strtoupper($filing->references->first()->reference_no)),
            'hq_reference_no' => htmlspecialchars(strtoupper($filing->pdw01->references->first()->reference_no)),
            'hq_reference_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->pdw01->references->first()->created_at))),
            'accept_date' => htmlspecialchars($filing->pdw01->logs()->where('activity_type_id', 12)->first()->data),
            'io_name' => htmlspecialchars(strtoupper($filing->pdw02->io->name)),
            'province_office_name' => htmlspecialchars(strtoupper($filing->pdw01->province_office->name)),
            'pw_name' => htmlspecialchars(strtoupper($filing->pdw02->created_by->name)),
            'tagline' => htmlspecialchars(strtoupper('BERKHIDMAT UNTUK NEGARA')),
            'slogan' => htmlspecialchars('Pekerja Kreative Pencetus Inovatif'),
        ];

        $log = new LogSystem;
        $log->module_id = 30;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/investigation/pdw02.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }
        
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Pelantikan IO';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function pdw13_download(Request $request) {

        $filing = Prosecution::findOrFail($request->id);  
                                         // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                       
                             
            'facts' => htmlspecialchars(strtoupper($filing->pdw13->facts)),  
        ];

        $log = new LogSystem;
        $log->module_id = 30;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/investigation/pdw13.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate list
        $respondents = $filing->pdw13->accused;

        $document->cloneBlockString('list');

        foreach($respondents as $index => $respondent){
            $document->setValue('respondent_name', strtoupper($respondent->accused), 1);
            $document->setValue('identification_no', strtoupper($respondent->identification_no), 1);
        }
                
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Fakta Kes';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function pdw14_download(Request $request) {

        $filing = Prosecution::findOrFail($request->id);  
                                         // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                       
            'reference_no' => $filing->pdw14->references ? htmlspecialchars($filing->pdw14->references->first()->reference_no) : '',        
            'letter_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->pdw01->created_at))),                  
            'to_investigate_uppercase' => htmlspecialchars(strtoupper($filing->pdw01->subject)),                                    
            'case_no' => htmlspecialchars(strtoupper($filing->references->first()->reference_no)),
            'hq_reference_no' => htmlspecialchars(strtoupper($filing->pdw01->references->first()->reference_no)),
            'hq_reference_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->pdw01->references->first()->created_at))),
            'accept_date' => htmlspecialchars($filing->pdw01->logs()->where('activity_type_id', 12)->first()->data),
            'po_name' => htmlspecialchars(strtoupper($filing->pdw14->po->name)),
            'province_office_name' => htmlspecialchars(strtoupper($filing->pdw01->province_office->name)),
            'pw_name' => htmlspecialchars(strtoupper($filing->pdw14->created_by->name)),
            'tagline' => htmlspecialchars(strtoupper('BERKHIDMAT UNTUK NEGARA')),
            'slogan' => htmlspecialchars('Pekerja Kreative Pencetus Inovatif'),
        ];

        $log = new LogSystem;
        $log->module_id = 30;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/investigation/pdw14.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }
        
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Pelantikan PO';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
