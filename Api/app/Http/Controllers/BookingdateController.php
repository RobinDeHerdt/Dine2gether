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
        $this->validate($request, [
            'time' => 'required',
            'date' => 'required|date|after:today',
            'max_guests' => 'required|numeric|max:3',
            'booking_id' => 'required|numeric',
        ]);

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
     * Update the specified bookingdate.
     *
     * @param  \App\Bookingdate
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Bookingdate $bookingdate, Request $request)
    {
        if ($request->date && $request->time) {
            $this->validate($request, [
                'time' => 'required',
                'date' => 'required|date|after:today',
                'max_guests' => 'required|numeric|max:100',
            ]);

            // Time
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

            return response()->json([
                'status' => 'success'
            ]);
        }

        $this->validate($request, [
            'max_guests' => 'required|numeric|max:100',
        ]);

        $bookingdate->max_guests = $request->max_guests;
        $bookingdate->save();

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
