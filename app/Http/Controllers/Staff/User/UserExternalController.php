<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\MasterModel\MasterUserStatus;
use App\MasterModel\MasterUserType;
use App\MasterModel\MasterProvinceOffice;
use App\LogModel\LogSystem;
use App\Mail\Profile\HandedOver;
use Validator;
use Mail;

class UserExternalController extends Controller
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
        $types = MasterUserType::whereIn('id',[3,4])->get();

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 42;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengurusan Pengguna - Pengguna Luaran";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $users = User::whereIn('user_type_id', [3,4])->with(['entity','status','type']);

            return datatables()->of($users)
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
                    $button .= '<a onclick="handoverAccount('.$user->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1 m-l-5"><i class="fa fa-refresh mr-1"></i> Tukar Setiausaha</a>';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 42;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Pengurusan Pengguna - Pengguna Luaran";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

    	return view('admin.user.external.index', compact('types','all_status'));
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
        $log->description = "Popup kemaskini Pengurusan Pengguna - Pengguna Luaran";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $all_status = MasterUserStatus::all();
        $provinces = MasterProvinceOffice::all();
        $types = MasterUserType::whereIn('id', [3,4])->get();
        $user = User::findOrFail($request->id);

        return view('admin.user.external.edit', compact('all_status','provinces','types','user'));
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
            'email' => 'required|email|unique:user,email,'.$request->id,
            'union_name' => 'required|string',
            'user_status_id' => 'required|integer',
            'user_type_id' => 'required|integer',
            'province_office_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($request->id);    

        $log = new LogSystem;
        $log->module_id = 42;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengurusan Pengguna - Pengguna Luaran";
        $log->data_old = json_encode($user);

        $user->update($request->all());
        $user = $user->entity->update([
            'name' => $request->union_name,
            'province_office_id' => $request->province_office_id, 
        ]);

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
        $log->description = "Popup kemaskini kata laluan Pengurusan Pengguna - Pengguna Luaran";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return view('admin.user.external.password');
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

        if($user->entity->tenures->count() > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Pengguna ini tidak boleh dipadam kerana mempunyai permohonan.']);

        $log = new LogSystem;
        $log->module_id = 42;
        $log->activity_type_id = 6;
        $log->description = "Padam Pengurusan Pengguna - Pengguna Luaran";
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

    /**
     * Send email to specific address
     * @param  Request $request
     * @return Response
     */
    public function request_handover(Request $request) {
        
        $user = User::findOrFail($request->id);

        return view('admin.user.external.handover', compact('user'));
    }

    /**
     * Send email to specific address
     * @param  Request $request
     * @return Response
     */
    public function send_handover(Request $request) {

        $user = User::findOrFail($request->id);
        Mail::to($request->new_email)->send(new HandedOver($user));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notifikasi emel akan dihantar kepada alamat berikut untuk pendaftaran akaun dan penerimaan tugas.']);
    }

}
