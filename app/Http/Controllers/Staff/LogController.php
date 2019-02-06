<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogModel\LogSystem;

class LogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 49;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Jejak Audit / Log Sistem";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $audit_log = LogSystem::with(['module','activity_type','created_by']);

            return datatables()->of($audit_log)
                ->editColumn('activity_type.name', function ($audit_log) {
                    if($audit_log->activity_type_id == 6)
                        return '<span class="badge badge-danger">'.$audit_log->activity_type->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$audit_log->activity_type->name.'</span>';
                })
                ->editColumn('created_at', function ($audit_log) {
                    return date('d/m/Y h:i A', strtotime($audit_log->created_at));
                })
                ->editColumn('action', function ($audit_log) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="view('.$audit_log->id.')" href="javascript:;" class="btn btn-default btn-xs text-capitalize"><i class="fa fa-search"></i> Lihat</a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 49;
            $log->activity_type_id = 9;
            $log->description = "Papar senarai Jejak Audit / Log Sistem";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('admin.log.index');
    }

    public function view(Request $request){
        
        $audit_log = LogSystem::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 49;
        $log->activity_type_id = 2;
        $log->description = "Buka paparan Jejak Audit / Log Sistem";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('admin.log.view', compact('audit_log'));
    }
}
