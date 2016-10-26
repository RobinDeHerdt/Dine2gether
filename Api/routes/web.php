<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function() {
    return View::make('index'); // app/views/index.php
});


 Route::group(array('prefix' => 'api'), function() {

	Route::resource('bookings', 'bookingController', ['only' => ['index', 'store', 'destroy']]);
	
    Route::post('authenticate', 'AuthenticateController@login');
    Route::get('authenticate/user', 'AuthenticateController@getUser');
  
 });