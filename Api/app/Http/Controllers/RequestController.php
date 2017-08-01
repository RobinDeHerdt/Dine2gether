<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Bookingdate;
use App\User;

class RequestController extends Controller
{
	
    public function store(Request $request) {

    	$requestbooking = new BookingRequest;

    	$requestbooking->date_time = $request->datetime;
    	$requestbooking->booking_id = $request->booking_id;
    	$requestbooking->user_id = $request->user_id;

    	$requestbooking->save();
        
        return response()->json(["status"=>"succes"]);
    }

    public function acceptRequest ($id) {
    	$requestbooking = BookingRequest::where('id', $id)->first();

    	$requestbooking->accepted = true;
    	$requestbooking->save();

        return response()->json(["status"=>"succes"]);
    }

    public function declineRequest ($id) {
    	$requestbooking = BookingRequest::where('id', $id)->first();

    	$requestbooking->declined = true;
    	$requestbooking->save();

        return response()->json(["status"=>"succes"]);
    }

    /**
     * Delete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function delete(Request $request)
    {
        $booking_id = $request->booking_id;
        $user_id = $request->user_id;

        Bookingdate::find($booking_id)
            ->guests()
            ->where('user_id', $user_id)
            ->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Check if the authenticated has an open request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function show(Request $request)
    {
        $booking_id = $request->booking_id;
        $user_id = $request->user_id;

        $booking_request = Bookingdate::find($booking_id)
            ->guests()
            ->where('user_id', $user_id)
            ->get();

        if ($booking_request) {
            return response()->json([
                'request' => $booking_request
            ]);
        }

        return response()->json([
            'request' => 'none'
        ]);
    }
}
