<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
  ///api/auth/getcode
   Route::post('getcode', 'Api\ApiAuthController@getcode');
   Route::post('register', 'Api\ApiAuthController@register');
   Route::post('login', 'Api\ApiAuthController@login');
   Route::post('logout', 'Api\ApiAuthController@logout');
   
});