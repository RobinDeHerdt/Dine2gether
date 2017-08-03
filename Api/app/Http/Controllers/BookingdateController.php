<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Bookingdate;

class BookingdateController extends Controller
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
        });
    }

    /**
     * Add the authenticated user as a guest to the specified booking date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addGuest(Bookingdate $bookingdate, Request $request)
    {
        $bookingdate->guests()->attach($request->guest_id);

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the authenticated user as a guest from the specified booking date.
     *
     * @param  \App\Bookingdate  $booking_date
     * @return \Illuminate\Http\Response
     */
    public function cancel(Bookingdate $booking_date)
    {
        $this->user->bookingdates()->detach($booking_date->id);

        return response(200);
    }
}
