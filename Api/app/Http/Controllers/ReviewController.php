<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Bookingdate;
use App\Booking;
use App\Review;
use App\User;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // $receiver   = User::with('receiverreviews')->where('id',$id)->first();

        $reviews = Review::where('receiver_id', $id)->with('user')->get();

        return response()->json(['reviews' => $reviews]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'review'     => 'required|max:1024|regex:/(^[A-Za-z0-9 -]+$)+/',
            'guest_id'   => 'required|numeric',
        ]);

        $review     = new Review;

        $review->body           = $request->review;
        $review->receiver_id    = $request->guest_id;
        $review->author_id      = $request->author["id"];

        $review->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getGuests($id)
    {
        $bookingdates = Bookingdate::where('host_id', $id)->with('users', 'booking')->get();

        // $arrBooking = [];

        // foreach ($bookingdates as $bookingdate) {
        //     array_push($arrBooking, $bookingdate->with('booking')->get());
        // }

        return response()->json(['bookings' => $bookingdates]);
    }

    public function getHosts($id)
    {
        $user = User::where('id', $id)->first();
        $bookingdates = $user->bookingdates()->get();

        $booking_arr = [];

        foreach($bookingdates as $bookingdate) {
            $host_id    = $bookingdate->host_id;
            $hostInfo   = User::where('id', $host_id)->get();

            array_push($booking_arr, $hostInfo);
        }
        
        return response()->json(["bookings" => $booking_arr]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        $review->body           = $request->body;
        $review->rating         = $request->rating;
        $review->guest_id       = $request->guest_id;

        $review->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        $review->delete();
    }
}
