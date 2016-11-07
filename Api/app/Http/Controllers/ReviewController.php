<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
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
        $receiver   = User::with('receiverreviews')->where('id',$id)->first();

        return response()->json(['user' => $receiver]);
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
        $bookings = Booking::where('host_id', $id)->with('users')->get();

        return response()->json(['bookings' => $bookings]);
    }

    public function getHosts($id)
    {
        $user = User::where('id', $id)->first();

        $booking_arr = [];

        foreach($user->bookings as $booking) {
            $hostInfo = $booking->user()->get();

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
