<?php

namespace App\Http\Controllers;

use App\Booking;
use App\User;
use App\Dish;
use App\DishImage;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class BookingController extends Controller
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
        })->except('index', 'show', 'search');
    }

    /**
     * Fetch all bookings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::with([
            'host.interests',
            'kitchenstyles',
            'dishes.dishimages'
        ])->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }

    /**
     * Display the specified booking.
     *
     * @param \App\Booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $booking = Booking::where('id', $booking->id)->with([
            'host.interests',
            'kitchenstyles',
            'bookingdates.guests',
            'dishes.dishimages'
        ])->get();

        return response()->json([
            'booking' => $booking
        ]);
    }

    /**
     * Handles multiple image upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // $this->validate($request, [
        //     'files'    => 'required|mimes:jpg,jpeg,png,bmp|max:20000',
        // ]);

        $uploaded_files = $request->all();

        $paths_array = [];

        foreach ($uploaded_files["files"] as $uploaded_file) {
            $path = $uploaded_file->store('images', 'upload');
            array_push($paths_array, $path);
        }

        return response()->json([
            "paths" => $paths_array
        ]);
    }

    /**
     * Store the newly created booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'menu_title'        => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'price'             => 'required|numeric',
            'address'           => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'postal_code'       => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'city'              => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'telephone_number'  => 'required|max:255',
        ]);

        $booking = new Booking;

        $booking->title             = $request->menu_title;
        $booking->price             = $request->price;
        $booking->street_number     = $request->address;
        $booking->postalcode        = $request->postal_code;
        $booking->city              = $request->city;
        $booking->host_id           = $request->user_id;
        $booking->telephone_number  = $request->telephone_number;

        $booking->save();

        $input_dishes = $request->dishes;

        foreach ($input_dishes as $input_dish) {
            $dish = new Dish();
            $dish->name = $input_dish["dish_name"];
            $dish->description = $input_dish["description"];

            $dish->booking()->associate($booking);

            $dish->save();

            foreach ($input_dish["dish_img"] as $input_dishimage) {
                $dish_image = new DishImage();

                $dish_image->image_uri = $input_dishimage;
                $dish_image->dish()->associate($dish);

                $dish_image->save();
            }
        }

        $kitchenstyles = $request->kitchenstyles;
        $kitchenstyles_array = [];

        foreach ($kitchenstyles as $kitchenstyle) {
            array_push($kitchenstyles_array, $kitchenstyle);
        }

        $booking->kitchenstyles()->attach($kitchenstyles_array);

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $booking->price         = $request->price;
        $booking->date          = $request->date;
        $booking->street_number = $request->street_number;
        $booking->postalcode    = $request->postalcode;
        $booking->city          = $request->city;

        $booking->save();

        return response(200);
    }

    /**
     * Remove the specified booking.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $bookingdates = $booking->bookingDates()->get();

        foreach ($bookingdates as $bookingdate) {
            $bookingdate->users()->detach();
        }

        $booking->bookingDates()->delete();
        $booking->kitchenstyles()->detach();

        $dishes = $booking->dishes()->get();

        foreach ($dishes as $dish) {
            $dish->dishImages()->delete();
            $dish->delete();
        }

        $booking->delete();

        return response(200);
    }

    /**
     * Remove the specified booking.
     *
     * @param  \App\Booking  $booking
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function cancel(Booking $booking, User $user)
    {
        $user->bookingdates()->detach($booking->id);
        $user->save();

        return response(200);
    }

    /**
     * Fetch all bookings for the specified location.
     * @todo only fetch bookings with bookingdates after "Carbon::now"
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $input = $request->location;
        $location = preg_split('/[;, ]+/', $input);

        $bookings = Booking::where('city', 'LIKE', $location[0])->with([
            'user',
            'interests',
            'kitchenstyles',
            'dishes.dishimages'
        ])->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }

    /**
     * Fetch all hosted bookings for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBookingsAsHost()
    {
        $bookings = $this->user->bookings()->with('bookingdates')->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }

    /**
     * Fetch all attended bookings for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBookingsAsGuest()
    {
        $bookingdates = $this->user->acceptedBookings()->with('booking')->get();

        return response()->json([
            'bookingdates' => $bookingdates
        ]);
    }
}
