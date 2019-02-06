<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OtherModel\ComplaintExternal;
use Validator;

class ComplaintController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'complaint' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            // If validation failed
            return response()->json(['errors' => $validator->errors()], 422);
        }

        ComplaintExternal::insert($request->only('name','email','complaint'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Aduan anda telah diterima oleh pihak JHEKS.']);
    }
}
