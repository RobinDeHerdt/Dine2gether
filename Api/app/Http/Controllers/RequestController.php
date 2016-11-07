<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\RequestBooking;

class RequestController extends Controller
{
	public function showUnacceptedRequests ($userid) {

		$bookings = User::where("id", $userid)->bookings()->get();

		$request_collection = [];
		foreach($bookings as $booking) {
			$requests = RequestBooking::where("booking_id", $booking->id)->where("accepted", false)->get();
			array_push($request_collection, $requests);
		}

		return response()->json(["requests" => $request_collection]);
	}
	
    public function storeRequest (Request $request) {

    	$requestbooking = new RequestBooking;

    	$requestbooking->date_time = $request->datetime;
    	$requestbooking->number_of_guests = $request->number_of_guests;
    	$requestbooking->booking_id = $request->booking_id;
    	$requestbooking->user_id = $request->user_id;

    	$requestbooking->save();



    }
}
