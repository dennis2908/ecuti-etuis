<?php

namespace App\Http\Controllers\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FilingModel\FormO;
use App\OtherModel\Address;
use App\MasterModel\MasterState;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterMeetingType;
use App\LogModel\LogSystem;
use App\UserUnion;
use Validator;
use PDF;
use Storage;
use App\Custom\PhpWord;

class FormOController extends Controller
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
        $unions = UserUnion::all();

        // $address = auth()->user()->entity->addresses->last()->address->replicate();
        // $address->save();
        $formo = FormO::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'user_union_id' => auth()->user()->entity->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
        ]);

        $log = new LogSystem;
        $log->module_id = 8;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan Borang O - Notis";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('registration.formo.index', compact('formo','states','meeting_types','unions'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $formo = FormO::findOrFail($request->id);

        $states = MasterState::all();
        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();
        $unions = UserUnion::all();

        $log = new LogSystem;
        $log->module_id = 8;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan (Kemaskini) Borang O - Notis";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('registration.formo.index', compact('formo','states','meeting_types','unions'));
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 8;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang O";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formo = FormO::with(['union','status']);

            if(auth()->user()->hasRole('ks')) {
                 $formo = $formo->where('user_union_id', auth()->user()->entity->id);
            }
            else {
                $formo = $formo->groupBy('federation_name')->where('filing_status_id', '>', 1);
            }

            return datatables()->of($formo)
                 ->editColumn('resolved_at', function ($formo) {
                    return $formo->resolved_at ? date('d/m/Y', strtotime($formo->resolved_at)) : '-';
                })
                ->editColumn('status.name', function ($formo) {
                    return '<span class="badge badge-default">'.$formo->status->name.'</span>';
                })
                ->editColumn('letter', function($formo) {
                    if($formo->filing_status_id > 1 )
                        return '<a href="'.route('download.formo', $formo->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i>'.($formo->logs->count() > 0 ? date('d/m/Y', strtotime($formo->logs->first()->created_at)).' - ' : '').$formo->union->name.'</a><br>';
                })
                ->editColumn('action', function ($formo) {
                    $button = "";
                    // $button .= '<a onclick="viewFiling(\''.addslashes(get_class($formo)).'\','.$formo->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if(auth()->user()->hasAnyRole(['ks','ppw','pphq']) && $formo->is_editable)
                        $button .= '<a href="'.route('formo.form', $formo->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';
                    else if(!$formo->is_editable)
                        $button .= '<a href="'.route('download.formo', ['id' => $formo->id]).'" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang O</a><br>';

                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 8;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang O";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }
        return view('registration.formo.list');
    }

    private function getErrors($formo_id) {

        $formo = FormO::findOrFail($formo_id);

        $errors = [];

        $validate_formo = Validator::make($formo->toArray(), [
            'federation_name' => 'required|string',
            'resolved_at' => 'required',
            'meeting_type_id' => 'required|integer',
        ]);

        if ($validate_formo->fails())
            $errors = array_merge($errors, $validate_formo->errors()->toArray());

        $errors = ['o' => $errors];

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $errors = ($this->getErrors($request->id))['o'];

        //return response()->json(['errors' => $errors], 422);

        if(count($errors) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);
        else {
            $log = new LogSystem;
            $log->module_id = 8;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Borang O - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formo = FormO::findOrFail($request->id);
            $formo->filing_status_id = 2;
            $formo->is_editable = 0;
            $formo->save();

            $formo->logs()->updateOrCreate(
                [
                    'module_id' => 8,
                    'activity_type_id' => 11,
                    'filing_status_id' => $formo->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $formo->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 8,
            ]);

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar.']);
        }
    }

    public function pdf(Request $request) {
        $formo = FormO::findOrFail($request->id);
        $data = [
            'formo' => $formo,
        ];

        $pdf = PDF::loadView('pdf.formo.formo', $data);
        return $pdf->setPaper('A4')->setOrientation('portrait')->download('formo.pdf');
    }

    public function download(Request $request) {

        $filing = FormO::findOrFail($request->id);                                                      // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->union->name),
            'entity_address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ', '.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars($filing->address->address3) : '').
                ', '.($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars($filing->address->district->name) : '').
                ($filing->address->state ? ', '.htmlspecialchars($filing->address->state->name) : ''),
            'registration_no' => htmlspecialchars($filing->union->registration_no),
            'federation_name' => htmlspecialchars($filing->federation_name),
            'meeting_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'resolved_at' => htmlspecialchars(strftime('%e %B %Y', strtotime($filing->resolved_at))),
            'today_day' => htmlspecialchars(strftime('%e')),
            'today_month_year' =>  htmlspecialchars(strftime('%B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 8;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/formbb/formo.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate list
        $unions = $filing->unions;

        $document->cloneBlockString('list', count($unions));

        foreach($unions as $index => $union){
            $content = preg_replace('~\R~u', '<w:br/>', $union->union->name);
            $document->setValue('union_name', strtoupper($content), 1);
        }
        
        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang O';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }

}
