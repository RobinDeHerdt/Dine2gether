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
     * @param \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $reviews = $user->receivedReviews()->get();

        return response()->json([
            'reviews' => $reviews
        ]);
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

        return response(200);
    }

    /**
     * Get all guests  at your bookings.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function getGuests(User $user)
    {
        $bookings = $user->bookingDates()->with('guests')->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }

    /**
     * Get all guests  at your bookings.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function getHosts(User $user)
    {
        $bookings = $user->bookingDates()->with('guests')->get();
        
        return response()->json([
            'bookings' => $bookings
        ]);
    }

    /**
     * Update the specified review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $review->body           = $request->body;
        $review->rating         = $request->rating;
        $review->guest_id       = $request->guest_id;

        $review->save();

        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response(200);
    }
}
