<?php

namespace App\Http\Controllers\Registration;

use App\FilingModel\Appeal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use Carbon\Carbon;
use Validator;
use App\User;

class AppealController extends Controller
{

     /**
     * Show the application form.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 6;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Rayuan";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $appeals = Appeal::with(['user.entity','status'])->where('filing_status_id', '>', 1);

            return datatables()->of($appeals)
                ->editColumn('created_at', function ($appeal) {
                    return $appeal->created_at ? date('d/m/Y', strtotime($appeal->created_at)) : '';
                })
                ->editColumn('user.entity_type', function ($appeal) {
                    return $appeal->user->entity_type == "App\\UserUnion" ? 'Kesatuan' : 'Persekutuan';
                })
                ->editColumn('status.name', function ($appeal) {
                    if($appeal->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$appeal->status->name.'</span>';
                    else if($appeal->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$appeal->status->name.'</span>';
                    else if($appeal->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$appeal->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$appeal->status->name.'</span>';
                })
                ->editColumn('action', function ($appeal) {
                    $button = "";
                    $button .= '<a onclick="viewData('.$appeal->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    if(auth()->user()->hasRole('kpks'))
                        $button .= '<a onclick="process('.$appeal->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 6;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Rayuan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('registration.appeal.list');
    }


    /**
     * Show the application form.
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Request $request) {
    	abort_if( ($user = User::where('username', $request->username)->where('password', 'LIKE', '%'.$request->code.'%')->where('user_status_id', 2))->doesntHave('appeal')->count() == 0 , 404 );

    	$user = $user->first();

    	return view('registration.appeal.form', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
        	'id' => 'required|integer',
            'justification' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($request->id);

        $appeal = new Appeal;
        $appeal->user_id = $request->id;
        $appeal->justification = strtoupper($request->justification);

        // Check if the appeal sent more than 14 days from the registration date.
        if( Carbon::parse($user->created_at)->diffInDays(Carbon::today(), false) > (env('MAX_DAYS_AFTER_REGISTER_REJECTED')+1) ) {
        	// Reject notification emailed immediately
        	//###########################################################

        	$appeal->filing_status_id = 7;
        	$appeal->processed_by_user_id = 1;
        	$appeal->processed_at = Carbon::now();
        	$appeal->remarks = "RAYUAN MELEBIHI TEMPOH ".env('MAX_DAYS_AFTER_REGISTER_REJECTED')." HARI";
        }
        else {
        	$appeal->filing_status_id = 3;
        }

        $appeal->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya', 'message' => 'Rayuan anda telah berjaya dihantar. Kami akan memaklumkan keputusan rayuan ke alamat emel anda.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result(Request $request) {

        $form = $appeal = Appeal::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 6;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Rayuan - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("appeal.process.result.reject", $form->id);
        $route_approve = route("appeal.process.result.approve", $form->id);

        return view('general.modal.result-only', compact('route_reject','route_approve'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $appeal = Appeal::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 6;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Rayuan - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('appeal.process.result.approve', $appeal->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 6;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Rayuan - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $appeal = Appeal::findOrFail($request->id);
        $appeal->filing_status_id = 9;
        $appeal->save();

        $appeal->logs()->updateOrCreate(
            [
                'module_id' => 6,
                'activity_type_id' => 16,
                'filing_status_id' => $appeal->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Rayuan Kesatuan Sekerja ini telah diluluskan. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $appeal = Appeal::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 6;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Rayuan - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('appeal.process.result.reject', $appeal->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 6;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Rayuan - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $appeal = Appeal::findOrFail($request->id);
        $appeal->filing_status_id = 8;
        $appeal->save();

        $appeal->logs()->updateOrCreate(
            [
                'module_id' => 6,
                'activity_type_id' => 16,
                'filing_status_id' => $appeal->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Rayuan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }
}
