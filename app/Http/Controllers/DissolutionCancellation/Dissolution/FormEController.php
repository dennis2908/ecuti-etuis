<?php

namespace App\Http\Controllers\DissolutionCancellation\Dissolution;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogModel\LogSystem;
use App\FilingModel\FormIEU;
use App\FilingModel\FormE;
use App\FilingModel\Member;
use App\OtherModel\Address;
use App\MasterModel\MasterMeetingType;
use App\MasterModel\MasterState;
use Carbon\Carbon;
use Validator;
use Storage;
use App\Custom\PhpWord;

class FormEController extends Controller
{
    //
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

        $dissolution = FormIEU::findOrFail($request->id);
        $forme = $dissolution->forme;
        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();
        $states = MasterState::all();

    	return view('dissolution-cancellation.dissolution.forme.index', compact('dissolution', 'forme', 'meeting_types', 'states'));
    }

    //Member CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function member_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang E - Butiran Ahli";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $dissolution = FormIEU::findOrFail($request->id);
        $forme = $dissolution->forme;
        $members = $forme->members()->with(['address'])->get();

        while($members->count() < 7)
            $members->push(new Member(['name' => '', 'address_id' => '']));

        return datatables()->of($members)
            ->editColumn('address', function ($member) {
                if($member->address)
                    return $member->address->address1.
                        ($member->address->address2 ? ',<br>'.$member->address->address2 : '').
                        ($member->address->address3 ? ',<br>'.$member->address->address3 : '').
                        ',<br>'.
                        $member->address->postcode.' '.
                        ($member->address->district ? $member->address->district->name : '').', '.
                        ($member->address->state ? $member->address->state->name : '');
                else
                    return "";
            })
            ->editColumn('action', function ($member) {
                $button = "";

                if($member->id) {
                    $button .= '<a onclick="editMember('.$member->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';

                    $button .= '<a onclick="removeMember('.$member->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';
                } else {
                    $button .= '<a onclick="addMember()" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function member_insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create($request->all());

        $dissolution = FormIEU::findOrFail($request->id);
        $forme = $dissolution->forme;
        $member = $forme->members()->create([
            'name' => $request->name,
            'address_id' => $address->id,
        ]);

        $count = $forme->members->count();

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang E - Butiran Ahli";
        $log->data_new = json_encode($member);
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
    public function member_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang E - Butiran Ahli";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $dissolution = FormIEU::findOrFail($request->id);
        $forme = $dissolution->forme;
        $member = Member::findOrFail($request->member_id);
        $states = MasterState::all();

        return view('dissolution-cancellation.dissolution.forme.tab2.edit', compact('dissolution', 'forme', 'member', 'states'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function member_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $member = Member::findOrFail($request->member_id);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang E - Butiran Ahli";
        $log->data_old = json_encode($member);

        $address = Address::findOrFail($member->address_id)->update($request->all());
        $member->update($request->all());

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

        $dissolution = FormIEU::findOrFail($request->id);
        $forme = $dissolution->forme;
        $member = Member::findOrFail($request->member_id);

        $log = new LogSystem;
        $log->module_id = 27;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang E - Butiran Ahli";
        $log->data_old = json_encode($member);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $member->delete();

        $count = $forme->members->count();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.', 'count' => $count]);
    }
    //Member CRUD END

    public function download(Request $request) {

        $formieu = FormIEU::findOrFail($request->id);
        $filing = $formieu->forme;
                                                             // Change here
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
            'applied_day' => htmlspecialchars(strftime('%e', strtotime($filing->applied_at))),
            'applied_month_year' =>  htmlspecialchars(strftime('%B %Y', strtotime($filing->applied_at))),
            'meeting_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'resolved_day' => htmlspecialchars(strftime('%e', strtotime($filing->resolved_at))),
            'resolved_month_year' => htmlspecialchars(strftime('%B %Y', strtotime($filing->resolved_at))),
            'secretary_name' => htmlspecialchars($filing->tenure->entity->user->name),
            'today_day' => htmlspecialchars(strftime('%e')),
            'today_month_year' =>  htmlspecialchars(strftime('%B %Y')),
        ];

        $log = new LogSystem;
        $log->module_id = 27;                                                                            // Change here
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
        $document = $phpWord->loadTemplate(storage_path('templates/filings/dissolution-cancellation/forme.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate table requester
        $rows = $filing->members;
        $document->cloneRow('no', count($rows));
        $num =2;
        foreach($rows as $index => $row) {
            ;
            if($index == 0)
                $document->setValue('signed_by#'.($index+1), 'Tandatangan Ahli-ahli:');
            else
                $document->setValue('signed_by#'.($index+1), '');

            $document->setValue('no#'.($index+1), $num++);
            $document->setValue('member_name#'.($index+1), htmlspecialchars(strtoupper($row->name)));
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang E';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
