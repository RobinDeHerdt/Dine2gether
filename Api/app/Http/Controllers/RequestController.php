<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Bookingdate;
Use App\Booking;

class RequestController extends Controller
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
    public function __construct(Request $request)
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
     * Create a booking request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function store(Request $request)
    {
        // Check if request exists.
        $exists = $this->user->bookingdates->contains($request->bookingdate_id);

        if ($exists) {
            return response()->json([
                'status' => 'exists'
            ]);
        }

        if ($request->bookingdate_id) {
            // Request an seat.
            $bookingdate_id = $request->bookingdate_id;
        } else {
            // Propose a new date.
            $bookingdate = new Bookingdate();

            $bookingdate->date = $request->bookingdate;
            $bookingdate->booking_id = $request->booking_id;

            $bookingdate->save();

            $bookingdate_id = $bookingdate->id;
        }

        $this->user->bookingdates()->attach($bookingdate_id, [
            'optional_message' => $request->message
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Accept a guest request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function acceptRequest(Request $request)
    {
        return response()->json(["status"=>"succes"]);
    }

    /**
     * Decline a guest request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function declineRequest(Request $request)
    {
        return response()->json(["status"=>"succes"]);
    }

    /**
     * Delete the request.
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
