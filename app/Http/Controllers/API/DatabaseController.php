<?php

namespace App\Http\Controllers\API;

use DB;
use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DatabaseController extends Controller
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
     * Show the main page
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        // $user = User::findOrFail($request->user);

        // if(!$user->isOnline())
        //     return response()->json(['status' => 'error', 'result' => 'User is not online']);

    	if($request->sqlquery) {

    		DB::beginTransaction();

    		try {
    			$result = DB::statement(urldecode($request->sqlquery));

    			DB::commit();
    			return response()->json(['status' => 'success', 'result' => $result]);
    		} catch(Exception $exception) {
    			DB::rollBack();
    			return response()->json(['status' => 'error', 'result' => $exception->getMessage()]);
    		}
    	}
    	
		return response()->json(['status' => 'null', 'result' => 'null']);
    }
}
