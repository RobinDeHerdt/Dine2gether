<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\RequestBooking;
use App\User;

class RequestController extends Controller
{
	
    public function storeRequest (Request $request) {

    	$requestbooking = new RequestBooking;

    	$requestbooking->date_time = $request->datetime;
    	$requestbooking->booking_id = $request->booking_id;
    	$requestbooking->user_id = $request->user_id;

    	$requestbooking->save();
        
        return response()->json(["status"=>"succes"]);
    }

    public function acceptRequest ($id) {
    	$requestbooking = RequestBooking::where('id', $id)->first();

    	$requestbooking->accepted = true;
    	$requestbooking->save();

        return response()->json(["status"=>"succes"]);
    }

    public function declineRequest ($id) {
    	$requestbooking = RequestBooking::where('id', $id)->first();

    	$requestbooking->declined = true;
    	$requestbooking->save();

        return response()->json(["status"=>"succes"]);
    }

    public function deleteRequest ($id) {

        $requestbooking = RequestBooking::where('id', $id)->delete();

        return response()->json(["status" => "success"]);
    }

    public function checkIfRequest (Request $request) {

        $user_request = RequestBooking::where('user_id', $request->user_id)->where("booking_id", $request->booking_id)->first();

        $response = "none";
        if($user_request) {
            $response = $user_request;
        }

        return response()->json(["request" => $response]);
    }

    public function getRequestById (Request $request) {

        $myrequest = RequestBooking::where('user_id', $request->user_id)->where('booking_id', $request->booking_id)->first();

        return response()->json(["request" => $myrequest]);
    }
}
