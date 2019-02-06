<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterAnnouncementType;
use App\OtherModel\Announcement;
use App\OtherModel\AnnouncementTarget;
use App\LogModel\LogSystem;
use App\Role;
use Carbon\Carbon;
use Validator;

class AnnouncementController extends Controller
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

        $types = MasterAnnouncementType::all();
        $roles = Role::all();

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 40;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengumuman";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $announcement = Announcement::with(['type','created_by']);

            return datatables()->of($announcement)
                ->editColumn('announcement_type', function ($announcement) {
                    return '<span class="label label-'.$announcement->type->label.' p-t-5 m-l-5 p-b-5 inline fs-12">'.$announcement->type->name.'</span>';
                })
                ->editColumn('created_at', function ($announcement) {
                    return date('d/m/Y h:i A', strtotime($announcement->created_at));
                })
                ->editColumn('date_start', function ($announcement) {
                    return date('d/m/Y', strtotime($announcement->date_start));
                })
                ->editColumn('date_end', function ($announcement) {
                    return date('d/m/Y', strtotime($announcement->date_end));
                })
                ->editColumn('action', function ($announcement) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="edit('.$announcement->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="remove('.$announcement->id.')" href="javascript:;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 40;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Pengumuman";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('announcement.index', compact('roles', 'types'));
    }

     public function insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'announcement_type_id' => 'required|integer',
            'created_by_user_id' => 'required|integer',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'description' => $request->description,
            'announcement_type_id' => $request->announcement_type_id,
            'created_by_user_id' => $request->created_by_user_id,
            'date_start' => Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateTimeString(),
            'date_end' => Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateTimeString(),
        ]);

        foreach($request->target_roles as $role) {

            $announcement_target = new AnnouncementTarget;
            $announcement_target->role_id = $role;
            $announcement_target->announcement_id = $announcement->id;
            $announcement_target->save();
        }

        $log = new LogSystem;
        $log->module_id = 40;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pengumuman";
        $log->data_new = json_encode($announcement);
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
        $log->module_id = 40;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Pengumuman";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $announcement = Announcement::findOrFail($request->id);
        $targets = AnnouncementTarget::where('announcement_id', $request->id)->get();
        $types = MasterAnnouncementType::all();
        $roles = Role::all();

        return view('announcement.edit', compact('announcement','targets','types','roles'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'announcement_type_id' => 'required|integer',
            'created_by_user_id' => 'required|integer',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $announcement = Announcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 40;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengumuman";
        $log->data_old = json_encode($announcement);

        
        $announcement = $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
            'announcement_type_id' => $request->announcement_type_id,
            'created_by_user_id' => $request->created_by_user_id,
            'date_start' => Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateTimeString(),
            'date_end' => Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateTimeString(),
        ]);

        $announcement_target = AnnouncementTarget::where('announcement_id',$request->id)->delete();

        foreach($request->target_roles as $role) {

            $announcement_target = new AnnouncementTarget;
            $announcement_target->role_id = $role;
            $announcement_target->announcement_id = $request->id;
            $announcement_target->save();
        }

        $log->data_new = json_encode($announcement);
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

        $announcement_target = AnnouncementTarget::where('announcement_id', $request->id)->delete();
        $announcement = Announcement::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 40;
        $log->activity_type_id = 6;
        $log->description = "Padam Pengumuman";
        $log->data_old = json_encode($announcement);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $announcement->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
}
