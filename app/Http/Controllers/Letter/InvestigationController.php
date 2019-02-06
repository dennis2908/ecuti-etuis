<?php

namespace App\Http\Controllers\Letter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogModel\LogSystem;
use App\OtherModel\Letter;
use Storage;

use App\Custom\PhpWord;

class InvestigationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function appoint_po(Request $request) {

        $letter = Letter::findOrFail($request->id);
        $data_db = $letter->data ? json_decode($letter->data, true) : [];
        $data_uppercase = [];
        $data = [];

        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        foreach($data_db as $key => $value) {
            $data[$key] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars($value));
            $data_uppercase[$key."_uppercase"] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars(strtoupper($value)));
        }

        ///////////////////////////////////////// CHANGE HERE ONLY /////////////////////////////////////////////////////

        $data = array_merge($data, $data_uppercase);
        $data = array_merge($data, [
            'reference_no' => $letter->reference ? htmlspecialchars($letter->reference->reference_no) : '',
            'entity_name' => htmlspecialchars($letter->entity->name),
            'entity_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->name)),
            'address' => htmlspecialchars($letter->entity->addresses->last()->address->address1).
                ($letter->entity->addresses->last()->address->address2 ? ',<w:br/>'.htmlspecialchars($letter->entity->addresses->last()->address->address2) : '').
                ($letter->entity->addresses->last()->address->address3 ? ',<w:br/>'.htmlspecialchars($letter->entity->addresses->last()->address->address3) : ''),
            'postcode' => htmlspecialchars($letter->entity->addresses->last()->address->postcode),
            'district' => $letter->entity->addresses->last()->address->district ? htmlspecialchars($letter->entity->addresses->last()->address->district->name) : '',
            'state' => $letter->entity->addresses->last()->address->state ? htmlspecialchars($letter->entity->addresses->last()->address->state->name) : '',
            'province_office_name' => htmlspecialchars($letter->entity->province_office->name),
            'tagline' => htmlspecialchars(strtoupper(env('JHEKS_TAGLINE', 'BERKHIDMAT UNTUK NEGARA'))),
            'slogan' => htmlspecialchars(env('JHEKS_SLOGAN', 'Pekerja Berkemahiran Penggerak Ekonomi')),
            'pw_name' => htmlspecialchars(strtoupper($letter->entity->province_office->pw->name)),
            // '' => htmlspecialchars(),
        ]);

        $data = array_merge($data, [
            'jheks_location' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? htmlspecialchars(str_replace('JABATAN HAL EHWAL KESATUAN SEKERJA ','',strtoupper(auth()->user()->entity->province_office->name))).'<w:br/>' : '',
            'jheks_address' => htmlspecialchars(auth()->user()->entity->province_office->address->address1).
                (auth()->user()->entity->province_office->address->address2 ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->address2) : '').
                (auth()->user()->entity->province_office->address->address3 ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->address3) : '').
                ', '.(auth()->user()->entity->province_office->address->postcode).
                (auth()->user()->entity->province_office->address->district ? ' '.htmlspecialchars(auth()->user()->entity->province_office->address->district->name) : '').
                (auth()->user()->entity->province_office->address->state ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->state->name) : ''),
            'jheks_phone' => htmlspecialchars(explode('/',auth()->user()->entity->province_office->phone)[0]),
            'jheks_fax' => htmlspecialchars(auth()->user()->entity->province_office->fax),
            'jheks_email' => htmlspecialchars(auth()->user()->entity->province_office->email),
            'jheks_website' => htmlspecialchars('https://jheks.mohr.gov.my'),
        ]);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 18;
        $log->description = "Cetak Surat";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $template = str_replace('.', '/', $letter->type->template_name);
        $document = $phpWord->loadTemplate(storage_path('templates/letters/'.$template.'.docx'));

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.$letter->type->name;
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        if ($request->format == "pdf") {
            return docxToPdf($temp_file);
        }
        else
            return response()->download($temp_file)->deleteFileAfterSend(true);
    }

    public function appoint_io(Request $request) {

        $letter = Letter::findOrFail($request->id);
        $data_db = $letter->data ? json_decode($letter->data, true) : [];
        $data_uppercase = [];
        $data = [];

        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        foreach($data_db as $key => $value) {
            $data[$key] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars($value));
            $data_uppercase[$key."_uppercase"] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars(strtoupper($value)));
        }

        ///////////////////////////////////////// CHANGE HERE ONLY /////////////////////////////////////////////////////

        $data = array_merge($data, $data_uppercase);
        $data = array_merge($data, [
            'reference_no' => $letter->reference ? htmlspecialchars($letter->reference->reference_no) : '',
            'entity_name' => htmlspecialchars($letter->entity->name),
            'entity_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->name)),
            'province_office_name' => htmlspecialchars($letter->entity->province_office->name),
            'tagline' => htmlspecialchars(strtoupper(env('JHEKS_TAGLINE', 'BERKHIDMAT UNTUK NEGARA'))),
            'slogan' => htmlspecialchars(env('JHEKS_SLOGAN', 'Pekerja Berkemahiran Penggerak Ekonomi')),
            'pw_name' => htmlspecialchars(strtoupper($letter->entity->province_office->pw->name)),
            // '' => htmlspecialchars(),
        ]);

        $data = array_merge($data, [
            'jheks_location' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? htmlspecialchars(str_replace('JABATAN HAL EHWAL KESATUAN SEKERJA ','',strtoupper(auth()->user()->entity->province_office->name))).'<w:br/>' : '',
            'jheks_address' => htmlspecialchars(auth()->user()->entity->province_office->address->address1).
                (auth()->user()->entity->province_office->address->address2 ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->address2) : '').
                (auth()->user()->entity->province_office->address->address3 ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->address3) : '').
                ', '.(auth()->user()->entity->province_office->address->postcode).
                (auth()->user()->entity->province_office->address->district ? ' '.htmlspecialchars(auth()->user()->entity->province_office->address->district->name) : '').
                (auth()->user()->entity->province_office->address->state ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->state->name) : ''),
            'jheks_phone' => htmlspecialchars(explode('/',auth()->user()->entity->province_office->phone)[0]),
            'jheks_fax' => htmlspecialchars(auth()->user()->entity->province_office->fax),
            'jheks_email' => htmlspecialchars(auth()->user()->entity->province_office->email),
            'jheks_website' => htmlspecialchars('https://jheks.mohr.gov.my'),
        ]);
        
        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 18;
        $log->description = "Cetak Surat";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $template = str_replace('.', '/', $letter->type->template_name);
        $document = $phpWord->loadTemplate(storage_path('templates/letters/'.$template.'.docx'));

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.$letter->type->name;
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        if ($request->format == "pdf") {
            return docxToPdf($temp_file);
        }
        else
            return response()->download($temp_file)->deleteFileAfterSend(true);
    }

    public function memo_case(Request $request) {

        $letter = Letter::findOrFail($request->id);
        $data_db = $letter->data ? json_decode($letter->data, true) : [];
        $data_uppercase = [];
        $data = [];

        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        foreach($data_db as $key => $value) {
            $data[$key] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars($value));
            $data_uppercase[$key."_uppercase"] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars(strtoupper($value)));
        }

        ///////////////////////////////////////// CHANGE HERE ONLY /////////////////////////////////////////////////////
        $respondents = $letter->filing->pd13->accused()->get();
        $accused = '';
        foreach ($respondents as $key => $respondent) {
            $accused .= $respondent->accused.',';
        }
        $data = array_merge($data, $data_uppercase);
        $data = array_merge($data, [
            'reference_no' => $letter->reference ? htmlspecialchars($letter->reference->reference_no) : '',
            'entity_name' => htmlspecialchars($letter->entity->name),
            'entity_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->name)),
            'applicant_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->name)),
            'respondents_name_uppercase' => htmlspecialchars(strtoupper($accused)),
            'tagline' => htmlspecialchars(strtoupper(env('JHEKS_TAGLINE', 'BERKHIDMAT UNTUK NEGARA'))),
            'slogan' => htmlspecialchars(env('JHEKS_SLOGAN', 'Pekerja Berkemahiran Penggerak Ekonomi')),
            'kpks_name' => htmlspecialchars(strtoupper($letter->entity->province_office->kpks->name)),
            // '' => htmlspecialchars(),
        ]);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 18;
        $log->description = "Cetak Surat";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $template = str_replace('.', '/', $letter->type->template_name);
        $document = $phpWord->loadTemplate(storage_path('templates/letters/'.$template.'.docx'));

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.$letter->type->name;
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        if ($request->format == "pdf") {
            return docxToPdf($temp_file);
        }
        else
            return response()->download($temp_file)->deleteFileAfterSend(true);
    }

    public function memo_puu(Request $request) {

        $letter = Letter::findOrFail($request->id);
        $data_db = $letter->data ? json_decode($letter->data, true) : [];
        $data_uppercase = [];
        $data = [];

        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        foreach($data_db as $key => $value) {
            $data[$key] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars($value));
            $data_uppercase[$key."_uppercase"] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars(strtoupper($value)));
        }

        ///////////////////////////////////////// CHANGE HERE ONLY /////////////////////////////////////////////////////

        $data = array_merge($data, $data_uppercase);
        $data = array_merge($data, [
            'reference_no' => $letter->reference ? htmlspecialchars($letter->reference->reference_no) : '',
            'entity_name' => htmlspecialchars($letter->filing->subject),
            'entity_name_uppercase' => htmlspecialchars(strtoupper($letter->filing->subject)),
            'tagline' => htmlspecialchars(strtoupper(env('JHEKS_TAGLINE', 'BERKHIDMAT UNTUK NEGARA'))),
            'slogan' => htmlspecialchars(env('JHEKS_SLOGAN', 'Pekerja Berkemahiran Penggerak Ekonomi')),
            'kpks_name' => htmlspecialchars(strtoupper($letter->entity->province_office->kpks->name)),
            // '' => htmlspecialchars(),
        ]);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 18;
        $log->description = "Cetak Surat";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $template = str_replace('.', '/', $letter->type->template_name);
        $document = $phpWord->loadTemplate(storage_path('templates/letters/'.$template.'.docx'));

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.$letter->type->name;
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        if ($request->format == "pdf") {
            return docxToPdf($temp_file);
        }
        else
            return response()->download($temp_file)->deleteFileAfterSend(true);
    }

    public function warrant(Request $request) {

        $letter = Letter::findOrFail($request->id);
        $data_db = $letter->data ? json_decode($letter->data, true) : [];
        $data_uppercase = [];
        $data = [];

        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        foreach($data_db as $key => $value) {
            $data[$key] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars($value));
            $data_uppercase[$key."_uppercase"] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars(strtoupper($value)));
        }

        ///////////////////////////////////////// CHANGE HERE ONLY /////////////////////////////////////////////////////

        $data = array_merge($data, $data_uppercase);
        $data = array_merge($data, [
            'reference_no' => $letter->reference ? htmlspecialchars($letter->reference->reference_no) : '',
            'entity_name' => htmlspecialchars($letter->entity->name),
            'entity_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->name)),
            'tagline' => htmlspecialchars(strtoupper(env('JHEKS_TAGLINE', 'BERKHIDMAT UNTUK NEGARA'))),
            'slogan' => htmlspecialchars(env('JHEKS_SLOGAN', 'Pekerja Berkemahiran Penggerak Ekonomi')),
            // '' => htmlspecialchars(),
        ]);

        $data = array_merge($data, [
            'jheks_location' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? htmlspecialchars(str_replace('JABATAN HAL EHWAL KESATUAN SEKERJA ','',strtoupper(auth()->user()->entity->province_office->name))).'<w:br/>' : '',
            'jheks_address' => htmlspecialchars(auth()->user()->entity->province_office->address->address1).
                (auth()->user()->entity->province_office->address->address2 ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->address2) : '').
                (auth()->user()->entity->province_office->address->address3 ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->address3) : '').
                ', '.(auth()->user()->entity->province_office->address->postcode).
                (auth()->user()->entity->province_office->address->district ? ' '.htmlspecialchars(auth()->user()->entity->province_office->address->district->name) : '').
                (auth()->user()->entity->province_office->address->state ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->state->name) : ''),
            'jheks_phone' => htmlspecialchars(explode('/',auth()->user()->entity->province_office->phone)[0]),
            'jheks_fax' => htmlspecialchars(auth()->user()->entity->province_office->fax),
            'jheks_email' => htmlspecialchars(auth()->user()->entity->province_office->email),
            'jheks_website' => htmlspecialchars('https://jheks.mohr.gov.my'),
        ]);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 18;
        $log->description = "Cetak Surat";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $template = str_replace('.', '/', $letter->type->template_name);
        $document = $phpWord->loadTemplate(storage_path('templates/letters/'.$template.'.docx'));

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.$letter->type->name;
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        if ($request->format == "pdf") {
            return docxToPdf($temp_file);
        }
        else
            return response()->download($temp_file)->deleteFileAfterSend(true);
    }

    public function warrant_application(Request $request) {

        $letter = Letter::findOrFail($request->id);
        $data_db = $letter->data ? json_decode($letter->data, true) : [];
        $data_uppercase = [];
        $data = [];

        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        foreach($data_db as $key => $value) {
            $data[$key] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars($value));
            $data_uppercase[$key."_uppercase"] = preg_replace('~\R~u', '<w:br/>', htmlspecialchars(strtoupper($value)));
        }

        ///////////////////////////////////////// CHANGE HERE ONLY /////////////////////////////////////////////////////

        $data = array_merge($data, $data_uppercase);
        $data = array_merge($data, [
            'reference_no' => $letter->reference ? htmlspecialchars($letter->reference->reference_no) : '',
            'entity_name' => htmlspecialchars($letter->entity->name),
            'entity_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->name)),
            'province_office_name' => htmlspecialchars($letter->entity->province_office->name),
            'tagline' => htmlspecialchars(strtoupper(env('JHEKS_TAGLINE', 'BERKHIDMAT UNTUK NEGARA'))),
            'slogan' => htmlspecialchars(env('JHEKS_SLOGAN', 'Pekerja Berkemahiran Penggerak Ekonomi')),
            // '' => htmlspecialchars(),
        ]);

        $data = array_merge($data, [
            'jheks_location' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? htmlspecialchars(str_replace('JABATAN HAL EHWAL KESATUAN SEKERJA ','',strtoupper(auth()->user()->entity->province_office->name))).'<w:br/>' : '',
            'jheks_address' => htmlspecialchars(auth()->user()->entity->province_office->address->address1).
                (auth()->user()->entity->province_office->address->address2 ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->address2) : '').
                (auth()->user()->entity->province_office->address->address3 ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->address3) : '').
                ', '.(auth()->user()->entity->province_office->address->postcode).
                (auth()->user()->entity->province_office->address->district ? ' '.htmlspecialchars(auth()->user()->entity->province_office->address->district->name) : '').
                (auth()->user()->entity->province_office->address->state ? ', '.htmlspecialchars(auth()->user()->entity->province_office->address->state->name) : ''),
            'jheks_phone' => htmlspecialchars(explode('/',auth()->user()->entity->province_office->phone)[0]),
            'jheks_fax' => htmlspecialchars(auth()->user()->entity->province_office->fax),
            'jheks_email' => htmlspecialchars(auth()->user()->entity->province_office->email),
            'jheks_website' => htmlspecialchars('https://jheks.mohr.gov.my'),
        ]);

        $log = new LogSystem;
        $log->module_id = 30;
        $log->activity_type_id = 18;
        $log->description = "Cetak Surat";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $template = str_replace('.', '/', $letter->type->template_name);
        $document = $phpWord->loadTemplate(storage_path('templates/letters/'.$template.'.docx'));

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate list
        $suspicions = htmlspecialchars($data['suspicions']);
        $suspicions = array_filter(preg_split('~\R~u', $suspicions));

        $document->cloneBlockString('list', count($suspicions));
        $index = 8;

        foreach($suspicions as $suspicion){
            $content = preg_replace('~\R~u', '<w:br/>', $suspicion);
            $document->setValue('no', $index++, 1);
            $document->setValue('suspicion', preg_replace('/^\s*[0-9ivx]+\s*[\)|\-\.]+\s*/', '', $content), 1);
        }

        // Generate table
        $rows = $data['officer_names'];
        $document->cloneRow('officer_name', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('officer_name#'.($index+1), $data['officer_names'][$index]);
            $document->setValue('officer_ic#'.($index+1), $data['officer_ics'][$index]);
            $document->setValue('officer_designation#'.($index+1), $data['officer_designations'][$index]);
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.$letter->type->name;
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        if ($request->format == "pdf") {
            return docxToPdf($temp_file);
        }
        else
            return response()->download($temp_file)->deleteFileAfterSend(true);
    }

}
