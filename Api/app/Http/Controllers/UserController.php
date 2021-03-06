<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mail\ActivateUser;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\User;

class UserController extends Controller
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
        })->except('activate', 'bookings');
    }

    /**
     * Compare the token the user sent us with the token stored in the database.
     * If true, give the user the 'active' status.
     *
     * @param  \App\User  $user
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function activate(User $user, $token)
    {
        $url = env('APP_URL') . '/#/home?status=';

        if ($user->activated == true) {
            return redirect($url . 'already-activated');
        } else {
            if ($user->token === $token) {
                $user->activated = true;
                $user->save();

                return redirect($url . 'activated');
            }
        }

        return redirect($url . 'failed');
    }

    /**
     * Fetch bookings where the specified user is host.
     *
     * @param  \App\User
     * @return \Illuminate\Http\Response
     */
    public function bookings(User $user)
    {
        $bookings = $user->bookings()->with([
            'bookingdates',
            'dishes.dishimages'
        ])->get();

        $latest_reviews = $user->receivedReviews()
            ->orderBy('created_at', 'desc')
            ->with(['author', 'booking'])
            ->take(3)
            ->get();

        if ($user->receivedReviews()->count() > 3) {
            $user->has_more_reviews = true;
        }

        $user = $user->load('interests');

        return response()->json([
            'bookings' => $bookings,
            'latest_reviews' => $latest_reviews,
            'user' => $user
        ]);
    }

    /**
     * Get the authenticated user.
     * Fetch the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return response()->json([
            'user' => $this->user->makeVisible([
                'email', 'street_number'
            ])
        ]);
    }

    /**
     * Upload a new profile picture.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'file|image|max:2000',
        ]);

        $path = $request->file->store('images/profile', 'upload');

        $this->user->image = $path;
        $this->user->save();

        return response()->json([
            'filename' => $path
        ]);
    }

    /**
     * Update the authenticated in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name'    => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'last_name'     => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'email'         => 'required|email|max:255',
            'street_number' => 'max:255',
            'postalcode'    => 'max:255',
            'city'          => 'max:255',
        ]);

        $this->user->interests()->sync($request->interests);

        $this->user->first_name = $request->first_name;
        $this->user->last_name = $request->last_name;
        $this->user->email = $request->email;
        $this->user->street_number = $request->street_number;
        $this->user->postalcode = $request->postalcode;
        $this->user->city = $request->city;

        $this->user->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Fetch the interests for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function interests()
    {
        $interests = $this->user->interests()->get();

        return response()->json([
            'userinterests' => $interests->makeHidden(['name', 'pivot'])
        ]);
    }


    /**
     * Send an activation e-mail to the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendActivationMail()
    {
        Mail::to($this->user->email)->send(new ActivateUser($this->user));

        return response()->json([
            'status' => 'success'
        ]);
    }
}
