<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OtherModel\ComplaintExternal;
use Validator;

class ComplaintController extends Controller
{
    /**
     * Store the external complaint through REST API
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'complaint' => 'required|string',
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

        ComplaintExternal::insert($request->only('name','email','complaint'));

        return response()->json([
        	'status' => 'success',
            'code' => '104',
        	'message' => 'Aduan telah diterima oleh pihak JHEKS.',
        ]);
    }
}
