<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogModel\LogSystem;

class SettingsController extends Controller
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
        $log = new LogSystem;
        $log->module_id = 41;
        $log->activity_type_id = 9;
        $log->description = "Buka Konfigurasi Sistem";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('admin.settings.index');
    }

    public function changeEnv($key, $value) {
        $key = strtoupper($key);

        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $key.'="'.$_ENV[$key].'"', $key.'="'.$value.'"', file_get_contents($path)
            ));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 41;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Konfigurasi Sistem";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        foreach ($request->input() as $key => $value) {
            $this->changeEnv($key, $value);
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }
}
