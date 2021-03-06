<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use App\Review;
use App\User;

class ReviewController extends Controller
{
    /**
     * Contains the authenticated user.
     *
     * @var \App\User
     */
    private $user;

    /**
     * Constructor.
     *
     * Get the authenticated user and save it to the $user variable.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            try {
                if (!$this->user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
                }
            } catch (TokenExpiredException $e) {
                return response()->json(['token_expired'], $e->getStatusCode());
            } catch (TokenInvalidException $e) {
                return response()->json(['token_invalid'], $e->getStatusCode());
            } catch (JWTException $e) {
                return response()->json(['token_absent'], $e->getStatusCode());
            }

            return $next($request);
        })->except('index');
    }

    /**
     * Fetch all the specified users' reviews.
     *
     * @param \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $reviews = $user->receivedReviews()->with('author')->get();

        return response()->json([
            'reviews' => $reviews,
            'user' => $user
        ]);
    }

    /**
     * Store the newly created review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'review' => 'required|max:1024',
            'booking' => 'required|numeric',
            'user' => 'required|numeric'
        ]);

        $review = new Review;

        $review->body = $request->review;
        $review->user_id = $request->user;
        $review->booking_id = $request->booking;
        $review->author_id = $this->user->id;

        $review->save();

        return response(200);
    }

    /**
     * Update the specified review.
     *
     * @param  \App\Review  $review
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $review->body = $request->body;
        $review->rating = $request->rating;
        $review->user_id = $request->user_id;
        $review->author_id = $this->user->id;

        $review->save();

        return response(200);
    }

    /**
     * Remove the specified review.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if ($this->user->id === $review->author_id) {
            $review->delete();

            return response([
                'status' => 'success'
            ]);
        }

        return response([
            'status' => 'failed'
        ]);
    }

    /**
     * Get all past bookings where the authenticated user is a host.
     *
     * @return \Illuminate\Http\Response
     */
    public function guests()
    {
        $bookings = $this->user->bookings()->with(['bookingdates' => function ($q) {
            $q->where('date', '<', Carbon::now());
            $q->with('guests');
        }])->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }

    /**
     * Get all past bookings where the authenticated user is a guest.
     *
     * @return \Illuminate\Http\Response
     */
    public function hosts()
    {
        $bookings = $this->user->acceptedBookingDates()
            ->where('date', '<', Carbon::now())
            ->with('booking.host')
            ->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }
}
