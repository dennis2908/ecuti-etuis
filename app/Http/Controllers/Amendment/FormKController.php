<?php

namespace App\Http\Controllers\Amendment;

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
use App\Mail\FormK\ApprovedKS;
use App\Mail\FormK\ApprovedPWN;
use App\Mail\FormK\Rejected;
use App\Mail\FormK\Sent;
use App\Mail\FormK\NotReceived;
use App\Mail\FormK\DocumentApproved;
use App\Mail\FormK\ReminderConstitution;
use App\Mail\FormK\ReceivedConstitution;
use App\Mail\FormK\ApprovedConstitution;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\FormK;
use App\FilingModel\FormU;
use App\FilingModel\Query;
use App\FilingModel\Constitution;
use App\FilingModel\FormUExaminer;
use App\MasterModel\MasterMeetingType;
use App\UserStaff;
use App\User;
use Carbon\Carbon;
use Validator;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class FormKController extends Controller
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

        $constitution = auth()->user()->entity->constitutions()->where('filing_status_id', 9)->get()->last();

        $draft = auth()->user()->entity->constitutions()->create([
            'created_by_user_id' => auth()->id(),
        ]);

        $log_connection = [];
        foreach($constitution->items()->orderBy('parent_constitution_item_id')->orderBy('below_constitution_item_id')->get() as $item) {
            $new = $draft->items()->create([
                'code' => $item->code,
                'content' => $item->content,
                'parent_constitution_item_id' => $item->parent_constitution_item_id ? $log_connection[$item->parent_constitution_item_id] : null,
                'below_constitution_item_id' => $item->below_constitution_item_id ? $log_connection[$item->below_constitution_item_id] : null,
                'constitution_template_id' => $item->constitution_template_id,
            ]);

            $log_connection[$item->id] = $new->id;
        }

        $formk = FormK::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'constitution_id' => $draft->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);


        $errors_k1 = count(($this->getErrors($formk))['k1']);
        $errors_k2 = count(($this->getErrors($formk))['k2']);
        $errors_constitution = count(($this->getErrors($formk))['constitution']);

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang K";
        $log->data_new = json_encode($formk);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('amendment.formk.index', compact('formk', 'errors_k1', 'errors_k2', 'errors_constitution'));
    }

    /**
     * Insert instance into database
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request) {

        $constitution = Constitution::findOrFail($request->constitution_id);

        $constitution_item = $constitution->items()->create([
            'code' => uniqid(),
            'content' => '',
            'below_constitution_item_id' => $constitution->items()->whereNull('parent_constitution_item_id')->get()->last()->id,
        ]);

        $constitution->changes()->create([
            'constitution_item_id' => $constitution_item->id,
            'change_type_id' => 1,
            'created_by_user_id' => auth()->id(),
        ]);

        return response()->json(['status' => 'success', 'constitution_item_id' => $constitution_item->id]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $formk = FormK::findOrFail($request->id);

        $errors_k1 = count(($this->getErrors($formk))['k1']);
        $errors_k2 = count(($this->getErrors($formk))['k2']);
        $errors_constitution = count(($this->getErrors($formk))['constitution']);

        return view('amendment.formk.index', compact('formk', 'errors_k1', 'errors_k2', 'errors_constitution'));
    }

    /**
     * Show the list application.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 18;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang K";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formk = FormK::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $formk = $formk->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $formk = $formk->where('filing_status_id', '>', 1)->where(function($formk) {
                    return $formk->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($formk){
                        if(auth()->user()->hasRole('ptw'))
                            return $formk->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $formk->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $formk = $formk->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($formk)
                ->editColumn('applied_at', function ($formk) {
                    return $formk->applied_at ? date('d/m/Y', strtotime($formk->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($formk) {

                    if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
                        $status = 'Borang K:<br>';
                    else
                        $status = '';

                    if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
                        $status .= '<span class="badge badge-success">'.$formk->status->name.'</span>';
                    else if($formk->filing_status_id == 8)
                        $status .= '<span class="badge badge-danger">'.$formk->status->name.'</span>';
                    else if($formk->filing_status_id == 7)
                        $status .= '<span class="badge badge-warning">'.$formk->status->name.'</span>';
                    else
                        $status .= '<span class="badge badge-default">'.$formk->status->name.'</span>';

                    if($formk->filing_status_id == 9 || $formk->filing_status_id == 11) {
                        $status .= '<br><br>Buku Perlembagaan:<br>';

                        if($formk->constitution->filing_status_id == 9)
                            $status .= '<span class="badge badge-success">'.$formk->constitution->status->name.'</span>';
                        else if($formk->constitution->filing_status_id == 8)
                            $status .= '<span class="badge badge-danger">'.$formk->constitution->status->name.'</span>';
                        else if($formk->constitution->filing_status_id == 7)
                            $status .= '<span class="badge badge-warning">'.$formk->constitution->status->name.'</span>';
                        else
                            $status .= '<span class="badge badge-default">'.$formk->constitution->status->name.'</span>';
                    }

                    return $status;
                })
                ->editColumn('letter', function($formk) {
                    $result = "";
                    if($formk->filing_status_id == 9) {
                        $result .= letterButton(28, get_class($formk), $formk->id);
                        $result .= letterButton(31, get_class($formk), $formk->id);
                    }
                    elseif($formk->filing_status_id == 8)
                        $result .= letterButton(30, get_class($formk), $formk->id);
                    elseif($formk->filing_status_id == 11)
                        $result .= letterButton(29, get_class($formk), $formk->id);
                    return $result;
                    // return '<a href="'.route('formk.pdf', $formk->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i>'.($formk->logs->count() > 0 ? date('d/m/Y', strtotime($formk->logs->first()->created_at)).' - ' : '').$formk->union->name.'</a><br>';
                })
                ->editColumn('action', function ($formk) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($formk)).'\','.$formk->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $formk->is_editable)) && $formk->filing_status_id < 7)
                        $button .= '<a href="'.route('formk.form', $formk->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    
                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status('.$formk->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if( ((auth()->user()->hasRole('ptw') && $formk->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $formk->distributions->count() == 3)) && $formk->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$formk->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp', 'kpks']) && $formk->filing_status_id < 8)
                        $button .= '<a onclick="query('.$formk->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    
                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp']) && $formk->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$formk->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';
                    
                    if(auth()->user()->hasRole('kpks') && $formk->filing_status_id < 8)
                        $button .= '<a href="'.route('formk.process.result.formk', $formk->id).'" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    if($formk->filing_status_id == 9 || $formk->filing_status_id == 11) {
                        // Special
                        if( auth()->user()->hasRole('pthq') && $formk->constitution->distributions->count() == 0)
                            $button .= '<a onclick="receive('.$formk->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';

                        // Special
                        if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp', 'kpks']) && $formk->constitution->filing_status_id < 8)
                            $button .= '<a onclick="query('.$formk->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';

                        // Special
                        if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp']) && $formk->constitution->filing_status_id < 7)
                            $button .= '<a onclick="recommend('.$formk->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';

                        // Special
                        if(auth()->user()->hasRole('kpks') && $formk->constitution->filing_status_id < 8)
                            $button .= '<a onclick="process('.$formk->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    }
                    
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 18;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang K";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

    	return view('amendment.formk.list');
    }

     public function praecipe(Request $request) {
        $formk = FormK::findOrFail($request->id);
        $pdf = PDF::loadView('amendment.formk.praecipe', compact('formk'));
        return $pdf->setPaper('A4')->setOrientation('portrait')->download('praecipe.pdf');
    }


    /**
     * Show the form application.
     *
     * @return \Illuminate\Http\Response
     */
    public function k1_index(Request $request) {

        $formk = FormK::findOrFail($request->id);
        $meeting_types = MasterMeetingType::whereIn('id', [2,3,4])->get();

        return view('amendment.formk.k1.index', compact('meeting_types', 'formk'));
    }

    /**
     * Show the form application.
     *
     * @return \Illuminate\Http\Response
     */
    public function k2_index(Request $request) {

        $formk = FormK::findOrFail($request->id);
        $formu = $formk->formu()->create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

        return view('amendment.formk.k2.index', compact('formk', 'formu'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function k2_edit(Request $request) {

        $formk = FormK::findOrFail($request->id);
        $formu = FormU::findOrFail($request->formu_id);

        return view('amendment.formk.k2.index', compact('formk', 'formu'));
    }

    /**
     * Remove the specified resource from storage.
     * @param  Request $request
     * @return Response
     */
    public function k2_delete(Request $request)
    {
        $formu = FormU::findOrFail($request->formu_id);

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang K - Borang U";
        $log->data_old = json_encode($formu);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formu->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the form application.
     *
     * @return \Illuminate\Http\Response
     */
    public function k2_list(Request $request) {

        $formk = FormK::findOrFail($request->id);

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 18;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang K - Borang U";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formu = $formk->formu;

            return datatables()->of($formu)
                ->editColumn('voted_at', function ($formu) {
                    return $formu->voted_at ? date('d/m/Y', strtotime($formu->voted_at)) : '-';
                })
                ->editColumn('is_supported', function ($formu) {

                    $supported = '';

                    if($formu->is_supported)
                        $supported .= '<span class="badge badge-success">Menang</span>';
                    else
                        $supported .= '<span class="badge badge-danger">Kalah</span>';

                    return $supported;
                })
                ->editColumn('action', function ($formu) {
                    $button = '';
                    $button .= '<a href="'.route('formk.k2.form', [$formu->filing, $formu->id]).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini</a><br>';
                    $button .= '<a onclick="remove('.$formu->id.')" href="javascript:;" class="btn btn-danger btn-xs mb-1"><i class="fa fa-trash mr-1"></i> Padam</a><br>';
                    $button .= '<a href="'.route('download.formk2', $formu->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-print mr-1"></i> Cetak</a>';

                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 18;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang K - Borang U";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('amendment.formk.k2.list', compact('formk'));
    }

    // Examiner CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function examiner_index(Request $request) {
        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 18;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pegawai Borang U - Butiran Pemeriksa";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formu = FormU::findOrFail($request->formu_id);
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

        $formu = FormU::findOrFail($request->formu_id);
        $examiner = $formu->examiners()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 18;
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
        $log->module_id = 18;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang U - Butiran Pemeriksa";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $examiner = FormUExaminer::findOrFail($request->examiner_id);
        $formk = FormK::findOrFail($request->id);
        $formu = FormU::findOrFail($request->formu_id);

        return view('amendment.formk.k2.examiner.edit', compact('examiner', 'formk', 'formu'));
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
        $log->module_id = 18;
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
        $log->module_id = 18;
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

    // Examiner CRUD END

    private function getErrors($formk) {

        $errors = [];

        if(!$formk) {
            $errors['k1'] = [null,null,null,null];
        }
        else {
            $validate_formk = Validator::make($formk->toArray(), [
                'meeting_type_id' => 'required|integer',
                'resolved_at' => 'required',
                'concluded_at' => 'required',
                'applied_at' => 'required',
            ]);

            $errors_k1 = [];

            if ($validate_formk->fails())
                $errors_k1 = array_merge($errors_k1, $validate_formk->errors()->toArray());

            $errors['k1'] = $errors_k1;
        }

        if($formk->formu->count() < 1)
            $errors['k2'] = ['Borang U perlu diisi.'];
        else {

            $errors_k2 = [];

            foreach($formk->formu as $formu) {
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
                    $errors_k2 = array_merge($errors_k2, [$formu->id => $validate_formu->errors()->toArray()]);
                }
            }

            $errors['k2'] = $errors_k2;
        }

        if($formk->constitution->changes->count() == 0 )
            $errors['constitution'] = ['Senarai Pindaan perlu diisi.'];
        else
            $errors['constitution'] = [];

        return $errors;
    }

    /**
     * Show the form application.
     *
     * @return \Illuminate\Http\Response
     */
    public function editor(Request $request) {

        $formk = FormK::findOrFail($request->id);

        $constitution = $formk->constitution;

        return view('amendment.formk.editor', compact('constitution'));
    }

    /**
     * Show the form application.
     *
     * @return \Illuminate\Http\Response
     */
    public function query(Request $request) {
        return view('amendment.formk.query');
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $formk = FormK::findOrFail($request->id);

        $error_list = $this->getErrors($formk);
        $errors = count($error_list['k1']) + count($error_list['k2']);
        //return response()->json(['errors' => $errors], 422);

        if($errors > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 18;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang K - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formk->logs()->updateOrCreate(
                [
                    'module_id' => 18,
                    'activity_type_id' => 11,
                    'filing_status_id' => $formk->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $formk->filing_status_id = 2;
            $formk->is_editable = 0;
            $formk->save();

            $formk->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 18,
            ]);

            Mail::to($formk->created_by->email)->send(new Sent($formk, 'Permohonan Borang K'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($formk, $target) {

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $check = $formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($formk->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\FormK')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $formk->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formk->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($formk->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormK')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $formk->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formk->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($formk, 'Serahan Permohonan Borang K'));
        }
        else if($target == "pw") {
            if($formk->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $formk->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formk->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($formk, 'Serahan Permohonan Borang K'));
        }
        else if($target == "pthq") {
            if($formk->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\FormK')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $formk->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formk->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($formk->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\FormK')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $formk->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formk->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($formk, 'Serahan Permohonan Borang K'));
        }
        else if($target == "pkpp") {
            if($formk->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $formk->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formk->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($formk, 'Serahan Permohonan Borang K'));
        }
        else if($target == "kpks") {
            if($formk->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $formk->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $formk->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($formk, 'Serahan Permohonan Borang K'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $formk = FormK::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang K - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $route = route('formk.process.document-receive', $request->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang K - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $formk->filing_status_id = 3;
        $formk->save();

        $formk->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 18,
            ]
        );

        $formk->logs()->updateOrCreate(
            [
                'module_id' => 18,
                'activity_type_id' => 12,
                'filing_status_id' => $formk->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($formk, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($formk, 'ppw');

            if(strpos(get_class($formk), 'FormK') !== false)
                Mail::to($formk->created_by->email)->send(new Received(auth()->user(), $formk, 'Pengesahan Penerimaan Permohonan Borang K'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($formk, 'pphq');

            if(strpos(get_class($formk), 'FormK') !== false) {
                Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formk, 'Pengesahan Penerimaan Permohonan Borang K'));
                Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $formk, 'Pengesahan Penerimaan Permohonan Borang K'));
            }
            else {
                Mail::to($formk->created_by->email)->send(new ReceivedConstitution($formk, 'Pengesahan Penerimaan Salinan Buku Perlembagaan'));
            }
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $formk = FormK::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang K - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $route = route('formk.process.query.item', $request->id);
        $route2 = route('formk.process.query', $request->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $formk = FormK::findOrFail($request->id);

        if(count($formk->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang K - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $formk->filing_status_id = 5;
        $formk->is_editable = 1;
        $formk->save();

        $log2 = $formk->logs()->updateOrCreate(
            [
                'module_id' => 18,
                'activity_type_id' => 13,
                'filing_status_id' => $formk->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $formk->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formk, 'Kuiri Permohonan Borang K oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $formk->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formk, 'Kuiri Permohonan Borang K oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $formk->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $formk, 'Kuiri Permohonan Borang K oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($formk->created_by->email)->send(new Queried(auth()->user(), $formk, 'Kuiri Permohonan Borang K'));
        }

        $formk->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 18;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Borang K - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formk = FormK::findOrFail($request->id);

            if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

            $queries = $formk->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 18;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Borang K - Kuiri";
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
            $query = $formk->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 18;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Borang K - Kuiri";
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
        $log->module_id = 18;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Borang K - Kuiri";
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

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang K - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $formk->logs()->where('activity_type_id',14)->where('filing_status_id', $formk->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('formk.process.recommend', $request->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang K - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $formk->filing_status_id = 6;
        $formk->is_editable = 0;
        $formk->save();

        $formk->logs()->updateOrCreate(
            [
                'module_id' => 18,
                'activity_type_id' => 14,
                'filing_status_id' => $formk->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($formk, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($formk, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($formk, 'kpks');
        else if(auth()->user()->hasRole('pw') && strpos(get_class($formk), 'FormK') !== false)
            Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $formk, 'Serahan Permohonan Borang K'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang K - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formk.process.delay', $request->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang K - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $formk->filing_status_id = 7;
        $formk->is_editable = 0;
        $formk->save();

        $formk->logs()->updateOrCreate(
            [
                'module_id' => 18,
                'activity_type_id' => 15,
                'filing_status_id' => $formk->filing_status_id,
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

        $formk = FormK::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Borang K - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formk.process.status', $request->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang K - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formk = FormK::findOrFail($request->id);

        $log = $formk->logs()->create([
                'module_id' => 18,
                'activity_type_id' => 20,
                'filing_status_id' => $formk->filing_status_id,
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
    public function process_result_formk_edit(Request $request) {

        $formk = FormK::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 2;
        $log->description = "Paparan Keputusan Borang K";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('amendment.formk.result', compact('formk'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_formk_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Keputusan Borang K";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formk = FormK::findOrFail($request->id);

        $result = [];

        foreach($request->constitution_change_id as $index => $constitution_change_id) {
            $formk->constitution->changes()->findOrFail($constitution_change_id)->update([
                'is_approved' => $request->is_approved[$index],
                'result_details' => $request->result_details[$index],
            ]);
        }

        if($formk->constitution->changes()->where('is_approved', 0)->count() == 0) {
            // Approved
            $formk->filing_status_id = 9;
            $formk->is_editable = 0;
            $formk->save();

            $formk->logs()->update([
                'module_id' => 18,
                'activity_type_id' => 16,
                'filing_status_id' => $formk->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ]);

            Mail::to($formk->created_by->email)->send(new ApprovedKS($formk, 'Status Permohonan Borang K'));
            Mail::to($formk->created_by->email)->send(new ReminderConstitution($formk, 'Peringatan Serahan Salinan Buku Perlembagaan'));

            Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formk, 'Status Permohonan Borang K'));
            Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formk, 'Status Permohonan Borang K'));
            Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formk, 'Status Permohonan Borang K'));
            Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($formk, 'Sedia Dokumen Kelulusan Borang K'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
        }
        else if($formk->constitution->changes()->where('is_approved', 1)->count() == 0) {
            // Rejected
            $formk->filing_status_id = 8;
            $formk->is_editable = 0;
            $formk->save();

            $formk->logs()->update([
                'module_id' => 18,
                'activity_type_id' => 16,
                'filing_status_id' => $formk->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ]);

            Mail::to($formk->created_by->email)->send(new Rejected($formk, 'Status Permohonan Borang K'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
        }
        else {
            // Approved + Rejected
            $formk->filing_status_id = 11;
            $formk->is_editable = 0;
            $formk->save();

            $formk->logs()->update([
                'module_id' => 18,
                'activity_type_id' => 16,
                'filing_status_id' => $formk->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ]);

            Mail::to($formk->created_by->email)->send(new ApprovedKS($formk, 'Status Permohonan Borang K'));
            Mail::to($formk->created_by->email)->send(new ReminderConstitution($formk, 'Peringatan Serahan Salinan Buku Perlembagaan'));

            Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formk, 'Status Permohonan Borang K'));
            Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formk, 'Status Permohonan Borang K'));
            Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($formk, 'Status Permohonan Borang K'));
            Mail::to($formk->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($formk, 'Sedia Dokumen Kelulusan Borang K'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result(Request $request) {

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $form = $formk;

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang K - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("formk.process.result.reject", $request->id);
        $route_approve = route("formk.process.result.approve", $request->id);
        $route_delay = route("formk.process.delay", $request->id);

        if(strpos(get_class($formk), 'FormK') !== false)
            return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
        else
            return view('general.modal.result-only', compact('route_reject','route_approve'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang K - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formk.process.result.approve', $request->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang K - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $formk->filing_status_id = 9;
        $formk->is_editable = 0;
        $formk->save();

        $formk->logs()->updateOrCreate(
            [
                'module_id' => 18,
                'activity_type_id' => 16,
                'filing_status_id' => $formk->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($formk->created_by->email)->send(new ApprovedConstitution($formk, 'Kelulusan Buku Perlembagaan'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Buku Perlembagaan Kesatuan Sekerja ini telah diluluskan. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Borang K - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('formk.process.result.reject', $request->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 18;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Borang K - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $formk = FormK::findOrFail($request->id);

        if($formk->filing_status_id == 9 || $formk->filing_status_id == 11)
            $formk = $formk->constitution;

        $formk->filing_status_id = 8;
        $formk->is_editable = 0;
        $formk->save();

        $formk->logs()->updateOrCreate(
            [
                'module_id' => 18,
                'activity_type_id' => 16,
                'filing_status_id' => $formk->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Buku Perlembagaan Kesatuan Sekerja ini tidak diluluskan.']);
        
    }

    public function download(Request $request) {

        $filing = FormK::findOrFail($request->id);                                                      // Change here
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
            'secretary_name' => htmlspecialchars($filing->tenure->entity->user->name),
            'meeting_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'resolved_day' => htmlspecialchars(strftime('%e', strtotime($filing->resolved_at))),
            'resolved_month_year' => htmlspecialchars(strftime('%B %Y', strtotime($filing->resolved_at))),
            'today_day' => htmlspecialchars(strftime('%e')),
            'today_month_year' => htmlspecialchars(strftime('%B %Y'))
        ];

        $log = new LogSystem;
        $log->module_id = 18;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/amendment/formk1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang K';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function formk2_download(Request $request) {

        $filing = FormU::findOrFail($request->id);

        $result = $filing->total_voters != 0 ? $filing->total_supporting / $filing->total_voters * 100 : 0;
        $total_return = $filing->total_slips - $filing->total_supporting - $filing->total_against;
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
        $log->module_id = 18;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/amendment/formk2.docx'));        // Change here

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
        $file_name = uniqid().'_'.'Borang K2';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

    public function formk3_download(Request $request) {

        $filing = FormK::findOrFail($request->id);                                                      // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name_uppercase' => htmlspecialchars(strtoupper($filing->tenure->entity->name)),
            'secretary_name' => htmlspecialchars($filing->tenure->entity->user->name),
            'today_date' => htmlspecialchars(strftime('%e %B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 18;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/amendment/formk3.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table requesters
        $rows = $filing->constitution->changes;
        $document->cloneRow('no', count($rows));

        foreach($rows as $index => $row) {
            if($row->type->id == 1) {
                $original_constitution = '-';
            }
            else {
                $current_constitution = $filing->tenure->entity->constitutions()->where('filing_status_id', 9)->get()->last();
                $previous_item = $current_constitution->items()->withTrashed()->where('code', $row->item->code)->get();

                if(count($previous_item) > 0)
                    $original_constitution = $previous_item->last()->content;
                else
                    $original_constitution = '-';
            }

            if($row->type->id == 3) {
                $amendment = '-';
            }
            else {
                $amendment = $row->item ? $row->item->content : '-';
            }

            $document->setValue('no#'.($index+1), ($index+1));
            $document->setValue('original_constitution#'.($index+1), htmlspecialchars(strtoupper($original_constitution)));
            $document->setValue('amendment#'.($index+1), htmlspecialchars(strtoupper($amendment)));
            $document->setValue('justification#'.($index+1), htmlspecialchars(strtoupper($row->justification)));
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang K3';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
