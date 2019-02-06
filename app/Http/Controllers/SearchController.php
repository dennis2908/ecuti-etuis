<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterModel\MasterModule;
use App\FilingModel\Reference;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\User;
use Carbon\Carbon;

class SearchController extends Controller
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

        $list = range(6,36);
        array_push($list, 53);

        $modules = MasterModule::whereIn('id', $list)->get();
        $users = User::whereIn('user_type_id', [3,4])
                     ->where('user_status_id', 1)->get();

    	return view('search.index', compact('modules', 'users'));
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 37;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Carian";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $references = Reference::with(['filing.logs', 'filing.tenure.entity'])->where('filing_type','NOT LIKE','%Letter%')->groupBy('filing_type','filing_id');

            if($request->reference_no) {
                $references = $references->where('reference_no', 'like', '%'.$request->reference_no.'%');
            }

            if($request->module_id) {
                $references = $references->where('module_id', $request->module_id);
            }

            $references = $references->get();

            $references = $references->filter(function($reference) use($request) {

                if(!$reference->filing)
                    return false;

                $result = true;

                if($request->user_id || $request->start_date || $request->end_date) {
                    $user = User::find($request->user_id);

                    if($request->user_id && $user) {
                        if($reference->filing->entity)
                            $result = $result && $reference->filing->entity_type == $user->entity_type && $reference->filing->entity_id == $user->entity_id;
                        elseif ($reference->filing->tenure)
                            $result = $result && $reference->filing->tenure->entity_type == $user->entity_type && $reference->filing->tenure->entity_id == $user->entity_id;
                    }

                    if($request->start_date) {
                        $result = $result && $reference->filing->created_at >= Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateString();
                    }

                    if($request->end_date) {
                        $result = $result && $reference->filing->created_at <= Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateString();
                    }    
                }

                return $result;
            });

            return datatables()->of($references)
                ->editColumn('filing.created_at', function($reference) {
                    return date('d/m/Y', strtotime($reference->filing->created_at));
                })
                ->editColumn('filing.status.name', function ($reference) {
                    if($reference->filing->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$reference->filing->status->name.'</span>';
                    else if($reference->filing->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$reference->filing->status->name.'</span>';
                    else if($reference->filing->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$reference->filing->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$reference->filing->status->name.'</span>';
                })
                ->editColumn('action', function ($reference) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes($reference->filing_type).'\','.$reference->filing_id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';
                    return $button;
                })
                ->make(true);

        }
    }

    public function view_search(Request $request) {

        $reference = Reference::with(['filing.logs', 'filing.tenure.entity'])->findOrFail($request->id);
        $logs = LogFiling::where('filing_id', $reference->filing_id)
                         ->where('filing_type', $reference->filing_type)->get();
        $entity = $reference->filing->entity ? $reference->filing->entity : $reference->filing->tenure->entity;

        return view('sample.timeline.search.logs', compact('reference', 'logs', 'entity'));
    }
}
