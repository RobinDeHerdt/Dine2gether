<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Bookingdate;
use Carbon\Carbon;

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
     * Store the newly created bookingdate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bookingdate = new Bookingdate();

        $carbon_time = Carbon::parse($request->time);

        $hr  = $carbon_time->hour;
        $min = $carbon_time->minute;
        $sec = $carbon_time->second;

        // Date
        $carbon_date = Carbon::parse($request->date);

        $yr  = $carbon_date->year;
        $mnt = $carbon_date->month;
        $day = $carbon_date->day;

        $bookingdate->date = Carbon::create($yr, $mnt, $day, $hr, $min, $sec);
        $bookingdate->max_guests = $request->max_guests;
        $bookingdate->host_approved = true;
        $bookingdate->booking_id = $request->booking_id;

        $bookingdate->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Add the authenticated user as a guest to the specified booking date.
     *
     * @todo Notify the host through email.
     * @param \App\Bookingdate
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
     * @todo Notify the host through email.
     * @param  \App\Bookingdate  $bookingdate
     * @return \Illuminate\Http\Response
     */
    public function cancel(Bookingdate $bookingdate)
    {
        $this->user->bookingdates()->detach($bookingdate->id);

        return response(200);
    }

    /**
     * Remove the specified booking date.
     *
     * @todo Notify all guests through email.
     * @param  \App\Bookingdate  $bookingdate
     * @return \Illuminate\Http\Response
     */
    public function delete(Bookingdate $bookingdate)
    {
        $bookingdate->guests()->detach();
        $bookingdate->delete();

        return response(200);
    }
}
