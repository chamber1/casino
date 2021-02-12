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

Route::group(['prefix' => 'auth','middleware' => 'apitoken'], function () {
  ///api/auth/getcode
   Route::post('getcode', 'Api\ApiAuthController@getCode');
   Route::post('checkcode', 'Api\ApiAuthController@checkCode');
   Route::post('register', 'Api\ApiAuthController@register');
   Route::post('login', 'Api\ApiAuthController@login');
   Route::post('logout', 'Api\ApiAuthController@logout');
   
 
   
   
});

Route::group(['prefix' => 'forgotPassword','middleware' => 'apitoken'], function () {
    
    Route::post('getcode', 'Api\ApiForgotPasswordController@getCode');
    Route::post('checkcode', 'Api\ApiForgotPasswordController@checkCode');
    Route::post('newpassword', 'Api\ApiForgotPasswordController@newPassword');
    
});

Route::group(['prefix' => 'events','middleware' => 'apitoken'], function () {
    
    Route::post('all', 'Api\ApiEventController@events');
    
});
  