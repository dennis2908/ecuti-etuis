<?php

namespace App\Http\Controllers\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterState;
use App\FilingModel\Branch;
use App\OtherModel\Address;
use App\LogModel\LogSystem;
use Carbon\Carbon;
use Validator;

class BranchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['auth','role:ks']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $states = MasterState::all();
        $districts = MasterDistrict::all();

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 10;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Cawangan";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $branch = Branch::with(['union','address.district','address.state']);

            return datatables()->of($branch)
                ->editColumn('full_address', function ($branch) {
                    return $branch->address->address1.
                    ($branch->address->address2 ? ',<br>'.$branch->address->address2 : '').
                    ($branch->address->address3 ? ',<br>'.$branch->address->address3 : '').
                    ',<br>'.
                    $branch->address->postcode.' '.
                    ($branch->address->district ? $branch->address->district->name : '').', '.
                    ($branch->address->state ? $branch->address->state->name : '');
                })
                 ->editColumn('established_at', function ($branch) {
                    return date('d/m/Y', strtotime($branch->established_at));
                })
                ->editColumn('meeting_at', function ($branch) {
                    return date('d/m/Y', strtotime($branch->meeting_at));
                })
                ->editColumn('action', function ($branch) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="edit('.$branch->id.')" href="javascript:;" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="remove('.$branch->id.')" href="javascript:;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 10;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Cawangan";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('registration.branch.index', compact('states', 'districts','province_offices'));
    }

     /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:branch',
            'address1' => 'required|string',
            'postcode' => 'required|digits:5',
            'state_id' => 'required|integer',
            'district_id' => 'required|integer',
            'secretary_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $address = Address::create($request->all());
        $branch = Branch::create([
            'name' => $request->name,
            'user_union_id' => $request->user_union_id,
            'address_id' => $address->id,
            'secretary_name' => $request->secretary_name,
            'secretary_email' => $request->secretary_email,
            'secretary_phone' => $request->secretary_phone,
            'total_member' => $request->total_member,
            'established_at' => Carbon::createFromFormat('d/m/Y', $request->established_at)->toDateTimeString(),
            'meeting_at' => Carbon::createFromFormat('d/m/Y', $request->meeting_at)->toDateTimeString(),
        ]);

        $log = new LogSystem;
        $log->module_id = 10;
        $log->activity_type_id = 4;
        $log->description = "Tambah Cawangan";
        $log->data_new = json_encode($branch);
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
        $log->module_id = 10;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Cawangan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $branch = Branch::findOrFail($request->id);
        $states = MasterState::all();
        $districts = MasterDistrict::all();

        return view('registration.branch.edit', compact('branch','states','districts'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:branch,name,'.$request->id,
            'address1' => 'required|string',
            'postcode' => 'required|digits:5',
            'state_id' => 'required|integer',
            'district_id' => 'required|integer',
            'secretary_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $branch = Branch::findOrFail($request->id);
        $address = Address::findOrFail($branch->address_id)->update($request->all());

        $log = new LogSystem;
        $log->module_id = 10;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Cawangan";
        $log->data_old = json_encode($branch);
        
        $branch->update([
            'name' => $request->name,
            'secretary_name' => $request->secretary_name,
            'secretary_email' => $request->secretary_email,
            'secretary_phone' => $request->secretary_phone,
            'total_member' => $request->total_member,
            'established_at' => Carbon::createFromFormat('d/m/Y', $request->established_at)->toDateTimeString(),
            'meeting_at' => Carbon::createFromFormat('d/m/Y', $request->meeting_at)->toDateTimeString(),
        ]);

        $log->data_new = json_encode($branch);
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
        $branch = Branch::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 10;
        $log->activity_type_id = 6;
        $log->description = "Padam Cawangan";
        $log->data_old = json_encode($branch);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $branch->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'data telah dipadam.']);
    }
}
