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
    Route::post('user/activation', 'Auth\LoginController@activateUser');
    Route::post('updateprofile/{id}', 'UserController@update');

    Route::post('sendactivationmail', 'ActivationMailController@sendActivationMail');
    Route::post('resendactivationmail', 'ActivationMailController@resendActivationMail'); 
    Route::post('sendconfirmationrequestmail', 'ConfirmationMailController@sendConfirmationRequestMail');

    Route::resource('bookings', 'BookingController', ['only' => ['index', 'store', 'destroy']]);
    Route::delete('bookings/detach/{id}/user/{userid}','BookingController@detach');
    Route::delete('review/{id}', 'ReviewController@destroy');
    Route::get('user/{id}', 'UserController@index');
    Route::get('review/guests/{id}', 'ReviewController@getGuests');
    Route::get('review/hosts/{id}', 'ReviewController@getHosts');
    Route::get('user/{id}/reviews', 'ReviewController@index');
    Route::post('upload', 'BookingController@upload');
    Route::post('/profile/upload', 'UserController@upload');
    Route::post('createreview', 'ReviewController@store');  
    Route::get('bookingdetails/{id}', 'BookingController@show'); 
    Route::get('userbookings/{id}', 'BookingController@getUserBookings');
    Route::get('guestbookings/{id}', 'BookingController@getGuestBookings');
    Route::get('interests', 'InterestController@index');
    Route::post('requestbooking', 'RequestController@storeRequest');
    Route::get('acceptrequest/{id}', 'RequestController@acceptRequest');
    Route::get('declinerequest/{id}', 'RequestController@declineRequest');
    Route::get('deleterequest/{id}', 'RequestController@deleteRequest');
    Route::post('hasrequest', 'RequestController@checkIfRequest');
    Route::post('getrequest', 'RequestController@getRequestById');

    Route::get('kitchenstyles', 'KitchenstyleController@index');
  	//Route::get('/createbooking', 'BookingController@create');
});