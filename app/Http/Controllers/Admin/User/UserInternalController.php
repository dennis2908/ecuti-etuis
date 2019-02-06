<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\MasterModel\MasterUserStatus;
use App\MasterModel\MasterProvinceOffice;
use App\User;
use App\UserStaff;
use App\LogModel\LogSystem;
use Validator;

class UserInternalController extends Controller
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

        $all_status = MasterUserStatus::all();
        $provinces = MasterProvinceOffice::all();
        $roles = Role::whereBetween('id', [6,18])->get();

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 42;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengurusan Pengguna - Pengguna Dalaman";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $user = User::where('user_type_id', 2)->with(['entity_staff.role', 'status']);

            return datatables()->of($user)
                ->editColumn('name', function ($user) {
                    if($user->isOnline())
                        return '<span style="color: #25e125;">●</span> '.$user->name.'<br><small style="font-size: smaller;">'.$user->email.'</small>';
                    else
                        return $user->name.'<br><small style="font-size: smaller;">'.$user->email.'</small>';
                })
                ->editColumn('username', function ($user) {
                    return '<span class="label label-default">'.$user->username.'</span>';
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at ? date('d/m/Y', strtotime($user->created_at)) : date('d/m/Y');
                })
                ->editColumn('entity_staff.province_office.name', function ($user) {
                    return $user->entity_staff->province_office->name;
                })
                ->editColumn('status.name', function ($user) {
                    if($user->user_status_id == 1)
                        return '<span class="badge badge-success">'.$user->status->name.'</span>';
                    if($user->user_status_id == 3 )
                        return '<span class="badge badge-default">'.$user->status->name.'</span>';
                    else
                        return '<span class="badge badge-danger">'.$user->status->name.'</span>';
                })
                ->editColumn('action', function ($user) {
                    $button = "";
                    $button .= '<a data-toggle="tooltip" title="Kemaskini" onclick="edit('.$user->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1 m-l-5"><i class="fa fa-edit"></i></a>';
                    $button .= '<a data-toggle="tooltip" title="Padam" onclick="remove('.$user->id.')" href="javascript:;" class="btn btn-danger btn-xs mb-1 m-l-5"><i class="fa fa-trash"></i></a>';
                    $button .= '<a data-toggle="tooltip" title="Kemaskini Kata Laluan" onclick="passwordUser('.$user->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1 m-l-5"><i class="fa fa-lock"></i></a>';
                    return $button;
                })
                ->make(true);
        }

    	return view('admin.user.internal.index', compact('all_status','provinces','roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string|unique:user',
            'email' => 'required|email|unique:user',
            'password' => 'required',
            'password_confirmation' => 'required',
            'user_status_id' => 'required|integer',
            'roles' => 'required',
            'province_office_id' => 'required|integer',
        ]);
		
		//dd($request->all());
		
		$role_id = Role::where('name', $request->roles[count($request->roles)-1])->first()->id;

		$atasan_role = Role::where('name', $request->atasan_role[count($request->atasan_role)-1])->first()->id;
		
		$request['atasan_role'] = $atasan_role;
		
		$request['role_id'] = $role_id;
		
		$request['province_office_id'] = (int) $request['province_office_id'];

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }
         
		//dd($request->);
		//dd();
		
			
		//dd($request->all());
		
        if(is_array($request->roles)) {
            $roles = $request->roles;
            array_push($roles, 'staff');
            $staff = (UserStaff::create([
                'role_id' => $role_id,
				'atasan_role' => $request->atasan_role,
                'province_office_id' => $request->province_office_id,
		
            ]))->user()->create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
		        'email' => $request->email,
                'user_type_id' => 2,
                'user_status_id' => $request->user_status_id
            ])->assignRole($roles);
        }

        $log = new LogSystem;
        $log->module_id = 42;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pengurusan Pengguna - Pengguna Dalaman";
        $log->data_new = json_encode($staff);
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
    public function edit(Request $request){
        $log = new LogSystem;
        $log->module_id = 42;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Pengurusan Pengguna - Pengguna Dalaman";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $all_status = MasterUserStatus::all();
        $provinces = MasterProvinceOffice::all();
        $roles = Role::whereBetween('id', [6,18])->get();
        $user = User::findOrFail($request->id);
		$user_staff = UserStaff::where('id',$user->toArray()['entity_id'])->get()->toArray();

        $staff_roles = $user->getRoleNames();
		
		//$atasan_role = $user->all();
		
		$atasan_role = Role::where('id', $user_staff[0]['atasan_role'])->get()->toArray();
		
		//$atasan_role = $user->all();
		
	//	$atasan_role = $atasan_role[2];
		
		//$atasan_role = collect($atasan_role);
		
	//	dd($user_staff);
		
		$atasan_role = $atasan_role[0];
		
	   
        return view('admin.user.internal.edit', compact('all_status','provinces','roles','user','staff_roles','atasan_role'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string|unique:user,username,'.$request->id ,
            'email' => 'required|email|unique:user,email,'.$request->id ,
            'user_status_id' => 'required|integer',
			'atasan_role' => 'required|integer',
            'roles' => 'required',
            'province_office_id' => 'required|integer',
        ]);
		
//		dd($request->all());

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($request->id);

        $role_id = Role::where('name', $request->roles[count($request->roles)-1])->first()->id;
		
		//dd($request->atasan_role[count($request->atasan_role)-1]);
		
		
		$atasan_role = Role::where('name', $request->atasan_role[count($request->atasan_role)-1])->first()->id;
		
			

        $user->entity()->update(['role_id', $role_id]);
		
	
		
		$user->entity()->update(['atasan_role', $atasan_role]);
		
	//			dd($request->roles);


        if(is_array($request->roles)) {
            $roles = $request->roles;
            array_push($roles, 'staff');
		//	array_push($roles, 'kpks');
	//	dd($roles);
            $user->syncRoles($roles);
        }

        $log = new LogSystem;
        $log->module_id = 42;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengurusan Pengguna - Pengguna Dalaman";
        $log->data_old = json_encode($user);
		
		$request['atasan_role'] = $atasan_role;
		
        $user->update($request->all());
        
		$user->entity->update($request->all());

        $log->data_new = json_encode($user);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function edit_password(Request $request){
        $log = new LogSystem;
        $log->module_id = 42;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini kata laluan Pengurusan Pengguna - Pengguna Dalaman";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('admin.user.internal.password');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update_password(Request $request) {
        // dd($request->new_pass);
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed',

        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($request->id);

        $password = bcrypt($request->password);
        $user = $user->update(['password' => $password]);

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Remove the specified resource from storage.
     * @param  Request $request
     * @return Response
     */
    public function delete(Request $request) {

        $user = User::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 42;
        $log->activity_type_id = 6;
        $log->description = "Padam Pengurusan Pengguna - Pengguna Dalaman";
        $log->data_old = json_encode($user);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $user->entity->delete();
        $user->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }


}
