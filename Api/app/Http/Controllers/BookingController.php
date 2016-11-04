<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Booking;
use App\User;
use App\Dish;
use App\Dish_Image;
use App\Interest;
use App\Kitchenstyle;
use Carbon\Carbon;

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
        $bookings       = Booking::all(); // get all bookings
        $response = $this->addToEachBooking($bookings);
        return response()->json(["bookings" => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('createbooking');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'price' => 'required',
        //     'date'  => 'required|date|after:tomorrow',
        //     'street_number' => 'required'
        // ]);


        $booking = new Booking;
        // $host    = Auth::user();

        $booking->title         = $request->title;
        $booking->price         = $request->price;
        $booking->date          = $request->date;
        $booking->street_number = $request->street_number;
        $booking->postalcode    = $request->postalcode;
        $booking->city          = $request->city;
        $booking->host_id       = 1; // Get authenticated user id here
        // $booking->User()->associate($host);

        $booking->save();


        // Loop through all dishes here
        $dish = new Dish();
        $dish->name         = $request->name;
        $dish->description  = $request->description;
        $dish->Booking()->associate($booking);

        $dish->save();


        $dish_image = new Dish_image();

        $path = $request->dish_image->store('img', 'upload');

        $dish_image->image_url      = $path;
        $dish_image->Dish()->associate($dish);

        $dish_image->save();

        // Loop through all interests here
        $interest = new Interest();
        $interest->interest = $request->interest;
        $interest->user_id  = 1; // Get authenticated user id here
        //$interest->user_id  = $request->1; // Get authenticated user id here
        // $booking->User()->associate($host);

        return redirect('/#/overview');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        $dishesarray = []; 
        // get user(s), interest(s), kitchenstyle(s) and dish(es) for each booking
        $user = User::where('id', $booking->host_id)->first();
        $interests = Interest::where('user_id', $user->id)->get();
        $dishes = Dish::where('booking_id', $booking->id)->get();
        $kitchenstyles = Kitchenstyle::where('booking_id', $booking->id)->get();
        // put interests in $user
        $user->interests = $interests;

        foreach ($dishes as $dish) { // get dish images by dish for this booking
            $dish_images = Dish_image::where('dish_id', $dish->id)->get();
            // put dish_images in $dish and push to dishesarray
            $dish->dish_images = $dish_images;
            array_push($dishesarray, $dish);
        }
        // put user(s), kitchenstyle(s) and dishesarray in $booking
        $booking->user = $user;
        $booking->kitchenstyles = $kitchenstyles;
        $booking->dishes = $dishesarray;

        return response()->json(["booking" => $booking]);
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

    public function search(Request $request)
    {
        $location = $request->location;

        $locations  = preg_split('/[;, ]+/', $location);

        $bookings   = Booking::where('city', 'LIKE', $locations[0])
                             /*->where('date', '>=', Carbon::now())*/->get();

        $response = $this->addToEachBooking($bookings);
        return response()->json(["bookings" => $response]);
    }

    // aparte functie (properder)
    public function addToEachBooking ($bookings) {

        $bookingsarray  = [];

        foreach ($bookings as $booking) 
        {   
            $dishesarray = []; 
            // get user(s), interest(s), kitchenstyle(s) and dish(es) for each booking
            $user           = User::where('id', $booking->host_id)->first();
            $interests      = Interest::where('user_id', $user->id)->get();
            $dishes         = Dish::where('booking_id', $booking->id)->get();
            $kitchenstyles  = Kitchenstyle::where('booking_id', $booking->id)->get();
            // put interests in $user
            $user->interests = $interests;

            foreach ($dishes as $dish) { // get dish images by dish for this booking
                $dish_images = Dish_Image::where('dish_id', $dish->id)->get();
                // put dish_images in $dish and push to dishesarray
                $dish->dish_images = $dish_images;
                array_push($dishesarray, $dish);
            }
            // put user(s), kitchenstyle(s) and dishesarray in $booking
            $booking->user          = $user;
            $booking->kitchenstyles = $kitchenstyles;
            $booking->dishes        = $dishesarray;

            // add this booking to bookingsarray
            array_push($bookingsarray, $booking);
        }

        return $bookingsarray;
    }
}
