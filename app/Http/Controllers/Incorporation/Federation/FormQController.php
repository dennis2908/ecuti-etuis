<?php

namespace App\Http\Controllers\Incorporation\Federation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FilingModel\FormPQ;
use App\FilingModel\FormQ;
use App\FilingModel\FormQMember;
use App\OtherModel\Address;
use App\MasterModel\MasterMeetingType;
use App\UserFederation;
use App\LogModel\LogSystem;
use Validator;
use Carbon\Carbon;
use Storage;
use App\Custom\PhpWord;

class FormQController extends Controller
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
    
        $formq = FormQ::updateOrCreate([
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
        $log->description = "Tambah Borang Q";
        $log->data_new = json_encode($formq);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('incorporation.federation.formq.index', compact('formq','federations', 'meeting_types'));
    }

    //Requester CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function member_index(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 11;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang Q - Anggota";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $formpq = FormPQ::findOrFail($request->id);
            $members = $formpq->formq->members;

            while($members->count() < 7)
                $members->push(new FormQMember(['name' => '']));

            return datatables()->of($members)
            ->editColumn('action', function ($member) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                
                if(!$member->id)
                    $button .= '<a onclick="add()" href="javascript:;" class="btn btn-primary btn-xs "><i class="fa fa-edit"></i></a> ';
                else {
                    $button .= '<a onclick="edit('.$member->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="remove('.$member->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';
                }

                return $button;
            })
            ->make(true);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function member_insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:formq_member',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $formpq = FormPQ::findOrFail($request->id);

        $request->request->add(['formq_id' => $formpq->formq->id]);
        $member = FormQMember::create($request->all());

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang Q - Anggota";
        $log->data_new = json_encode($member);
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
    public function member_edit(Request $request) {
        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang Q - Anggota";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $member = FormQMember::findOrFail($request->member_id);

        return view('incorporation.federation.formq.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function member_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:formq_member,name,'.$request->member_id,
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $member = FormQMember::findOrFail($request->member_id);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang Q - Anggota";
        $log->data_old = json_encode($member);

        
        $member = $member->update($request->all());

        $log->data_new = json_encode($member);
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
    public function member_delete(Request $request) {

        $member = FormQMember::findOrFail($request->member_id);

        $log = new LogSystem;
        $log->module_id = 11;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang Q - Anggota";
        $log->data_old = json_encode($member);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $member->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
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
            'federation_registration_no' => htmlspecialchars($filing->formp->federation->registration_no),
            'meeting_type' => $filing->formp->meeting_type ? htmlspecialchars($filing->formp->meeting_type->name) : '',
            'resolved_at' => htmlspecialchars(strftime('%e %B %Y', strtotime($filing->formp->resolved_at))),
            'secretary_name' => htmlspecialchars($filing->tenure->entity->user->name),
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/formpq/formq.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

         // Generate list
        $rows = $filing->formq->members;
        $document->cloneRow('no', count($rows));

        foreach($rows as $index => $row) {
            $document->setValue('no#'.($index+1), $index+2);
            $document->setValue('member_name#'.($index+1), htmlspecialchars(strtoupper($row->name)));
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang Q';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
