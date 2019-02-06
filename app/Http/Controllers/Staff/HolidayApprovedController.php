<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OtherModel\Holiday;
use App\OtherModel\HolidayState;
use App\MasterModel\MasterHolidayType;
use App\MasterModel\MasterState;
use App\MasterModel\MasterMonth;
use App\LogModel\LogSystem;
use Carbon\Carbon;
use Validator;
use Auth;
use DB;
use App\Http\Controllers\Staff\Session;
use App\UserStaff;

class HolidayApprovedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('staff');
		
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

      //  dd( Auth::user()->id);
        $states = MasterState::all();
        $types = MasterHolidayType::all();
        $years = range(2019, 2008);
        $months = MasterMonth::all();

        $log = new LogSystem;
        $log->module_id = 48;
        $log->activity_type_id = 9;
        $log->description = "Buka paparan Pengurusan Cuti";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();
		
		

    	return view('staff.holiday_approved.index', compact('states', 'types', 'years', 'months'));
    }

    // General CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function general_index(Request $request) {
    DB::enableQueryLog();
        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 48;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengurusan Cuti - Umum";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
			
			  

          //$generals = Holiday::join('user')->whereNotNull('holiday_type_id')->where('created_by_user_id',auth->id());
		  //$holidays = Holiday::where($id,auth->id());
		   $role = UserStaff::select("role_id")->where("id",auth()->id())->get()->toArray();
		   //dd($role);
			$generals = Holiday::select("*.holiday")->join("user_staff.id","=","Holiday.created_by_user_id")->whereNotNull('holiday_type_id')->where("user_staff.atasan",$role[0]["role_id"])->get();
		    dd($generals);
			//return $generals->toSql();
      //      dd($generals);


            if($request->holiday_type_id && $request->holiday_type_id != -1) {
                $generals = $generals->where('holiday_type_id', $request->holiday_type_id);
            }

            if($request->general_year) {
                $generals = $generals->whereYear('start_date', $request->general_year);
            }

            if($request->general_month && $request->general_month != -1) {
                if($request->general_month <10)
                    $month = '0'.$request->general_month;
                else $month = $request->general_month;

                $generals = $generals->whereMonth('start_date', $month);
            }

            return datatables()->of($generals)
            ->editColumn('start_date', function ($general) {
                return date('d/m/Y', strtotime($general->start_date));
            })
            ->editColumn('day', function($general) {
                setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
                return strftime("%A", strtotime($general->start_date));
            })
            ->editColumn('action', function ($general) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="upd_approvedGeneral('.$general->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i>Approved</a> ';
          
                return $button;
            })
            ->make(true);
        }
		
		
        return view('staff.holiday_approved.tab1.index', compact('general'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function general_insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'holiday_type_id' => 'required',
            'duration' => 'required|integer',
            'start_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $type = MasterHolidayType::findOrFail($request->holiday_type_id);
        $general = Holiday::create([
            'name' => $type->name,
			'user_id'=>auth()->id(),
            'holiday_type_id' => $type->id,
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString(),
            'duration' => $request->duration,
            'created_by_user_id' => auth()->id(),
        ]);

        $log = new LogSystem;
        $log->module_id = 48;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pengurusan Cuti - Umum";
        $log->data_new = json_encode($general);
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
    public function general_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 48;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Pengurusan Cuti - Umum";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $general = Holiday::findOrFail($request->id);
        $types = MasterHolidayType::all();

        return view('staff.holiday_approved.tab1.edit', compact('general', 'types'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function general_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'holiday_type_id' => 'required',
            'duration' => 'required|integer',
            'start_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $type = MasterHolidayType::findOrFail($request->holiday_type_id);
        $general = Holiday::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 48;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengurusan Cuti - Umum";
        $log->data_old = json_encode($general);

        $general->update([
            'name' => $type->name,
			'user_id'=>auth()->id(),
            'holiday_type_id' => $type->id,
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString(),
            'duration' => $request->duration,
            'created_by_user_id' => auth()->id(),
        ]);
		

        $log->data_new = json_encode($general);
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
    public function general_delete(Request $request) {

        $general = Holiday::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 48;
        $log->activity_type_id = 6;
        $log->description = "Padam Pengurusan Cuti - Umum";
        $log->data_old = json_encode($general);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $general->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
    // General CRUD END

    // Specific CRUD START
    public function specific_index(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 48;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengurusan Cuti - Khas";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $specifics = Holiday::whereNull('holiday_type_id')->with('states');

            if($request->state_id && $request->state_id != -1) {
                $specifics = $specifics->whereHas('states', function($states) use($request){
                    $states->where('state_id', $request->state_id);
                });
            }
            if($request->specific_year) {
                $specifics = $specifics->whereYear('start_date', $request->specific_year);
            }
            if($request->specific_month && $request->specific_month != -1) {
                if($request->specific_month <10)
                    $month = '0'.$request->specific_month;
                else $month = $request->specific_month;

                $specifics = $specifics->whereMonth('start_date', $month);
            }

            return datatables()->of($specifics)
            ->editColumn('states.name', function($specific) {
                $states = [];

                foreach($specific->states as $key => $state){
                    array_push($states, $state->state->name);
                }

                return implode(", ", $states);
            })
            ->editColumn('start_date', function ($specific) {
               return date('d/m/Y', strtotime($specific->start_date));
            })
            ->editColumn('day', function($specific) {
                setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
                return strftime("%A", strtotime($specific->start_date));
            })
            ->editColumn('action', function ($specific) {
                $button = "";
                // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                $button .= '<a onclick="editSpecific('.$specific->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini</a> ';
                $button .= '<a onclick="removeSpecific('.$specific->id.')" href="javascript:;" class="btn btn-danger btn-xs mb-1"><i class="fa fa-trash mr-1"></i> Padam</a> ';

                return $button;
            })
            ->make(true);
        }

        return view('staff.holiday_approved.tab2.index', compact('specific'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function specific_insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'duration' => 'required|integer',
            'start_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $specific = Holiday::create([
            'name' => $request->name,
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString(),
            'duration' => $request->duration,
            'created_by_user_id' => auth()->id(),
        ]);

        foreach($request->states as $state) {
            $holiday_state = new HolidayState;
            $holiday_state->holiday_id = $specific->id;
            $holiday_state->state_id = $state;
            $holiday_state->save();
        }

        $log = new LogSystem;
        $log->module_id = 48;
        $log->activity_type_id = 4;
        $log->description = "Tambah Pengurusan Cuti - Khas";
        $log->data_new = json_encode($specific);
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
    public function upd_approved(Request $request) {
		
		//dd($request->id);
		$holiday_state = Holiday::where('id', $request->id)->update([
            'approved_by' => auth()->id(),
            'approved_status' => 1,
            ]);
			
        $log = new LogSystem;
        $log->module_id = 48;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Pengurusan Cuti - Khas";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $specific = Holiday::findOrFail($request->id);
        $holiday_states = HolidayState::where('holiday_id', $request->id)->get();
        $states = MasterState::all();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function specific_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'duration' => 'required|integer',
            'start_date' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $specific = Holiday::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 48;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Pengurusan Cuti - Khas";
        $log->data_old = json_encode($specific);

        $specific->update([
            'name' => $request->name,
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString(),
            'duration' => $request->duration,
            'created_by_user_id' => auth()->id(),
        ]);

        $holiday_state = HolidayState::where('holiday_id', $specific->id)->delete();

        foreach($request->states as $state) {
            $holiday_state = new HolidayState;
            $holiday_state->holiday_id = $specific->id;
            $holiday_state->state_id = $state;
            $holiday_state->save();
        }

        $log->data_new = json_encode($specific);
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
    public function specific_delete(Request $request) {

        $specific = Holiday::findOrFail($request->id);
        $holiday_state = HolidayState::where('holiday_id', $request->id)->delete();

        $log = new LogSystem;
        $log->module_id = 48;
        $log->activity_type_id = 6;
        $log->description = "Padam Pengurusan Cuti - Khas";
        $log->data_old = json_encode($specific);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $specific->delete();

       return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
    // Specific CRUD END

    // Weekend START
    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
     public function weekend_update(Request $request) {

         $weekends = MasterState::all();

         $log = new LogSystem;
         $log->module_id = 48;
         $log->activity_type_id = 5;
         $log->description = "Kemaskini Pengurusan Cuti - Minggu";
         $log->data_old = json_encode($weekends);

        foreach($weekends as $weekend) {
            $weekend->is_friday_weekend = $request->input("is_friday_".$weekend->id);
            $weekend->save();
        }

         $log->data_new = json_encode($weekends);
         $log->url = $request->fullUrl();
         $log->method = strtoupper($request->method());
         $log->ip_address = $request->ip();
         $log->created_by_user_id = auth()->id();
         $log->save();

         return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
     }
    // Weekend END
}
