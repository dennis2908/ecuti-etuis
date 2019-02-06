<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogModel\LogSystem;
use App\OtherModel\Inbox;

class InboxController extends Controller
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

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 5;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Inbox";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $inboxes = Inbox::with(['sender','status'])->where('receiver_user_id', auth()->id())->orderBy('created_at','desc');

            return datatables()->of($inboxes)
                ->editColumn('status.name', function ($inbox) {
                    if($inbox->status->id == 2)
                        return '<span class="badge badge-warning">Belum Dibaca</span>';
                    else
                        return '<span class="badge badge-default">'.$inbox->status->name.'</span>';
                })
                ->editColumn('created_at', function ($inbox) {
                    return date('d/m/Y h:i A', strtotime($inbox->created_at));
                })
                ->editColumn('action', function ($inbox) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="view('.$inbox->id.')" href="javascript:;" class="btn btn-default btn-xs text-capitalize"><i class="fa fa-search"></i> Lihat</a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 5;
            $log->activity_type_id = 9;
            $log->description = "Papar senarai Inbox";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

    	return view('inbox.index');
    }

    public function view(Request $request){
        
        $inbox = Inbox::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 5;
        $log->activity_type_id = 2;
        $log->description = "Buka paparan Inbox";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $inbox->inbox_status_id = 3;
        $inbox->save();

        return view('inbox.view', compact('inbox'));
    }
}
