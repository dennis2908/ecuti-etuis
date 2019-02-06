<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogModel\LogSystem;
use App\Permission;
use App\Role;
use Validator;

class RoleController extends Controller
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

        $permissions = Permission::all();

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 43;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Peranan";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $roles = Role::all();

            return datatables()->of($roles)
                ->editColumn('created_at', function ($role) {
                    return date('d/m/Y h:i A', strtotime($role->created_at));
                })
                ->editColumn('action', function ($role) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="edit('.$role->id.')" href="javascript:;" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="remove('.$role->id.')" href="javascript:;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 43;
            $log->activity_type_id = 9;
            $log->description = "Buka Peranan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('admin.role.index', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:role',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $role = Role::create($request->only('name', 'description'));

        if($request->permissions)
            foreach($request->permissions as $permission) {
                $role->givePermissionTo($permission);
            }

        $log = new LogSystem;
        $log->module_id = 43;
        $log->activity_type_id = 4;
        $log->description = "Tambah Peranan";
        $log->data_new = json_encode($role);
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
        $log->module_id = 43;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Peranan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $role = Role::findOrFail($request->id);
        $permissions = Permission::all();

        return view('admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:role,name,'.$request->id ,
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $role = Role::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 43;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Peranan";
        $log->data_old = json_encode($role);

        $role->update($request->only('name', 'description'));
        $role->syncPermissions($request->permissions ? $request->permissions : []);

        $log->data_new = json_encode($role);
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
    public function delete(Request $request) {

        $role = Role::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 43;
        $log->activity_type_id = 6;
        $log->description = "Padam Peranan";
        $log->data_old = json_encode($role);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $role->delete();
        
        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
}
