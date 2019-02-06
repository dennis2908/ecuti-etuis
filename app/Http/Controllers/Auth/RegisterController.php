<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserUnion;
use App\UserFederation;
use App\Http\Controllers\Controller;
use App\Mail\Auth\RegistrationAccepted;
use App\Mail\Auth\RegistrationRejected;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login?registered';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function verify(Request $request)
    {
        $username = $request->username;
        $code = $request->code;

        $user = User::where('username', $username)->where('user_status_id', 3)->where('password', 'LIKE', "%{$code}%");

        if($user->count() > 0) {
            $user->first()->update([ 'user_status_id' => 1 ]);
            return redirect()->route('login')->with('status', 'success')->with('title', 'Berjaya')->with('message', 'Pengesahan emel berjaya!');
        }
        else
            return redirect()->route('login')->with('status', 'error')->with('title', 'Ralat')->with('message', 'Pengesahan emel tidak berjaya!');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'uname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'phone' => 'required|string',
            'username' => 'required|string|max:150|unique:user',
            'password' => 'required|string|min:8|confirmed',
            'registered_at' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ];

        if($data['is_union'])
            $rules['name'] = 'required|string|unique:user_union';
        else
            $rules['name'] = 'required|string|unique:user_federation';

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['is_union']) {
            $entity = UserUnion::create([
                'name' => strtoupper($data['name']),
                'registered_at' => Carbon::createFromFormat('d/m/Y', $data['registered_at'])->toDateTimeString(),
            ]);
        }
        else {
            $entity = UserFederation::create([
                'name' => strtoupper($data['name']),
                'registered_at' => Carbon::createFromFormat('d/m/Y', $data['registered_at'])->toDateTimeString(),
            ]);
        }

        $user = $entity->user()->create([
            'name' => strtoupper($data['uname']),
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'user_type_id' => $data['is_union'] ? 3 : 4,
            'user_status_id' => Carbon::createFromFormat('d/m/Y', $data['registered_at'])->diffInDays(Carbon::today(), false) < (env('MAX_DAYS_AFTER_REGISTER_ENTITY')+1) ? 3 : 2,
        ])->assignRole(['ks']);


        if( Carbon::createFromFormat('d/m/Y', $data['registered_at'])->diffInDays(Carbon::today(), false) < (env('MAX_DAYS_AFTER_REGISTER_ENTITY', 30)+1) ) {
            Mail::to($user->email)->send(new RegistrationAccepted($user, $data['password']));
        }
        else
            Mail::to($user->email)->send(new RegistrationRejected($user));

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
}
