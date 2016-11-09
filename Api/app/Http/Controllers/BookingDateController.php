<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Bookingdate;

class BookingDateController extends Controller
{
    public function getBookingDateByDate (Request $request) {
        $bookingdate = Bookingdate::where('booking_date', $request->date_time)->where("booking_id", $request->booking_id)->first();

        return response()->json(["bookingdate" => $bookingdate]);
    }

    public function createNewBookingDate (Request $request) {
    	$bookingdate = new Bookingdate;

    	$bookingdate->booking_date 	= $request->booking_date;
    	$bookingdate->guests_booked = $request->guests;
    	$bookingdate->booking_id 	= $request->$booking_id;
    	$bookingdate->host_id 		= $request->host_id;

    	$bookingdate->save();

    	DB::table("bookingdate_user")->insert(["user_id" => $request->user_id, "bookingdate_id" => $bookingdate->id]);

    	return response()->json(["status" => "success"]);
    }

    public function addUserToBookingdate (Request $request) {

    	$bookingdate = Bookingdate::where('id', $request->bookingdate_id)->first();

    	$bookingdate->guests_booked = $bookingdate->guests_booked + $request->guests;
    	$bookingdate->save();

    	DB::table("bookingdate_user")->insert(["user_id" => $request->user_id, "bookingdate_id" => $request->bookingdate_id]);

    	return response()->json(["status" => "success"]);
    }
}
