<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);


Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'],function () {

    Route::get('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
  
    //ENTITY CLIENTS
    Route::get('clients', 'Admin\ClientController@index')->name('admin.clients');
    Route::get('client/data', 'Admin\ClientController@data')->name('admin.client.data');
    
    //Test CRUD operations
    Route::group(['prefix' => 'client'], function () {
        
        Route::get('create', 'Admin\ClientController@create')->name('admin.client.create');
        Route::post('store', 'Admin\ClientController@store')->name('admin.client.store');
        Route::get('{client}/edit', 'Admin\ClientController@edit')->name('admin.client.edit');
        Route::post('{client}/update', 'Admin\ClientController@update')->name('admin.client.update');
        Route::get('{client}/confirm-delete', 'Admin\ClientController@getModalDelete')->name('client.confirm.delete');
        Route::get('{client}/delete', 'Admin\ClientController@destroy')->name('admin.client.delete');
       
    });
    
});