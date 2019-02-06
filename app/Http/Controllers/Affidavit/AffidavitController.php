<?php

namespace App\Http\Controllers\Affidavit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\FilingModel\AffidavitRespondent;
use App\FilingModel\AffidavitReport;
use App\FilingModel\AffidavitReportData;
use App\MasterModel\MasterAttorney;
use App\MasterModel\MasterCourt;
use App\FilingModel\Affidavit;
use App\OtherModel\Attachment;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Affidavit\SentPKPP;
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

class AffidavitController extends Controller
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

        $affidavit = Affidavit::create([
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);

    	return view('affidavit.index', compact('affidavit'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $affidavit = Affidavit::findOrFail($request->id);

        return view('affidavit.index', compact('affidavit'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 33;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Afidavit";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $affidavits = Affidavit::with(['status', 'report']);

            if(auth()->user()->hasRole('pthq')) {
                $affidavits = $affidavits->where('created_by_user_id', auth()->id());
            }
            else {
                $affidavits = $affidavits->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($affidavits)
                // ->editColumn('report.judical_no', function ($affidavit) {
                //     return $affidavit->report ? $affidavit->report->judicial_no : '';
                // })
                ->editColumn('applied_at', function ($affidavit) {
                    return $affidavit->created_at ? date('d/m/Y', strtotime($affidavit->created_at)) : '';
                })
                ->editColumn('status.name', function ($affidavit) {
                    if($affidavit->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$affidavit->status->name.'</span>';
                    else if($affidavit->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$affidavit->status->name.'</span>';
                    else if($affidavit->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$affidavit->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$affidavit->status->name.'</span>';
                })
                ->editColumn('letter', function($affidavit) {
                    $result = "";

                    if($affidavit->report)
                        if($affidavit->filing_status_id > 1 && $affidavit->report->filing_status_id > 2){
                            $result .= letterButton(61, get_class($affidavit), $affidavit->id);
                            $result .= '<a href="'.route('download.affidavit', $affidavit->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Laporan</a><br>';
                        }
                    return $result;
                })
                ->editColumn('action', function ($affidavit) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($affidavit)).'\','.$affidavit->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    
                    if((auth()->user()->hasRole('pthq') && $affidavit->is_editable) && $affidavit->filing_status_id < 7)
                        $button .= '<a href="'.route('affidavit.form', $affidavit->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Kes</a><br>';
                    
                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status('.$affidavit->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';
                    
                    if((auth()->user()->hasRole('pphq') || ($affidavit->report && $affidavit->report->is_editable)) && $affidavit->filing_status_id < 7)
                        $button .= '<a href="'.route('affidavit.form.report', $affidavit->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Laporan</a><br>';
                    
                    if(auth()->user()->hasRole('pkpp') && $affidavit->filing_status_id < 8)
                        $button .= '<a onclick="query('.$affidavit->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';
                    return $button;
                })
                ->make(true);

        }
        else {
            $log = new LogSystem;
            $log->module_id = 33;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang Afidavit";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('affidavit.list');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request) {

        $affidavit = Affidavit::findOrFail($request->id);
        $attorneys = MasterAttorney::all();
        $courts = MasterCourt::all();

        $affidavit_report = AffidavitReport::updateOrCreate(['affidavit_id' => $request->id], [
            'created_by_user_id' => auth()->id()
        ]);

        return view('affidavit.report', compact('affidavit', 'attorneys', 'courts'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function report_submit(Request $request) {

        $affidavit = Affidavit::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Afidavit - Laporan";
        $log->url = $request->fullUrl();
        $log->data_old = json_encode($affidavit->report);

        $affidavit_report = $affidavit->report()->update([
            'filing_status_id' => 3,
            'is_editable' => 0
        ]);

        $log->data_new = json_encode($affidavit->report);
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $affidavit->filing_status_id = 2;
        $affidavit->save();

        $affidavit->logs()->updateOrCreate(
            [
                'module_id' => 33,
                'activity_type_id' => 5,
                'filing_status_id' => $affidavit->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->roles->last()->id,
            ],
            [
                'data' => ''
            ]
        );

        if($affidavit->logs->count() == 2)
            $this->distribute($affidavit, 'pkpp');

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dihantar.']);


    }

    // Report CRUD START

    public function report_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Laporan Affidavit Jawapan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $reports = AffidavitReportData::where('affidavit_id', $request->id);

        return datatables()->of($reports)
            ->editColumn('action', function ($report) {
                $button = "";

                $button .= '<a onclick="edit('.$report->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                $button .= '<a onclick="remove('.$report->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';
                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function report_insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'data' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $report = AffidavitReportData::create([
            'affidavit_id' => $request->id,
            'data' => $request->data,
            'created_by_user_id' => auth()->id(),
        ]);

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 4;
        $log->description = "Tambah Laporan - Affidavit Jawapan";
        $log->data_new = json_encode($report);
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
    public function report_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Laporan - Affidavit Jawapan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $report = AffidavitReportData::findOrFail($request->report_id);

        return view('affidavit.report.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function report_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'data' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $report = AffidavitReportData::where('report_id', $request->report_id);

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Laporan - Affidavit Jawapan";
        $log->data_old = json_encode($report);

        $report->update([
            'data' => $request->data,
        ]);

        $log->data_new = json_encode($report);
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
    public function report_delete(Request $request) {

        $report = AffidavitReportData::where('report_id', $request->report_id);

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 6;
        $log->description = "Padam Laporan - Affidavit Jawapan";
        $log->data_old = json_encode($report);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $report->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    public function respondent_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Afidavit - Responden";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $affidavit = Affidavit::findOrFail($request->id);

        return datatables()->of($affidavit->respondents)
            ->editColumn('action', function ($respondent) {
                $button = "";
                $button .= '<button type="button" class="btn btn-danger btn-xs" onclick="removeRespondent('.$respondent->id.')"><i class="fa fa-times"></i></button>';

                return $button;
            })
            ->make(true);
    }

    public function respondent_insert(Request $request) {

        $affidavit = Affidavit::findOrFail($request->id);
        $respondent = $affidavit->respondents()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 4;
        $log->description = "Tambah Afidavit - Responden";
        $log->data_new = json_encode($respondent);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.']);
    }

    public function respondent_delete(Request $request) {

        $respondent = AffidavitRespondent::findOrFail($request->respondent_id);

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 6;
        $log->description = "Padam Afidavit - Responden";
        $log->data_old = json_encode($respondent);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $respondent->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_index(Request $request) {

        $affidavit = Affidavit::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Affidavit - Dokumen Sokongan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attachments = [];

        foreach($affidavit->attachments as $attachment) {
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
                'affidavit',
                $request->file('file'),
                uniqid().'_'.$request->file('file')->getClientOriginalName()
            );

            $affidavit = Affidavit::findOrFail($request->id);

            $attachment = $affidavit->attachments()->create([
                'name' => $request->file('file')->getClientOriginalName(),
                'url' => $path,
                'created_by_user_id' => auth()->id()
            ]);

            $log = new LogSystem;
            $log->module_id = 33;
            $log->activity_type_id = 4;
            $log->description = "Tambah Affidavit - Dokumen Sokongan";
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
        $log->module_id = 33;
        $log->activity_type_id = 6;
        $log->description = "Padam Affidavit - Dokumen Sokongan";
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
     * Show the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function report_attachment_index(Request $request) {

        $affidavit = Affidavit::findOrFail($request->id);
        
        abort_unless($affidavit->report,404);

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai (Laporan) Affidavit - Dokumen Sokongan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attachments = [];

        foreach($affidavit->report->attachments as $attachment) {
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
    public function report_attachment_insert(Request $request) {
        if($request->file('file')->isValid()) {
            $path = Storage::disk('uploads')->putFileAs(
                'affidavit',
                $request->file('file'),
                uniqid().'_'.$request->file('file')->getClientOriginalName()
            );

            $affidavit = Affidavit::findOrFail($request->id);

            $attachment = $affidavit->report->attachments()->create([
                'name' => $request->file('file')->getClientOriginalName(),
                'url' => $path,
                'created_by_user_id' => auth()->id()
            ]);

            $log = new LogSystem;
            $log->module_id = 33;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Laporan) Affidavit - Dokumen Sokongan";
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
    public function report_attachment_delete(Request $request) {
        $attachment = Attachment::findOrFail($request->attachment_id);

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 6;
        $log->description = "Padam (Laporan) Affidavit - Dokumen Sokongan";
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

    // Respondent CRUD END

    private function getErrors($affidavit) {

        $errors = [];

        $validate_affidavit = Validator::make($affidavit->toArray(), [
        ]);

        if ($validate_affidavit->fails())
            $errors = array_merge($errors, $validate_affidavit->errors()->toArray());

        $errors = ['affidavit' => $errors];

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $affidavit = Affidavit::findOrFail($request->id);

        $errors = ($this->getErrors($affidavit))['affidavit'];

        //return response()->json(['errors' => $errors], 422);

        if(count($errors) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 33;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Affidavit - Daftar Kes";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $affidavit = Affidavit::findOrFail($request->id);
            $affidavit->filing_status_id = 3;
            $affidavit->is_editable = 0;
            $affidavit->save();

            $affidavit->logs()->updateOrCreate(
                [
                    'module_id' => 33,
                    'activity_type_id' => 11,
                    'filing_status_id' => $affidavit->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            if($affidavit->logs->count() == 1)
                $this->distribute($affidavit, 'pphq');

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Kes telah didaftarkan.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($affidavit, $target) {

        $check = $affidavit->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "pphq") {
            if($affidavit->distributions()->where('filing_status_id', 3)->count() > 1)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Affidavit')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $affidavit->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $affidavit->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($affidavit, 'Serahan Permohonan Semakan Kehakiman'));
        }
        else if($target == "pkpp") {
            if($affidavit->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $affidavit->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $affidavit->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new SentPKPP($affidavit, 'Serahan Permohonan Semakan Kehakiman'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $affidavit = Affidavit::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Affidavit - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('affidavit.process.query.item', $affidavit->id);
        $route2 = route('affidavit.process.query', $affidavit->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $affidavit = Affidavit::findOrFail($request->id);

        if(count($affidavit->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Affidavit - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $affidavit->filing_status_id = 5;
        $affidavit->is_editable = 1;
        $affidavit->save();

        $log2 = $affidavit->logs()->updateOrCreate(
            [
                'module_id' => 33,
                'activity_type_id' => 13,
                'filing_status_id' => $affidavit->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pkpg')) {
            // Send to PPKPG
            $log = $affidavit->logs()->where('role_id', 13)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $affidavit, 'Kuiri Permohonan Affidavit oleh PKPG'));
        } else {
            // Send to KS
            Mail::to($affidavit->created_by->email)->send(new Queried(auth()->user(), $affidavit, 'Kuiri Permohonan Affidavit'));
        }

        $affidavit->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

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
            $log->module_id = 33;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Affidavit - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $affidavit = Affidavit::findOrFail($request->id);

            $queries = $affidavit->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

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

        $affidavit = Affidavit::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 33;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Affidavit - Kuiri";
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
            $query = $affidavit->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 33;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Affidavit - Kuiri";
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
        $log->module_id = 33;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Affidavit - Kuiri";
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
    public function process_status_edit(Request $request) {

        $affidavit = Affidavit::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Affidavit - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('affidavit.process.status', $affidavit->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 33;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Affidavit - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $affidavit = Affidavit::findOrFail($request->id);
        $affidavit->is_editable = 0;
        $affidavit->save();

        $log = $affidavit->logs()->create([
                'module_id' => 33,
                'activity_type_id' => 20,
                'filing_status_id' => 10,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id,
                'data' => $request->status_data,
        ]);
        
        $log->created_at = Carbon::createFromFormat('d/m/Y', $request->status_date)->toDateTimeString();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    public function download(Request $request) {

        $filing = Affidavit::findOrFail($request->id);   
                                                           // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'applicant_name_uppercase' => htmlspecialchars(strtoupper($filing->applicant)),
            'judicial_no' => htmlspecialchars($filing->report->judicial_no),
            'today_date' => htmlspecialchars(strftime('%e %B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 33;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/affidavit/report.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate list
        $respondents = $filing->respondents;

        $document->cloneBlockString('list', count($respondents));

        foreach($respondents as $index => $respondent){
            $content = preg_replace('~\R~u', '<w:br/>', $respondent->respondent);
            $document->setValue('respondent_name', strtoupper($content), 1);
        }

        // Generate list
        $report_data = $filing->report_data;

        $document->cloneBlockString('list1', count($report_data));

        foreach($report_data as $index => $report){
            $content = preg_replace('~\R~u', '<w:br/>', $report->data);
            $document->setValue('report', strtoupper($content), 1);
        }
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Laporan Affidavit';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
