<?php

namespace App\Http\Controllers\ChangeOfficer;

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
use App\Mail\FormL1\ApprovedKS;
use App\Mail\FormL1\ApprovedPWN;
use App\Mail\FormL1\Rejected;
use App\Mail\FormL1\Sent;
use App\Mail\FormL1\NotReceived;
use App\FilingModel\FormL1;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\MasterModel\MasterState;
use App\OtherModel\Address;
use App\MasterModel\MasterMeetingType;
use App\FilingModel\Worker;
use App\FilingModel\FormL1Appointed;
use App\FilingModel\FormL1Resign;
use App\FilingModel\Query;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class L1Controller extends Controller
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
            $log->module_id = 21;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang L1";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $forml1 = FormL1::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $forml1 = $forml1->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $forml1 = $forml1->where('filing_status_id', '>', 1)->where(function($forml1) {
                    return $forml1->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($forml1){
                        if(auth()->user()->hasRole('ptw'))
                            return $forml1->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $forml1->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $forml1 = $forml1->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($forml1)
                ->editColumn('tenure.entity.name', function ($forml1) {
                    return $forml1->tenure->entity->name;
                })
                ->editColumn('entity_type', function ($forml1) {
                    return $forml1->tenure->entity_type == "App\\UserUnion" ? 'Kesatuan' : 'Persekutuan';
                })
                ->editColumn('applied_at', function ($forml1) {
                    return $forml1->applied_at ? date('d/m/Y', strtotime($forml1->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($forml1) {
                    if($forml1->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$forml1->status->name.'</span>';
                    else if($forml1->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$forml1->status->name.'</span>';
                    else if($forml1->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$forml1->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$forml1->status->name.'</span>';
                })
                ->editColumn('letter', function($forml1) {
                    $result = "";
                    if($forml1->filing_status_id == 9){
                        $result .= letterButton(36, get_class($forml1), $forml1->id);
                    }
                    return $result;
                })
                ->editColumn('action', function ($forml1) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($forml1)).'\','.$forml1->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $forml1->is_editable)) && $forml1->filing_status_id < 7 )
                        $button .= '<a href="'.route('forml1.item', $forml1->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';

                    if( ((auth()->user()->hasRole('ptw') && $forml1->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $forml1->distributions->count() == 3)) && $forml1->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$forml1->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg', 'kpks']) && $forml1->filing_status_id < 8 )
                        $button .= '<a onclick="query('.$forml1->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpg']) && $forml1->filing_status_id < 7 )
                        $button .= '<a onclick="recommend('.$forml1->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';

                    if(auth()->user()->hasRole('kpks') && $forml1->filing_status_id < 8 )
                        $button .= '<a onclick="process('.$forml1->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 21;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang L1";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('change-officer.l1.list');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $tenures = auth()->user()->entity->tenures()->doesntHave('forml1')->get();

        $forml1 = FormL1::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
        ]);

        $error_list = $this->getErrors($forml1);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang L1";
        $log->data_new = json_encode($forml1);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('change-officer.l1.index', compact('tenures','forml1','error_list'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $tenures = auth()->user()->entity->tenures;

        $forml1 = FormL1::findOrFail($request->id);

        $error_list = $this->getErrors($forml1);

        return view('change-officer.l1.index', compact('tenures','forml1','error_list'));
    }

    private function getErrors($forml1) {

        $errors = [];

        if(!$forml1) {
            $errors['l1'] = [null,null];
        }
        else {
            $errors_l1 = [];

            $validate_forml1 = Validator::make($forml1->toArray(), [
                'resolved_at' => 'required',
                'meeting_type_id' => 'required|integer',
            ]);

            if ($validate_forml1->fails())
                $errors_l1 = array_merge($errors_l1, $validate_forml1->errors()->toArray());

            // if($forml1->tenure->workers->count() < 5)
            //     $errors_l1 = array_merge($errors_l1, ['workers' => ['Jumlah pekerja yang meninggalkan jawatan kurang dari 5 orang.']]);

            // if($forml1->tenure->workers->count() < 5)
            //     $errors_l1 = array_merge($errors_l1, ['workers' => ['Jumlah pekerja yang dilantik kurang dari 5 orang.']]);

            $errors['l1'] = $errors_l1;
        }

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $forml1 = FormL1::findOrFail($request->id);
        $error_list = $this->getErrors($forml1);
        $errors = $error_list['l1'];

        //return response()->json(['errors' => $errors], 422);

        if(count($errors) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 21;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang L1 - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $forml1 = FormL1::findOrFail($request->id);

            $forml1->logs()->updateOrCreate(
                [
                    'module_id' => 21,
                    'activity_type_id' => 11,
                    'filing_status_id' => $forml1->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $forml1->filing_status_id = 2;
            $forml1->is_editable = 0;
            $forml1->applied_at = date('Y-m-d');
            $forml1->save();

            $forml1->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 21,
            ]);

            Mail::to($forml1->created_by->email)->send(new Sent($forml1, 'Penghantaran Notis Pertukaran Pekerja'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar. Sila hantar dokumen fizikal dalam masa 7 hari.']);
        }
    }

    public function praecipe(Request $request) {
        $forml1 = FormL1::findOrFail($request->id);

        $pdf = PDF::loadView('change-officer.l1.praecipe', compact('forml1'));
        return $pdf->setPaper('A4')->setOrientation('portrait')->download('praecipe.pdf');
    }


     /**
     * Show the form for Form L1
     *
     * @return \Illuminate\Http\Response
     */
    public function forml1(Request $request) {

        $states = MasterState::all();
        $meeting_type = MasterMeetingType::whereIn('id', [2,3,5])->get();

        $forml1 = FormL1::findOrFail($request->id);

        $tenure = auth()->user()->entity->tenures->last();
        $previous = auth()->user()->entity->tenures()->where('id', '<', $tenure->id)->orderBy('start_year', 'desc')->first();
        $workers = $previous->workers;

        return view('change-officer.l1.forml1.index', compact('forml1','states','workers','meeting_type'));
    }

        /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    //Requester CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function resign_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Pekerja Borang L1 - Butiran Pekerja Yang Meninggalkan Pelantikan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $resigns = FormL1Resign::where('forml1_id', $request->id)->with('worker');

        return datatables()->of($resigns)
            ->editColumn('worker.appointment', function ($resign) {
                return $resign->worker->appointment;
            })
            ->editColumn('worker.name', function ($resign) {
                return $resign->worker->name;
            })
            ->editColumn('left_at', function ($resign) {
                return $resign->left_at ? date('d/m/Y', strtotime($resign->left_at)) : '';
            })
            ->editColumn('action', function ($resign) {
                $button = "";

                if(!$resign->id)
                    $button .= '<a onclick="add()" href="javascript:;" class="btn btn-primary btn-xs "><i class="fa fa-edit"></i></a> ';
                else {
                    $button .= '<a onclick="editResign('.$resign->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="removeResign('.$resign->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';
                }
                return $button;
            })
            ->make(true);
    }

    public function resign_insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'left_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $forml1 = FormL1::findOrFail($request->id);

        $request->request->add(['forml1_id' => $forml1->id]);
        $request->request->add(['left_at' => Carbon::createFromFormat('d/m/Y', $request->left_date)->toDateString()]);

        $resign = FormL1Resign::create($request->all());

        $count = $forml1->resigns->count();

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang L1 - Butiran Pekerja Yang Meninggalkan Pelantikan";
        $log->data_new = json_encode($resign);
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
    public function resign_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang L1 - Butiran Pekerja Yang Meninggalkan Pelantikan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $resign = FormL1Resign::findOrFail($request->resign_id);
        $forml1 = FormL1::findOrFail($request->id);
        $workers = $forml1->tenure->workers;

        return view('change-officer.l1.forml1.tab2.edit', compact('resign','workers'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function resign_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'left_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $resign = FormL1Resign::findOrFail($request->resign_id);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang L1 - Butiran Pekerja Yang Meninggalkan Pelantikan";
        $log->data_old = json_encode($resign);

        $request->request->add(['left_at' => Carbon::createFromFormat('d/m/Y', $request->left_date)->toDateString()]);
        $resign->update($request->all());

        $log->data_new = json_encode($resign);
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
    public function resign_delete(Request $request) {

        $forml1 = FormL1::findOrFail($request->id);

        $resign = FormL1Resign::findOrFail($request->resign_id);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang L1 - Butiran Pekerja Yang Meninggalkan Pelantikan";
        $log->data_old = json_encode($resign);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $resign->delete();

        $count = $forml1->resigns->count();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.', 'count' => $count]);
    }
    //Resign Worker CRUD END

    //Worker CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function worker_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Pekerja Borang L1 - Butiran Pekerja Yang Dilantik";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $workers = FormL1Appointed::where('forml1_id', $request->id);

        return datatables()->of($workers)
            ->editColumn('appointed_at', function ($worker) {
                return $worker->appointed_at ? date('d/m/Y', strtotime($worker->appointed_at)) : '';
            })
            ->editColumn('action', function ($worker) {
                $button = "";

                if(!$worker->id)
                    $button .= '<a onclick="addWorker()" href="javascript:;" class="btn btn-primary btn-xs "><i class="fa fa-edit"></i></a> ';
                else {
                    $button .= '<a onclick="editWorker('.$worker->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="removeWorker('.$worker->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';
                }
                return $button;
            })
            ->make(true);
    }

    public function worker_insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'appointment' => 'required|string',
            'identification_no' => 'required|string',
            'dob' => 'required',
            'occupation' => 'required|string',
            'appointed_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $forml1 = FormL1::findOrFail($request->id);

        $address = Address::create($request->all());
        $request->request->add(['address_id' => $address->id]);

        $request->request->add(['date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->dob)->toDateString()]);
        $request->request->add(['appointed_at' => Carbon::createFromFormat('d/m/Y', $request->appointed_date)->toDateString()]);
        $request->request->add(['forml1_id' => $forml1->id]);

        $worker = FormL1Appointed::create($request->all());

        $count = $forml1->appointed->count();

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang L1 - Butiran Pekerja Yang Dilantik";
        $log->data_new = json_encode($worker);
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
    public function worker_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang L1 - Butiran Pekerja Yang Dilantik";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $worker = FormL1Appointed::findOrFail($request->worker_id);
        $states = MasterState::all();

        return view('change-officer.l1.forml1.tab3.edit', compact('worker','states'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function worker_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'appointment' => 'required|string',
            'identification_no' => 'required|string',
            'dob' => 'required',
            'occupation' => 'required|string',
            'appointed_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $worker = FormL1Appointed::findOrFail($request->worker_id);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang L1 - Butiran Pekerja Yang Dilantik";
        $log->data_old = json_encode($worker);

        $request->request->add(['date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->dob)->toDateString()]);
        $request->request->add(['appointed_at' => Carbon::createFromFormat('d/m/Y', $request->appointed_date)->toDateString()]);

        $worker->update($request->all());
        $worker->address()->update($request->all());

        $log->data_new = json_encode($worker);
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
    public function worker_delete(Request $request) {

        $forml1 = FormL1::findOrFail($request->id);

        $worker = FormL1Appointed::findOrFail($request->worker_id);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang L1 - Butiran Pekerja Yang Dilantik";
        $log->data_old = json_encode($worker);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $worker->delete();

        $count = $forml1->appointed->count();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.', 'count' => $count]);
    }
    //Worker CRUD END

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($forml1, $target) {

        $check = $forml1->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($forml1->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormL1')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $forml1->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $forml1->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($forml1->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormL1')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $forml1->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $forml1->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($forml1, 'Serahan Notis Pertukaran Pekerja'));
        }
        else if($target == "pw") {
            if($forml1->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $forml1->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $forml1->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($forml1, 'Serahan Notis Pertukaran Pekerja'));
        }
        else if($target == "pthq") {
            if($forml1->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormL1')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $forml1->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $forml1->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($forml1->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormL1')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $forml1->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $forml1->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($forml1, 'Serahan Notis Pertukaran Pekerja'));
        }
        else if($target == "pkpg") {
            if($forml1->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpg = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',12)->first();

            $forml1->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $forml1->filing_status_id,
                    'assigned_to_user_id' => $pkpg->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpg->user->email)->send(new Distributed($forml1, 'Serahan Notis Pertukaran Pekerja'));
        }
        else if($target == "kpks") {
            if($forml1->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $forml1->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $forml1->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($forml1, 'Serahan Notis Pertukaran Pekerja'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $forml1 = FormL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang L1 - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('forml1.process.document-receive', $forml1->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang L1 - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $forml1 = FormL1::findOrFail($request->id);

        $forml1->filing_status_id = 3;
        $forml1->save();

        $forml1->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 21,
            ]
        );

        $forml1->logs()->updateOrCreate(
            [
                'module_id' => 21,
                'activity_type_id' => 12,
                'filing_status_id' => $forml1->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($forml1, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($forml1, 'ppw');
            Mail::to($forml1->created_by->email)->send(new Received(auth()->user(), $forml1, 'Pengesahan Penerimaan Notis Pertukaran Pekerja'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($forml1, 'pphq');
            Mail::to($forml1->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $forml1, 'Pengesahan Penerimaan Notis Pertukaran Pekerja'));
            Mail::to($forml1->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $forml1, 'Pengesahan Penerimaan Notis Pertukaran Pekerja'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $forml1 = FormL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang L1 - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('forml1.process.query.item', $forml1->id);
        $route2 = route('forml1.process.query', $forml1->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $forml1 = FormL1::findOrFail($request->id);

        if(count($forml1->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang L1 - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $forml1->filing_status_id = 5;
        $forml1->is_editable = 1;
        $forml1->save();

        $log2 = $forml1->logs()->updateOrCreate(
            [
                'module_id' => 21,
                'activity_type_id' => 13,
                'filing_status_id' => $forml1->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $forml1->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $forml1, 'Kuiri Permohonan Borang L1 oleh PW'));
        } else if(auth()->user()->hasRole('pkpg')) {
            // Send to PPHQ
            $log = $forml1->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $forml1, 'Kuiri Permohonan Borang L1 oleh PKPG'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to PKPG
            $log = $forml1->logs()->where('role_id', 12)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $forml1, 'Kuiri Permohonan Borang L1 oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($forml1->created_by->email)->send(new Queried(auth()->user(), $forml1, 'Kuiri Permohonan Borang L1'));
        }

        $forml1->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 21;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang L1 - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $forml1 = FormL1::findOrFail($request->id);

            $queries = $forml1->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $forml1 = FormL1::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 21;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang L1 - Kuiri";
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
            $query = $forml1->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 21;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang L1 - Kuiri";
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
        $log->module_id = 21;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang L1 - Kuiri";
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

        $forml1 = FormL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang L1 - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $forml1->logs()->where('activity_type_id',14)->where('filing_status_id', $forml1->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('forml1.process.recommend', $forml1->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang L1 - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $forml1 = FormL1::findOrFail($request->id);
        $forml1->filing_status_id = 6;
        $forml1->is_editable = 0;
        $forml1->save();

        $forml1->logs()->updateOrCreate(
            [
                'module_id' => 21,
                'activity_type_id' => 14,
                'filing_status_id' => $forml1->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($forml1, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($forml1, 'pkpg');
        else if(auth()->user()->hasRole('pkpg'))
            $this->distribute($forml1, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($forml1->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $forml1, 'Serahan Notis Pertukaran Pekerja ke Ibu Pejabat'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result(Request $request) {

        $form = $forml1 = FormL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang L1 - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("forml1.process.result.reject", $form->id);
        $route_approve = route("forml1.process.result.approve", $form->id);

        return view('general.modal.result-officer', compact('route_reject','route_approve'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $forml1 = FormL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang L1 - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('forml1.process.result.approve', $forml1->id);

        return view('general.modal.register', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang L1 - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $forml1 = FormL1::findOrFail($request->id);
        $forml1->filing_status_id = 9;
        $forml1->is_editable = 0;
        $forml1->save();

        $forml1->logs()->updateOrCreate(
            [
                'module_id' => 21,
                'activity_type_id' => 16,
                'filing_status_id' => $forml1->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        $resigning = $forml1->resigns()->select('worker_id as id')->get()->toArray();
        $tenure = $forml1->tenure->entity->tenures->last();
        $previous = $forml1->tenure->entity->tenures()->where('id', '<', $tenure->id)->orderBy('start_year', 'desc')->first();
        $remainders = $previous->workers()->whereNotIn('id', $resigning)->get();

        foreach($forml1->appointed as $new) {
            $tenure->workers()->create($new->toArray());
        }

        foreach($remainders as $remainder) {
            if(!$forml1->workers()->where('identification_no', $remainder->identification_no)->first())
                $tenure->workers()->create($remainder->toArray());
        }

        Mail::to($forml1->created_by->email)->send(new ApprovedKS($forml1, 'Status Notis Pertukaran Pekerja'));
        Mail::to($forml1->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($forml1, 'Status Notis Pertukaran Pekerja'));
        Mail::to($forml1->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($forml1, 'Status Notis Pertukaran Pekerja'));
        Mail::to($forml1->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($forml1, 'Status Notis Pertukaran Pekerja'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $forml1 = FormL1::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang L1 - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('forml1.process.result.reject', $forml1->id);

        return view('general.modal.not-register', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 21;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang L1 - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $forml1 = FormL1::findOrFail($request->id);
        $forml1->filing_status_id = 8;
        $forml1->is_editable = 0;
        $forml1->save();

        $forml1->logs()->updateOrCreate(
            [
                'module_id' => 21,
                'activity_type_id' => 16,
                'filing_status_id' => $forml1->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($forml1->created_by->email)->send(new Rejected($forml1, 'Status Notis Pertukaran Pekerja'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function download(Request $request) {

        $filing = FormL1::findOrFail($request->id);                                                      // Change here
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
                (', '.htmlspecialchars($filing->branch->address->address1).
                ($filing->branch->address->address2 ? ', '.htmlspecialchars($filing->branch->address->address2) : '').
                ($filing->branch->address->address3 ? ', '.htmlspecialchars($filing->branch->address->address3) : '').
                ', '.($filing->branch->address->postcode).
                ($filing->branch->address->district ? ' '.htmlspecialchars($filing->branch->address->district->name) : '').
                ($filing->branch->address->state ? ', '.htmlspecialchars($filing->branch->address->state->name) : '')) : '',
            'is_branch' => $filing->branch ? htmlspecialchars('Cawangan') : htmlspecialchars('Kesatuan'),
            'meeting_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'resolved_day' => htmlspecialchars(strftime('%e', strtotime($filing->resolved_at))),
            'resolved_month_year' => htmlspecialchars(strftime('%B %Y', strtotime($filing->resolved_at))),
            'today_day' => htmlspecialchars(strftime('%e')),
            'today_month_year' =>  htmlspecialchars(strftime('%B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 19;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/change-officer/forml1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }


        // Generate table leaving
        $rows = $filing->resigns;
        $document->cloneRow('resign_name', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('resign_name#'.($index+1), htmlspecialchars($row->worker->name));
            $document->setValue('resign_appointment#'.($index+1), htmlspecialchars(strtoupper($row->worker->appointment)));
            $document->setValue('resign_at#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row->left_at))));
        }

        // Generate table officer
        $rows2 = $filing->appointed;
        $document->cloneRow('worker_appointment', count($rows2));

        foreach($rows2 as $index => $row2) {
            $document->setValue('worker_appointment#'.($index+1), htmlspecialchars(strtoupper($row2->appointment)));
            $document->setValue('worker_name#'.($index+1), htmlspecialchars(strtoupper($row2->name)));
            $document->setValue('worker_ic#'.($index+1), htmlspecialchars($row2->identification_no));
            $document->setValue('worker_dob#'.($index+1), htmlspecialchars(date('d/m/Y', strtotime($row2->date_of_birth))));
            $document->setValue('worker_address#'.($index+1), htmlspecialchars(strtoupper($row2->address->address1)).
                ($row2->address->address2 ? ', '.htmlspecialchars(strtoupper($row2->address->address2)) : '').
                ($row2->address->address3 ? ', '.htmlspecialchars(strtoupper($row2->address->address3)) : '').
                ', '.($row2->address->postcode).
                ($row2->address->district ? ' '.htmlspecialchars(strtoupper($row2->address->district->name)) : '').
                ($row2->address->state ? ', '.htmlspecialchars(strtoupper($row2->address->state->name)) : '')
            );
            $document->setValue('worker_occupation#'.($index+1), htmlspecialchars(strtoupper($row2->occupation)));
            $document->setValue('worker_appointed_at#'.($index+1), htmlspecialchars(strtoupper($row2->appointed_at)));
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang L1';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
