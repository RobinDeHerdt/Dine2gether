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
        $bookings = Booking::all();

        $bookingsarray = [];
        $array = [];

        foreach ($bookings as $booking) 
        {   
            $dishesarray = []; 

            $user = User::where('id', $booking->host_id)->first();
            $dishes = Dish::where('booking_id', $booking->id)->get();

            foreach ($dishes as $dish) {
                $dish_images = Dish_images::where('dish_id', $dish->id)->get();
                // dish_images in $dish steken en deze pushen in dishesarray
                $dish->dish_images = $dish_images;

                array_push($dishesarray, $dish);
            }
            // user(s) en de dishesarray in $booking steken
            $booking->users = $user;
            $booking->dishes = $dishesarray;

            // deze ene booking toevoegen aan bookingsarray
            array_push($bookingsarray, $booking);
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
