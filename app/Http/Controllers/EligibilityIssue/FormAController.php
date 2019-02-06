<?php

namespace App\Http\Controllers\EligibilityIssue;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FilingModel\EligibilityIssue;
use App\MasterModel\MasterState;
use App\OtherModel\Attachment;
use App\LogModel\LogSystem;
use App\User;
use Storage;

class FormAController extends Controller
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
        
    	$eligibility = EligibilityIssue::findOrFail($request->id);
        $users = User::whereIn('user_type_id', [3,4])->where('user_status_id', 1)->get();
        $states = MasterState::all();

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 4;
        $log->description = "Tambah Isu Kelayakan - Borang A dan Memo Siasatan";
        $log->data_new = json_encode($eligibility);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('eligibility-issue.forma.index', compact('eligibility','users','states'));
    }

    /**
     * Show the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_index(Request $request) {

        $eligibility = EligibilityIssue::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 34;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai (Borang A) Isu Kelayakan - Dokumen Sokongan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attachments = [];

        foreach($eligibility->forma->attachments as $attachment) {
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
                'forma',
                $request->file('file'),
                uniqid().'_'.$request->file('file')->getClientOriginalName()
            );

            $eligibility = EligibilityIssue::findOrFail($request->id);

            $attachment = $eligibility->forma->attachments()->create([
                'name' => $request->file('file')->getClientOriginalName(),
                'url' => $path,
                'created_by_user_id' => auth()->id()
            ]);

            $log = new LogSystem;
            $log->module_id = 34;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Borang A) Isu Kelayakan - Dokumen Sokongan";
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
        $log->module_id = 34;
        $log->activity_type_id = 6;
        $log->description = "Padam (Borang A) Isu Kelayakan - Dokumen Sokongan";
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
}
 