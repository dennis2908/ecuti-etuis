<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogModel\LogSystem;
use App\OtherModel\Notification;
use Validator;

class NotificationController extends Controller
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
            $log->module_id = 46;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengurusan Notifikasi";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $notification = Notification::all();

            return datatables()->of($notification)
                ->editColumn('created_at', function ($notification) {
                    return date('d/m/Y h:i A', strtotime($notification->created_at));
                })
                ->editColumn('action', function ($notification) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="edit('.$notification->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini</a> ';
                    $button .= '<a onclick="remove('.$notification->id.')" href="javascript:;" class="btn btn-danger btn-xs mb-1"><i class="fa fa-trash mr-1"></i> Padam</a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 46;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Pengurusan Notifikasi";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('admin.notification.index');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:notification',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->request->add(['message' => nl2br($request->message)]);
        $notification = Notification::create($request->all());

        $log = new LogSystem;
        $log->module_id = 46;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pengurusan Notifikasi";
        $log->data_new = json_encode($notification);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 46;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Pengurusan Notifikasi";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $notification = Notification::findOrFail($request->id);

        return view('admin.notification.edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request) {

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:notification,code,'.$request->id,
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $notification = Notification::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 46;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengurusan Notifikasi";
        $log->data_old = json_encode($notification);

        $request->request->add(['message' => nl2br($request->message)]);
        $notification = $notification->update($request->all());

        $log->data_new = json_encode($notification);
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
    public function delete(Request $request){ 

        $notification = Notification::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 46;
        $log->activity_type_id = 6;
        $log->description = "Padam Pengurusan Notifikasi";
        $log->data_old = json_encode($notification);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $notification->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
}
