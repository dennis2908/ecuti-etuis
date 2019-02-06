<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\LogModel\LogSystem;
use App\User;
use App\OtherModel\Announcement;
use App\Role;
use Carbon\Carbon;
use Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {   
        $list_announcements = Announcement::where('date_start', '<=', Carbon::today()->toDateString())
            ->where('date_end', '>=', Carbon::today()->toDateString())->whereHas('targets', function($targets){
            $targets->where('role_id', 3);
        })->orderBy('date_start', 'DESC')->get();
        $list_announcements = $list_announcements->groupBy('date_start');
        
        return view('auth.login', compact('list_announcements'));
    }

    public function announcement(Request $request)
    {   
        $announcement = Announcement::findOrFail($request->id);
        return view('auth.announcement', compact('announcement'));
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated($request, $user)
    {
        if($user->user_status_id == 2) {
            auth()->logout();
            return redirect()->route('login')->with('status', 'error')->with('title', 'Ralat')->with('message', 'Pendaftaran akaun anda ditolak. Sila semak emel anda untuk membuat rayuan.');
        }
        else if($user->user_status_id == 3) {
            auth()->logout();
            return redirect()->route('login')->with('status', 'error')->with('title', 'Ralat')->with('message', 'Emel anda masih belum disahkan. Sila semak emel anda untuk panduan pengesahan.');
        }
        else if($user->user_status_id == 4) {
            auth()->logout();
            return redirect()->route('login')->with('status', 'error')->with('title', 'Ralat')->with('message', 'Akaun anda telah disekat. Sila hubungi pentadbir sistem.');
        }
        else {
            $log = new LogSystem;
            $log->module_id = 1;
            $log->activity_type_id = 7;
            $log->description = "Log masuk oleh pengguna [{$user->username}]";
            $log->data_new = json_encode($user);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = $user->id;
            $log->save();

            $token = Cookie::forever("api_token", $user->createToken('eTUIS')->accessToken);

            if($user->user_type_id == 3 && !$user->hasRole('union') && (($user->entity->formb && $user->entity->formb->filing_status_id == 1) || !$user->entity->formb))
                return redirect()->route('formb')->cookie($token);

            if($user->user_type_id == 4 && !$user->hasRole('federation') && (($user->entity->formbb && $user->entity->formbb->filing_status_id == 1) || !$user->entity->formbb))
                return redirect()->route('formbb')->cookie($token);

            return redirect()->route('home')->cookie($token);
        }
    }

    public function autologin(Request $request)
    {
        $user = User::findOrFail($request->id);
        auth()->login($user);

        $log = new LogSystem;
        $log->module_id = 1;
        $log->activity_type_id = 7;
        $log->description = "Log masuk (auto) oleh pengguna [{$user->username}]";
        $log->data_new = json_encode($user);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = $request->id;
        $log->save();

        $token = Cookie::forever("api_token", $user->createToken('eTUIS')->accessToken);

        if($user->user_type_id == 3 && !$user->hasRole('union') && (($user->entity->formb && $user->entity->formb->filing_status_id == 1) || !$user->entity->formb))
            return redirect()->route('formb')->cookie($token);

        if($user->user_type_id == 4 && !$user->hasRole('federation') && (($user->entity->formbb && $user->entity->formbb->filing_status_id == 1) || !$user->entity->formbb))
            return redirect()->route('formbb')->cookie($token);

        return redirect()->route('home')->cookie($token);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            $log = new LogSystem;
            $log->module_id = 1;
            $log->activity_type_id = 8;
            $log->description = "Log keluar oleh pengguna [".auth()->user()->username."]";
            $log->data_old = json_encode(auth()->user());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $this->guard()->logout();

            $request->session()->invalidate();

            $token = Cookie::forget('api_token');

            return redirect('/')->cookie($token);
        }
        catch(\Exception $e) {
            return redirect('/');
        }
        
    }
}
