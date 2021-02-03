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
    
    //CLIENTS CRUD operations
    Route::group(['prefix' => 'client'], function () {
        
        Route::get('create', 'Admin\ClientController@create')->name('admin.client.create');
        Route::post('store', 'Admin\ClientController@store')->name('admin.client.store');
        Route::get('{client}/edit', 'Admin\ClientController@edit')->name('admin.client.edit');
        Route::post('{client}/update', 'Admin\ClientController@update')->name('admin.client.update');
        Route::get('{client}/confirm-delete', 'Admin\ClientController@getModalDelete')->name('client.confirm.delete');
        Route::get('{client}/delete', 'Admin\ClientController@destroy')->name('admin.client.delete');
       
    });
    
    //ENTITY EVENTS
    Route::get('events', 'Admin\EventController@index')->name('admin.events');
    Route::get('event/data', 'Admin\EventController@data')->name('admin.event.data');
    
    //EVENTS CRUD operations
    Route::group(['prefix' => 'event'], function () {
        
        Route::get('create', 'Admin\EventController@create')->name('admin.event.create');
        Route::post('store', 'Admin\EventController@store')->name('admin.event.store');
        Route::get('{event}/edit', 'Admin\EventController@edit')->name('admin.event.edit');
        Route::post('{event}/update', 'Admin\EventController@update')->name('admin.event.update');
        Route::get('{event}/confirm-delete', 'Admin\EventController@getModalDelete')->name('event.confirm.delete');
        Route::get('{event}/delete', 'Admin\EventController@destroy')->name('admin.event.delete');
       
    });
    
    
});