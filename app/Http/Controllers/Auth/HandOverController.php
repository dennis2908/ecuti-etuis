<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Validator;

class HandOverController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
    	$user = User::where('password', 'LIKE', '%'.$request->code.'%');
    	abort_if($user->count() == 0, 404);

    	$user = $user->get();

    	return view('auth.handover', compact('user'));
    }

    protected function create(Request $request) {

        $validator = Validator::make($request->all(), [
            'uname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string',
            'username' => 'required|string|max:150|unique:user',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => strtoupper($request->uname),
            'email' => $request->email,
            'phone' => $request->phone,
            'username' =>$request->username,
            'password' => bcrypt($request->password),
            'user_status_id' => 2,
        ]);

        $user->assignRole('ks');

         return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Akaun telah berjaya didaftarkan']);
    }
}
