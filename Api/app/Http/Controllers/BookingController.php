<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Booking;
use App\User;
use App\Dish;
use App\Dish_images;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // We want to return the booking including the user(s), dish(es) and dish image(s)
        $bookings = Booking::all(); // get all bookings

        $bookingsarray = [];
        $array = [];

        foreach ($bookings as $booking) 
        {   
            $dishesarray = []; 
            // get user(s) and dish(es) for each booking
            $user = User::where('id', $booking->host_id)->first();
            $dishes = Dish::where('booking_id', $booking->id)->get();

            foreach ($dishes as $dish) { // get dish images by dish for this booking
                $dish_images = Dish_images::where('dish_id', $dish->id)->get();
                // put dish_images in $dish and push to dishesarray
                $dish->dish_images = $dish_images;

                array_push($dishesarray, $dish);
            }
            // put user(s) and dishesarray in $booking
            $booking->users = $user;
            $booking->dishes = $dishesarray;

            // add this booking to bookingsarray
            array_push($bookingsarray, $bookingsarray);
        }

        return response()->json(["bookings" => $bookingsarray]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $booking = new Booking;
        $host    = Auth::user();

        $booking->price         = $request->price;
        $booking->date          = $request->date;
        $booking->street_number = $request->street_number;
        $booking->postalcode    = $request->postalcode;
        $booking->city          = $request->city;
        
        $booking->User()->associate($host);

        $booking->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $booking = Booking::find($id);

        $booking->price         = $request->price;
        $booking->date          = $request->date;
        $booking->street_number = $request->street_number;
        $booking->postalcode    = $request->postalcode;
        $booking->city          = $request->city;

        $booking->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);
        $booking->delete();
    }
}
