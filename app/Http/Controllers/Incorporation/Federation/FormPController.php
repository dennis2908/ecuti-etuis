<?php

namespace App\Http\Controllers\Incorporation\Federation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FilingModel\FormP;
use App\FilingModel\FormPQ;
use App\OtherModel\Address;
use App\MasterModel\MasterMeetingType;
use App\UserFederation;
use App\LogModel\LogSystem;
use Validation;
use Carbon\Carbon;
use Storage;
use App\Custom\PhpWord;

class FormPController extends Controller
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

        $federations = UserFederation::all();
        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();

        $formp = FormP::updateOrCreate([
                'formpq_id' => $request->id,
            ],[
                'address_id' => auth()->user()->entity->addresses->last()->address->id,
                'secretary_user_id' => auth()->id(),
                'created_by_user_id' => auth()->id(),
                'applied_at' => Carbon::now(),
            ]
        );
        
        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang P";
        $log->data_new = json_encode($formp);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('incorporation.federation.formp.index', compact('formp','federations','meeting_types'));
    }

    public function download(Request $request) {

        $filing = FormPQ::findOrFail($request->id);                                                      // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->tenure->entity->name),
            'entity_address' => htmlspecialchars($filing->formp->address->address1).
                ($filing->formp->address->address2 ? ', '.htmlspecialchars($filing->formp->address->address2) : '').
                ($filing->formp->address->address3 ? ', '.htmlspecialchars($filing->formp->address->address3) : '').
                ', '.($filing->formp->address->postcode).
                ($filing->formp->address->district ? ' '.htmlspecialchars($filing->formp->address->district->name) : '').
                ($filing->formp->address->state ? ', '.htmlspecialchars($filing->formp->address->state->name) : ''),
            'registration_no' => htmlspecialchars($filing->tenure->entity->registration_no),
            'federation_name' => htmlspecialchars($filing->formp->federation->name),
            'meeting_type' => $filing->formp->meeting_type ? htmlspecialchars($filing->formp->meeting_type->name) : '',
            'resolved_at' => htmlspecialchars(strftime('%e %B %Y', strtotime($filing->formp->resolved_at))),
            'today_day' => htmlspecialchars(strftime('%e')),
            'today_month_year' =>  htmlspecialchars(strftime('%B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 11;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/formpq/formp.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang P';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
