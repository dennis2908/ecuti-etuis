<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\MasterModel\MasterIndustryType;
use App\Mail\Profile\HandedOver;
use Validator;
use App\User;
use Mail;
use Auth;

class ProfileController extends Controller
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
        $industries = MasterIndustryType::all();
    	return view('profile.index', compact('industries'));
    }

    /**
     * Display the specified image in storage.
     * @param  Request $request
     * @return Response
     */
    public function picture(Request $request) {
        abort_if(!auth()->user()->picture_url, 404);
        return Storage::disk('uploads')->download(auth()->user()->picture_url);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request) {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ];

        if(auth()->user()->user_type_id > 2)
             $rules['industry_id'] = 'required';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->picture_url && $request->file('picture_url')->isValid()) {

            if(auth()->user()->picture_url)
                Storage::disk('uploads')->delete(auth()->user()->picture_url);

            $path = Storage::disk('uploads')->putFileAs(
                'profile',
                $request->file('picture_url'),
                auth()->id().'_'.$request->file('picture_url')->getClientOriginalName()
            );

            auth()->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'picture_url' => $path,
            ]);
        }
        else {
            auth()->user()->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        if(auth()->user()->user_type_id > 2)
            auth()->user()->entity()->update(['industry_type_id' => $request->industry_id]);

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update_password(Request $request) {
        // dd($request->new_pass);
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed',

        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }


        if (!(password_verify($request->old_password, auth()->user()->password))){
            return response()->json(['status' => 'error', 'title' => 'Tidak Berjaya!', 'message' => 'Kata laluan lama tidak sepadan']);
        }

        $password = bcrypt($request->password);
        $user = User::findOrFail($request->id)->update(['password' => $password]);

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Send email to specific address
     * @param  Request $request
     * @return Response
     */
    public function handover(Request $request) {
        Mail::to($request->new_email)->send(new HandedOver(auth()->user()));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notifikasi emel akan dihantar kepada alamat berikut untuk pendaftaran akaun dan penerimaan tugas.']);
    }
}
