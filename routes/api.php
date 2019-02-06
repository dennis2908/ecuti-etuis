<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');
Route::post('forgot', 'API\AuthController@forgot');

Route::middleware('auth:api')->group(function () {
	Route::post('database', 'API\DatabaseController@index');
	Route::post('complaint', 'API\ComplaintController@index');
});
