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
    Route::get('authenticate/user', 'AuthenticateController@getUser');
    Route::post('authenticate/register', 'AuthenticateController@register');
    Route::get('authenticate/logout', 'AuthenticateController@logout');
    Route::post('user/activation', 'Auth\LoginController@activateUser');
    Route::post('updateprofile/{id}', 'UserController@update');

    Route::post('sendactivationmail', 'ActivationMailController@sendActivationMail');
    Route::post('resendactivationmail', 'ActivationMailController@resendActivationMail');
    Route::post('sendconfirmationrequestmail', 'ConfirmationMailController@sendConfirmationRequestMail');
    Route::post('sendbookingmails', 'ConfirmationMailController@sendBookingMails');

    Route::resource('bookings', 'BookingController', ['only' => ['index', 'store', 'destroy']]);
    Route::delete('bookings/cancel/{booking}/user/{user}', 'BookingController@cancel');
    Route::post('upload', 'BookingController@upload');
    Route::get('bookingdetails/{booking}', 'BookingController@show');
    Route::get('userbookings/{user}', 'BookingController@getBookingsAsHost');
    Route::get('guestbookings/{user}', 'BookingController@getBookingsAsGuest');

    Route::get('user/{id}', 'UserController@index');
    Route::post('/profile/upload', 'UserController@upload');

    Route::delete('review/{id}', 'ReviewController@destroy');
    Route::get('review/guests', 'ReviewController@getGuests');
    Route::get('review/hosts', 'ReviewController@getHosts');
    Route::get('user/{user}/reviews', 'ReviewController@index');
    Route::post('review/store', 'ReviewController@store');
    ;
    Route::get('interests', 'InterestController@index');

    Route::post('requestbooking', 'RequestController@storeRequest');
    Route::get('acceptrequest/{id}', 'RequestController@acceptRequest');
    Route::get('declinerequest/{id}', 'RequestController@declineRequest');
    Route::post('request/delete', 'RequestController@delete');
    Route::post('request/get', 'RequestController@show');

    Route::post('getbookingdatebydate', 'BookingDateController@getBookingDateByDate');
    Route::post('createbookingdate', 'BookingDateController@createNewBookingDate');
    Route::post('addtobookingdate', 'BookingDateController@addUserToBookingdate');

    Route::get('kitchenstyles', 'KitchenstyleController@index');
});