<?php

namespace App\Http\Controllers\Letter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogModel\LogSystem;
use App\OtherModel\Letter;
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

    public function approve(Request $request) {
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
            'registration_no' =>  htmlspecialchars($letter->entity->registration_no),
            'filing_applied_at' => htmlspecialchars(strftime('%e %B %Y' , strtotime($letter->filing->applied_at))),
            'constitution_reference_no' => htmlspecialchars($letter->entity->constitutions()->where('filing_status_id', 9)->first()->reference->reference_no),
            'province_office_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->province_office->name)),
            'today_day' => htmlspecialchars(strftime("%e")),
            'today_month_year' => htmlspecialchars(strftime("%B %Y")),
            'tagline' => htmlspecialchars(strtoupper(env('JHEKS_TAGLINE', 'BERKHIDMAT UNTUK NEGARA'))),
            'slogan' => htmlspecialchars(env('JHEKS_SLOGAN', 'Pekerja Berkemahiran Penggerak Ekonomi')),
            'kpks_name' => htmlspecialchars(strtoupper($letter->entity->province_office->kpks->name)),
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
        $log->module_id = 18;
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

    public function disapprove(Request $request) {
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
            'registration_no' =>  htmlspecialchars($letter->entity->registration_no),
            'filing_applied_at' => htmlspecialchars(strftime('%e %B %Y' , strtotime($letter->filing->applied_at))),
            'constitution_reference_no' => htmlspecialchars($letter->entity->constitutions()->where('filing_status_id', 9)->first()->reference->reference_no),
            'province_office_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->province_office->name)),
            'today_day' => htmlspecialchars(strftime("%e")),
            'today_month_year' => htmlspecialchars(strftime("%B %Y")),
            'tagline' => htmlspecialchars(strtoupper(env('JHEKS_TAGLINE', 'BERKHIDMAT UNTUK NEGARA'))),
            'slogan' => htmlspecialchars(env('JHEKS_SLOGAN', 'Pekerja Berkemahiran Penggerak Ekonomi')),
            'kpks_name' => htmlspecialchars(strtoupper($letter->entity->province_office->kpks->name)),
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
        $log->module_id = 18;
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
        $reasons = htmlspecialchars($letter->filing->logs()->where('activity_type_id', 16)->first()->data);
        $reasons = array_filter(preg_split('~\R~u', $reasons));

        $document->cloneBlockString('list', count($reasons));

        foreach($reasons as $reason){
            $content = preg_replace('~\R~u', '<w:br/>', $reason);
            $document->setValue('reason', preg_replace('/^\s*[0-9ivx]+\s*[\)|\-\.]+\s*/', '', $content), 1);
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

    public function approve_disapprove(Request $request) {
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
            'registration_no' =>  htmlspecialchars($letter->entity->registration_no),
            'filing_applied_at' => htmlspecialchars(strftime('%e %B %Y' , strtotime($letter->filing->applied_at))),
            'constitution_reference_no' => htmlspecialchars($letter->entity->constitutions()->where('filing_status_id', 9)->first()->reference->reference_no),
            'province_office_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->province_office->name)),
            'today_day' => htmlspecialchars(strftime("%e")),
            'today_month_year' => htmlspecialchars(strftime("%B %Y")),
            'tagline' => htmlspecialchars(strtoupper(env('JHEKS_TAGLINE', 'BERKHIDMAT UNTUK NEGARA'))),
            'slogan' => htmlspecialchars(env('JHEKS_SLOGAN', 'Pekerja Berkemahiran Penggerak Ekonomi')),
            'kpks_name' => htmlspecialchars(strtoupper($letter->entity->province_office->kpks->name)),
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
        $log->module_id = 18;
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
        $changes = $letter->filing->constitution->changes;

        $document->cloneBlockString('list', count($changes));

        foreach($changes as $change){

            preg_match_all('/peraturan\s*(?<rule_no>\d+)\s*(?<rule_name>.+)/im', $change->item->content, $rule);

            if($change->is_approve) {
                $document->setValue('rule_no', htmlspecialchars(reset($rule['rule_no'])), 1);
                $document->setValue('rule_name', htmlspecialchars(reset($rule['rule_name'])), 1);
                $document->setValue('result', 'DILULUSKAN', 1);
                $document->setValue('and', ' dan ', 1);
                $document->setValue('result2', 'DIDAFTARKAN', 1);
                $document->setValue('reason', '', 1);
            }
            else {
                $justification = preg_replace('~\R~u', '<w:br/>', htmlspecialchars($change->justification));

                $document->setValue('rule_no', htmlspecialchars(reset($rule['rule_no'])), 1);
                $document->setValue('rule_name', htmlspecialchars(reset($rule['rule_name'])), 1);
                $document->setValue('result', 'TIDAK DILULUSKAN', 1);
                $document->setValue('and', ' kerana ', 1);
                $document->setValue('result2', '', 1);
                $document->setValue('reason', $justification, 1);
            }

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

    public function constitution_complete(Request $request) {
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
            'entity_new_name_uppercase' => htmlspecialchars(strtoupper($letter->filing->name)),
            'address' => htmlspecialchars($letter->entity->addresses->last()->address->address1).
                ($letter->entity->addresses->last()->address->address2 ? ',<w:br/>'.htmlspecialchars($letter->entity->addresses->last()->address->address2) : '').
                ($letter->entity->addresses->last()->address->address3 ? ',<w:br/>'.htmlspecialchars($letter->entity->addresses->last()->address->address3) : ''),
            'postcode' => htmlspecialchars($letter->entity->addresses->last()->address->postcode),
            'district' => $letter->entity->addresses->last()->address->district ? htmlspecialchars($letter->entity->addresses->last()->address->district->name) : '',
            'state' => $letter->entity->addresses->last()->address->state ? htmlspecialchars($letter->entity->addresses->last()->address->state->name) : '',
            'province_office_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->province_office->name)),
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
        $log->module_id = 18;
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

    public function constitution_incomplete(Request $request) {
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
            'province_office_name_uppercase' => htmlspecialchars(strtoupper($letter->entity->province_office->name)),
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
        $log->module_id = 18;
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
        $reasons = htmlspecialchars($letter->filing->logs()->where('activity_type_id', 16)->first()->data);
        $reasons = array_filter(preg_split('~\R~u', $reasons));

        $document->cloneBlockString('list', count($reasons));

        foreach($reasons as $reason){
            $content = preg_replace('~\R~u', '<w:br/>', $reason);
            $document->setValue('reason', preg_replace('/^\s*[0-9ivx]+\s*[\)|\-\.]+\s*/', '', $content), 1);
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

    public function constitution_list(Request $request) {
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
            'registration_no' =>  htmlspecialchars($letter->entity->registration_no),
            'kpks_name' => htmlspecialchars(strtoupper($letter->entity->province_office->kpks->name)),
            // '' => htmlspecialchars(),
        ]);

        $log = new LogSystem;
        $log->module_id = 18;
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

        // Generate table
        $rows = $letter->filing->constitution->changes;
        $document->cloneRow('no', count($rows));

        foreach($rows as $index => $row) {
            preg_match_all('/peraturan\s*(?<rule_no>\d+)\s*(?<rule_name>.+)/im', $row->item->content, $rule);

            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('change#'.($index+1), '');
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
