<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Mail\Auth\RegistrationAccepted;
use App\Mail\Auth\RegistrationRejected;
use Carbon\Carbon;
use Validator;
use Mail;
use App\User;
use App\UserUnion;
use App\UserFederation;

class AuthController extends Controller
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
     * Login the user through REST API
     *
     * @return void
     */
    public function login {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:150|unique:user',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json([
                'status' => 'error',
                'code' => '006',
                'message' => 'Ralat pengesahan input pengguna.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            // Authentication passed...
            $user = auth()->user();

            if($user->user_status_id == 2) {
	            auth()->logout();
	            return response()->json([
	            	'status' => 'error',
	            	'code' => '001',
	            	'message' => 'Pendaftaran akaun anda ditolak. Sila semak emel anda untuk membuat rayuan.',
	            ]);
	        }
	        else if($user->user_status_id == 3) {
	            auth()->logout();
	            return response()->json([
	            	'status' => 'error',
	            	'code' => '002',
	            	'message' => 'Emel anda telah masih belum disahkan. Sila semak emel anda untuk panduan pengesahan.',
	            ]);
	        }
	        else if($user->user_status_id == 4) {
	            auth()->logout();
	            return response()->json([
	            	'status' => 'error',
	            	'code' => '003',
	            	'message' => 'Akaun anda telah disekat. Sila hubungi pentadbir sistem.',
	            ]);
	        }
	        else if(!$user->hasAnyRole(['union','federation'])) {
	        	auth()->logout();
	            return response()->json([
	            	'status' => 'error',
	            	'code' => '004',
	            	'message' => 'Pendaftaran kesatuan anda masih belum diluluskan.',
	            ]);
	        }
	        else {
	        	$token = $user->createToken('eTUIS')->accessToken;

	            $log = new LogSystem;
	            $log->module_id = 1;
	            $log->activity_type_id = 10;
	            $log->description = "Log masuk oleh pengguna [{$user->username}]";
	            $log->data_new = json_encode($user);
	            $log->url = $request->fullUrl();
	            $log->method = strtoupper($request->method());
	            $log->ip_address = $request->ip();
	            $log->created_by_user_id = $user->id;
	            $log->save();

	            return response()->json([
	            	'status' => 'success',
	            	'code' => '101',
	            	'message' => 'Log masuk berjaya!',
	            	'token' => $token,
	            ]);
	        }
        }
        else {
        	return response()->json([
            	'status' => 'error',
	            'code' => '005',
            	'message' => 'Maklumat akaun tidak dijumpai dalam rekod pengguna.',
            ]);
        }
    }

    /**
     * Register user through REST API
     *
     * @return void
     */
    public function register {

    	$rules = [
            'uname' => 'required|string|max:191',
            'email' => 'required|string|email|max:191',
            'phone' => 'required|string',
            'username' => 'required|string|max:150|unique:user',
            'password' => 'required|string|min:8|confirmed',
            'registered_at' => 'required|string',
        ];

        if($request->is_union)
            $rules['name'] = 'required|string|unique:user_union';
        else
            $rules['name'] = 'required|string|unique:user_federation';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // If validation failed
            return response()->json([
            	'status' => 'error',
            	'code' => '006',
            	'message' => 'Ralat pengesahan input pengguna.',
            	'errors' => $validator->errors(),
            ], 422);
        }

        if($request->is_union) {
            $entity = UserUnion::create([
                'name' => strtoupper($request->name),
                'registered_at' => Carbon::createFromFormat('d/m/Y', $request->registered_at)->toDateTimeString(),
            ]);
        }
        else {
            $entity = UserFederation::create([
                'name' => strtoupper($request->name),
                'registered_at' => Carbon::createFromFormat('d/m/Y', $request->registered_at)->toDateTimeString(),
            ]);
        }

        $user = $entity->user()->create([
            'name' => strtoupper($request->uname),
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'user_type_id' => $request->is_union ? 3 : 4,
            'user_status_id' => Carbon::createFromFormat('d/m/Y', $request->registered_at)->diffInDays(Carbon::today(), false) < (env('MAX_DAYS_AFTER_REGISTER_ENTITY')+1) ? 3 : 2,
        ])->assignRole(['ks']);

        if( Carbon::createFromFormat('d/m/Y', $request->registered_at)->diffInDays(Carbon::today(), false) < (env('MAX_DAYS_AFTER_REGISTER_ENTITY', 30)+1) ) {
            Mail::to($user->email)->send(new RegistrationAccepted($user, $request->password));
        }
        else
            Mail::to($user->email)->send(new RegistrationRejected($user));

        return response()->json([
        	'status' => 'success',
            'code' => '102',
        	'message' => 'Pendaftaran berjaya. Status pendaftaran akan dihantar melalui emel.',
        ]);
    }

    /**
     * Forgot password through REST API
     *
     * @return void
     */
    public function forgot {

        $validator = Validator::make($request->all(), [ 'email' => 'required|string|email|max:191' ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json([
            	'status' => 'error',
            	'code' => '006',
            	'message' => 'Ralat pengesahan input pengguna.',
            	'errors' => $validator->errors(),
            ], 422);
        }

        $response = Password::broker()->sendResetLink(
            $request->only('email')
        );

        if($response == Password::RESET_LINK_SENT) {
	        return response()->json([
	        	'status' => 'success',
	            'code' => '103',
	        	'message' => 'URL pemulihan telah dihantar ke emel anda.',
	        ]);
	    }
	    else {
	    	return response()->json([
	        	'status' => 'error',
	            'code' => '007',
	        	'message' => 'URL pemulihan tidak berjaya dihantar ke emel anda.',
	        ]);
	    }
    }
}
