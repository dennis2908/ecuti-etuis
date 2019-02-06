<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogModel\LogSystem;
use App\Permission;
use Validator;

class PermissionController extends Controller
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
            $log->module_id = 44;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Keizinan";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $permissions = Permission::all();

            return datatables()->of($permissions)
                ->editColumn('created_at', function ($permission) {
                    return date('d/m/Y h:i A', strtotime($permission->created_at));
                })
                ->editColumn('action', function ($permission) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="edit('.$permission->id.')" href="javascript:;" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="remove('.$permission->id.')" href="javascript:;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 44;
            $log->activity_type_id = 9;
            $log->description = "Buka Keizinan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

    	return view('admin.permission.index');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permission',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $permission = Permission::create($request->only('name','description'));

        $log = new LogSystem;
        $log->module_id = 44;
        $log->activity_type_id = 4;
        $log->description = "Tambah Keizinan";
        $log->data_new = json_encode($permission);
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
    public function edit(Request $request)
    {
        $log = new LogSystem;
        $log->module_id = 44;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Keizinan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $permission = Permission::findOrFail($request->id);

        return view('admin.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permission,name,'.$request->id,
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $permission = Permission::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 44;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Keizinan";
        $log->data_old = json_encode($permission);

        $permission->update($request->only('name','description'));

        $log->data_new = json_encode($permission);
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
    public function delete(Request $request)
    {
        $permission = Permission::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 44;
        $log->activity_type_id = 6;
        $log->description = "Padam Keizinan";
        $log->data_old = json_encode($permission);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $permission->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
}
