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

Route::get('/search', 'BookingController@search');

Route::group(array('prefix' => 'api'), function () {
    Route::post('authenticate/login', 'AuthenticateController@login');
    Route::post('authenticate/register', 'AuthenticateController@register');
    Route::get('authenticate/logout', 'AuthenticateController@logout');
    Route::get('user/{user}/activate/{token}', 'UserController@activate');
    Route::get('user', 'UserController@show');
    Route::post('user/update', 'UserController@update');
    Route::post('user/upload', 'UserController@upload');

    Route::post('user/activation/send', 'UserController@sendActivationMail');
    Route::post('sendconfirmationrequestmail', 'ConfirmationMailController@sendConfirmationRequestMail');
    Route::post('sendbookingmails', 'ConfirmationMailController@sendBookingMails');

    Route::resource('bookings', 'BookingController', ['only' => ['index', 'store', 'destroy']]);
    Route::post('upload', 'BookingController@upload');
    Route::get('booking/{booking}', 'BookingController@show');
    Route::get('hostbookings', 'BookingController@getBookingsAsHost');
    Route::get('guestbookings', 'BookingController@getBookingsAsGuest');

    Route::post('review/{review}/delete', 'ReviewController@destroy');
    Route::get('review/guests', 'ReviewController@getGuests');
    Route::get('review/hosts', 'ReviewController@getHosts');
    Route::get('user/{user}/reviews', 'ReviewController@index');
    Route::post('review/store', 'ReviewController@store');

    Route::get('interests', 'InterestController@index');
    Route::get('kitchenstyles', 'KitchenstyleController@index');

    Route::post('request', 'RequestController@store');
    Route::post('request/delete', 'RequestController@delete');
    Route::post('request/get', 'RequestController@show');

    Route::post('bookingdate/{bookingdate}/request', 'RequestController@handleRequest');
    Route::post('bookingdate/{bookingdate}/guests/add', 'BookingdateController@addGuest');
    Route::post('bookingdate/{bookingdate}/cancel', 'BookingdateController@cancel');
});
