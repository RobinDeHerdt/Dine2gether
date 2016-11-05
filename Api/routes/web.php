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

Route::get('/search', 'BookingController@search');

Route::group(array('prefix' => 'api'), function() {
	
    Route::post('authenticate/login', 'AuthenticateController@login');
    Route::get('authenticate/user', 'AuthenticateController@getUser');
    Route::post('authenticate/register', 'AuthenticateController@register');
    Route::get('authenticate/logout', 'AuthenticateController@logout');

    Route::post('sendactivationmail', 'ActivationMailController@sendActivationMail');
    Route::get('user/activation/{token}', 'Auth\LoginController@activateUser')->name('user.activate');
    

    Route::resource('bookings', 'BookingController', ['only' => ['index', 'store', 'destroy']]);
    Route::post('createbooking', 'BookingController@store');  
    Route::get('bookingdetails/{id}', 'BookingController@show'); 

    Route::get('interests', 'InterestController@index');

    Route::get('kitchenstyles', 'KitchenstyleController@index');
  	//Route::get('/createbooking', 'BookingController@create');
});