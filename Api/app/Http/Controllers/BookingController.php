<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Bookingdate;
use App\User;
use App\Dish;
use App\DishImage;
use App\Interest;
use App\Kitchenstyle;
use App\RequestBooking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Fetch all bookings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::with([
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
            'max_nr_guests'     => 'required|numeric',
            'price'             => 'required|numeric',
            'address'           => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'postal_code'       => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'city'              => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'telephone_number'  => 'required|max:255',
        ]);

        $booking = new Booking;

        $booking->title             = $request->menu_title;
        $booking->price             = $request->price;
        // $booking->date              = $request->date;
        $booking->street_number     = $request->address;
        $booking->postalcode        = $request->postal_code;
        $booking->city              = $request->city;
        $booking->user_id           = $request->user_id;
        $booking->max_guests        = $request->max_nr_guests;
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

                $dish_image->image_url = $input_dishimage;
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

        $interests = $request->interests;
        $interests_array = [];

        foreach ($interests as $interest) {
            array_push($interests_array, $interest);
        }

        $booking->interests()->attach($interests_array);

        return response()->json([
            'status' => 'success'
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
            'user',
            'interests',
            'kitchenstyles',
            'dishes.dishimages'
        ])->get();

        return response()->json([
            'booking' => $booking
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
        $booking->interests()->detach();
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $input = $request->location;
        $location = preg_split('/[;, ]+/', $input);

        // $bookings = Booking::where('city', 'LIKE', $locations[0])->where('date', '>=', Carbon::now())->get();
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
     * Fetch all bookings for the specified user.
     *
     * @todo FOR THE LOVE OF GOD REFACTOR THIS CODE.
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function getBookingsAsHost(User $user)
    {
        $bookingdates = $user->bookingDates()->get();

        $arr_requests = [];
        $bookings = [];
        $arr_id = [];

        foreach ($bookingdates as $bookingdate) {
            $booking = $bookingdate->booking;
            $booking->date_time = $bookingdate->booking_date;
            array_push($bookings, $booking);

            if (!in_array($booking->id, $arr_id)) {
                $requests = RequestBooking::where("booking_id", $booking->id)
                    ->where('accepted', false)
                    ->where('declined', false)
                    ->get();

                foreach ($requests as $request) {
                    $user = User::where('id', $request->user_id)->first();
                    $booking = Booking::where('id', $request->booking_id)->first();
                    $request->user = $user;
                    $request->booking = $booking;
                    array_push($arr_requests, $request);
                }
            }
            array_push($arr_id, $booking->id);
        }

        return response()->json(['bookings' => $bookings, "requests" => $arr_requests]);
    }

    /**
     * Fetch all bookings for the specified user.
     *
     * @todo FOR THE LOVE OF GOD REFACTOR THIS CODE.
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function getBookingsAsGuest(User $user)
    {
        $requests = RequestBooking::where("user_id", $user->id)->get();

        $bookingdates_arr = [];
        $requests_arr = [];

        foreach ($user->bookingdates as $bookingdate) {
            $bookingdate->booking;
            $host = User::where('id', $bookingdate->host_id)->first();
            $bookingdate->host = $host;
            array_push($bookingdates_arr, $bookingdate);
        }

        foreach ($requests as $request) {
            $requestbooking = Booking::where('id', $request->booking_id)->first();
            $host = User::where('id', $requestbooking->host_id)->first();
            $request->host = $host;
            $request->booking = $requestbooking;
            array_push($requests_arr, $request);
        }
        
        return response()->json([
            'bookingdates' => $bookingdates_arr,
            "requests" => $requests
        ]);
    }
}
