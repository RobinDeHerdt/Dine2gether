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
    // Authentication routes.
    Route::post('authenticate/login', 'AuthenticateController@login');
    Route::post('authenticate/register', 'AuthenticateController@register');
    Route::post('authenticate/logout', 'AuthenticateController@logout');

    // User related routes.
    Route::get('user', 'UserController@show');
    Route::get('user/interests', 'UserController@interests');
    Route::get('user/{user}', 'UserController@bookings');
    Route::get('user/{user}/activate/{token}', 'UserController@activate');
    Route::post('user/update', 'UserController@update');
    Route::post('user/upload', 'UserController@upload');

    // Email related routes.
    Route::post('user/activation/send', 'UserController@sendActivationMail');
    Route::post('sendconfirmationrequestmail', 'ConfirmationMailController@sendConfirmationRequestMail');
    Route::post('sendbookingmails', 'ConfirmationMailController@sendBookingMails');

    // Booking related routes.
    Route::resource('bookings', 'BookingController', ['only' => ['index', 'store', 'destroy']]);
    Route::post('upload', 'BookingController@upload');
    Route::get('booking/{booking}', 'BookingController@show');
    Route::get('hostbookings', 'BookingController@getBookingsAsHost');
    Route::get('guestbookings', 'BookingController@getBookingsAsGuest');

    // Review related routes.
    Route::post('review/{review}/delete', 'ReviewController@destroy');
    Route::get('review/guests', 'ReviewController@guests');
    Route::get('review/hosts', 'ReviewController@hosts');
    Route::get('user/{user}/reviews', 'ReviewController@index');
    Route::post('review/store', 'ReviewController@store');

    Route::get('interests', 'InterestController@index');
    Route::get('kitchenstyles', 'KitchenstyleController@index');

    // Request related routes.
    Route::post('request', 'RequestController@store');
    Route::post('request/delete', 'RequestController@delete');
    Route::post('request/get', 'RequestController@show');

    // Bookingdate related routes.
    Route::post('bookingdate/create', 'BookingdateController@store');
    Route::post('bookingdate/{bookingdate}/delete', 'BookingdateController@delete');
    Route::post('bookingdate/{bookingdate}/request', 'RequestController@handleRequest');
    Route::post('bookingdate/{bookingdate}/cancel', 'BookingdateController@cancel');
});
