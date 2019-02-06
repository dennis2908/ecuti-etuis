<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\ViewModel\ViewDashboardStat1;
use App\ViewModel\ViewDashboardStat2;
use App\ViewModel\ViewDashboardStat3;
use App\ViewModel\ViewDashboardStat4;
use App\ViewModel\ViewDashboardStat5;
use App\MasterModel\MasterModule;
use App\MasterModel\MasterFilingStatus;
use App\OtherModel\Announcement;
use App\OtherModel\Inbox;
use App\FilingModel\Reference;
use App\FilingModel\FormBB;
use App\FilingModel\FormB;
use App\LogModel\LogSystem;
use Carbon\Carbon;
use App\User;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home');
    }

    protected function formatBytes($bytes, $enable_unit = false, $decimals=2){
        $size=array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $factor=floor((strlen($bytes)-1)/3);
        return sprintf("%.{$decimals}f",$bytes/pow(1024,$factor)).($enable_unit ? @$size[$factor] : '');
    } 

    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 3;
            $log->activity_type_id = 1;
            $log->description = "Paparan Utama";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $list = range(6,36);
            array_push($list, 53);

            $user = auth()->user();

            if(!$user->hasAnyRole(['union','federation']) && $user->hasRole('ks')) {

                if($user->entity->formb)
                    $forms = FormB::where('id', $user->entity->formb->id);
                else
                    $forms = FormBB::where('id', $user->entity->formbb->id);

                return datatables()->of($forms)
                        ->editColumn('reference', function($form) {
                            $button = "";
                            $button .= auth()->user()->entity->formb ? 'Pendaftaran Kesatuan Sekerja (Borang B)' : 'Pendaftaran Persekutuan Kesatuan Sekerja (Borang BB)';
                            $button .= '<br><a onclick="viewData('.$form->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i>'.($form->reference ? $form->reference->reference_no : '-').'</a><br>';
                            return $button;
                        })
                        ->editColumn('deadline', function($form) {
                            // lulus = '<span class="badge badge-success badge-sm"><i class="fa fa-check"></i></span>';
                            // semak = '<span class="badge badge-warning badge-sm">10 hari</span>';
                            // tolak = '<span class="badge badge-danger badge-sm">2 hari</span>';
                        })
                        ->editColumn('filing.created_at', function($form) {
                            return date('d/m/Y', strtotime($form->created_at));
                        })
                        ->editColumn('filing.status.name', function ($form) {
                            if($form->filing_status_id == 9 || $form->filing_status_id == 10)
                                return '<span class="badge badge-success">'.$form->status->name.'</span>';
                            else if($form->filing_status_id == 8)
                                return '<span class="badge badge-danger">'.$form->status->name.'</span>';
                            else if($form->filing_status_id == 7 || $form->filing_status_id == 11)
                                return '<span class="badge badge-warning">'.$form->status->name.'</span>';
                            else
                                return '<span class="badge badge-default">'.$form->status->name.'</span>';
                        })
                        ->make(true);
            }
            else {
                $references = Reference::whereIn('module_id', $list)->where('filing_type','NOT LIKE','%Letter%')->groupBy('filing_type','filing_id');

                if(auth()->user()->hasRole(['ks']))
                    $references = $references->where('filing_type','NOT LIKE','%Affidavit%')->with(['filing.tenure.entity','filing.status']);
                else
                    $references = $references->with(['filing.status']);

                $references = $references->get()->filter(function($reference) use($request, $user) {

                    if(!$reference->filing)
                        return false;

                    $result = true;

                    if($reference->filing->entity)
                        $result = $result && $reference->filing->entity_type == $user->entity_type && $reference->filing->entity_id == $user->entity_id;
                    elseif ($reference->filing->tenure)
                        $result = $result && $reference->filing->tenure->entity_type == $user->entity_type && $reference->filing->tenure->entity_id == $user->entity_id;

                    if(auth()->user()->hasRole(['ks'])) {
                        if($request->tenure_id && $request->tenure_id != -1) {
                            $result = $result && $reference->filing->tenure->id == $request->tenure_id;
                        }
                        if($request->meeting_type_id && $request->meeting_type_id != -1) {
                            $result = $result && $reference->filing->tenure->meeting_type_id == $request->meeting_type_id;
                        }
                    }

                    if($request->module_id && $request->module_id != -1) {
                        $result = $result && $reference->module_id == $request->module_id;
                    }
                    if($request->status_id && $request->status_id != -1) {
                        $result = $result && $reference->filing->status->id == $request->status_id;
                    }

                    return $result;
                });

                if(auth()->user()->hasRole('staff')) {
                    return datatables()->of($references)
                        ->editColumn('module.name', function($reference) {
                            return $reference->module->name;
                        })
                        ->editColumn('reference', function($reference) {
                            $button = "";
                            $button .= '<a onclick="viewData('.$reference->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i>'.$reference->reference_no.'</a><br>';
                            return $button;
                        })
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
                        ->make(true);
                }
                else {
                    return datatables()->of($references)
                        ->editColumn('reference', function($reference) {
                            $button = "";
                            $button .= $reference->module->name;
                            
                            if($reference->filing->filing_status_id > 1)
                                $button .= '<br><a onclick="viewFiling(\''.addslashes($reference->filing_type).'\','.$reference->filing_id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i>'.$reference->reference_no.'</a><br>';

                            return $button;
                        })
                        ->editColumn('deadline', function($reference) {
                            // lulus = '<span class="badge badge-success badge-sm"><i class="fa fa-check"></i></span>';
                            // semak = '<span class="badge badge-warning badge-sm">10 hari</span>';
                            // tolak = '<span class="badge badge-danger badge-sm">2 hari</span>';
                        })
                        ->editColumn('filing.created_at', function($reference) {
                            return date('d/m/Y', strtotime($reference->filing->created_at));
                        })
                        ->editColumn('filing.status.name', function ($reference) {
                            if($reference->filing->filing_status_id == 9 || $reference->filing->filing_status_id == 10)
                                return '<span class="badge badge-success">'.$reference->filing->status->name.'</span>';
                            else if($reference->filing->filing_status_id == 8)
                                return '<span class="badge badge-danger">'.$reference->filing->status->name.'</span>';
                            else if($reference->filing->filing_status_id == 7 || $reference->filing->filing_status_id == 11)
                                return '<span class="badge badge-warning">'.$reference->filing->status->name.'</span>';
                            else
                                return '<span class="badge badge-default">'.$reference->filing->status->name.'</span>';
                        })
                        ->make(true);
                }
            }
        }
    }
}
