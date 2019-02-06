<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogModel\LogSystem;
use Exception;
use Validator;
use Artisan;

class BackupController extends Controller
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
            $log->module_id = 45;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengurusan Simpanan";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $dir = storage_path('backup/files');
            $files = glob($dir.'/*.*');

            usort($files, function($a,$b){
                return filemtime($b) - filemtime($a);
            });

            if($request->has('date') && !empty($request->date)) {
                $temp = [];

                foreach($files as $i => $file) {
                    if(date('d/m/Y', filemtime($file)) == $request->date)
                        array_push($temp, $file);
                }

                $files = $temp;
            }

            $backups = array();

            foreach($files as $i => $file) {
                array_push($backups, [
                    "filename" => basename($file),
                    "size" => $this->human_filesize(filesize($file)),
                    "created_at" => date('d/m/Y h:i A', filemtime($file))
                ]);
            }

            return datatables()->of($backups)
                ->editColumn('action', function ($backup) {
                    $button = "";

                    $button .= '<a class="btn btn-default btn-xs" href="'.route("admin.backup.data", ["filename" => $backup['filename']]).'"><i class="fa fa-download m-r-5"></i> Muat Turun</a> ';

                    $button .= '<a onclick="remove(\''.$backup['filename'].'\')" href="javascript:;" class="btn btn-danger btn-xs"><i class="fa fa-trash m-r-5"></i> Padam</a> ';

                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 45;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Pengurusan Simpanan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

    	return view('admin.backup.index');
    }

    /**
     * Download the specified resource.
     * @return Response (File)
     */
    public function download(Request $request) {
        if($request->filename) {
            $log = new LogSystem;
            $log->module_id = 45;
            $log->activity_type_id = 10;
            $log->description = "Muat turun data Pengurusan Simpanan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $path = storage_path('backup/files/'.$request->filename);
            return response()->download($path);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete(Request $request) {
        if($request->filename) {
            $path = storage_path('backup/files/'.$request->filename);

            // Delete file
            unlink($path);

            $log = new LogSystem;
            $log->module_id = 45;
            $log->activity_type_id = 6;
            $log->description = "Padam data Pengurusan Simpanan";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
        }
        else
            return response()->json(['status' => 'error', 'title' => 'Ralat!', 'message' => 'Data tidak berjaya dipadam.']);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), ['filename' => 'required', 'types' => 'required']);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mode = $request->types ? count($request->types) > 1 ? 3 : $request->types[0] : 0;

        try {

            $options = ['--disable-notifications' => true];

            if($mode == 1)
                $options['--only-db'] = true;
            else if($mode == 2)
                $options['--only-files'] = true;

            if($request->filename)
                $options['--filename'] = $request->filename.".zip";

            Artisan::call('backup:run', $options);

            $log = new LogSystem;
            $log->module_id = 45;
            $log->activity_type_id = 4;
            $log->description = "Tambah data Pengurusan Simpanan";
            $log->data_new = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah berjaya disimpan.']);

        } catch (Exception $exception) {
            return response()->json(['status' => 'error', 'title' => 'Ralat!', 'message' => 'Data tidak berjaya disimpan.']);
        }
    }

    private function human_filesize($bytes, $decimals = 2) {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}

