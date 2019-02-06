<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterModel\MasterState;
use App\MasterModel\MasterPostcode;
use App\MasterModel\MasterLetterType;
use App\OtherModel\Attachment;
use Storage;

class GeneralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getStateFromPostcode(Request $request) {
    	if($request->postcode) {
    		$postcode = MasterPostcode::with(['district.state'])->where('code', $request->postcode)->firstOrFail();

    		return response()->json($postcode->district);
    	}
    	else abort(404);
    }

    public function getDistrictFromState(Request $request) {
    	if($request->state_id) {
    		$state = MasterState::with(['districts'])->findOrFail($request->state_id);

    		return response()->json($state->districts);
    	}
    	else abort(404);
    }

    public function getAttachment(Request $request) {
        if($request->attachment_id && $request->filename) {
            $attachment = Attachment::where('id', $request->attachment_id)->where('name', $request->filename)->firstOrFail();

            abort_if(!$attachment, 404);

            return Storage::disk('uploads')->download($attachment->url);
        }
        else abort(404);
    }

    public function getLetterTemplate(Request $request) {
        if($request->letter_type_id) {
            $type = MasterLetterType::findOrFail($request->letter_type_id);

            $dir = str_replace('.', '/', $type->template_name);

            return Storage::disk('templates_letters')->download($dir.'.docx');
        }
        else abort(404);
    }

    public function getFilingDetails(Request $request) {

        // Expecting parameters: $filing_type, $filing_id
        abort_if(!$request->filing_type || !$request->filing_id, 404);

        $filing = $request->filing_type::findOrFail($request->filing_id);

        $entity = $filing->tenure ? $filing->tenure->entity : ($filing->entity ? $filing->entity : $filing->created_by->entity);

        return view('general.modal.view', compact('filing','entity'));
    }
}
