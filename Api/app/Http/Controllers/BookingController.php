<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Booking;
use App\User;
use App\Dish;
use App\Dish_Image;
use App\Interest;
use App\Kitchenstyle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

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
    public function upload(Request $request)
    {
        $uploadedFiles = $request->all();
        
        $i = 0;
        $pathNames = array();

        foreach ($uploadedFiles["files"] as $uploadedFile) 
        {
            $path = $uploadedFile->store('img', 'upload');
            array_push($pathNames, $path);
            $i++;           
        }

        return response()->json(["filenaam" => $pathNames]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'menu_title'         => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'date'          => 'required|date|after:tomorrow',
            'price'         => 'required|numeric',
            'address' => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'postal_code'    => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'city'          => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
        ]);

        // dd($request->all());

        $booking = new Booking;

        $booking->title         = $request->menu_title;
        $booking->price         = $request->price;
        $booking->date          = $request->date;
        $booking->street_number = $request->address;
        $booking->postalcode    = $request->postal_code;
        $booking->city          = $request->city;
        $booking->host_id       = $request->user_id;

        $booking->save();

        
        // Loop through all dishes here
        $dishes = $request->dishes;

        foreach ($dishes as $newdish) 
        {
            $dish = new Dish();
            $dish->name         = $newdish["dish_name"];
            $dish->description  = $newdish["description"];
            $dish->Booking()->associate($booking);

            $dish->save();

            foreach ($newdish["dish_img"] as $newdishimage) 
            {
                $dish_image = new Dish_image();

                $dish_image->image_url  = $newdishimage;
                $dish_image->Dish()->associate($dish);

                $dish_image->save();
            }
        }

        $kitchenstyles = $request->kitchenstyles;

        foreach ($kitchenstyles as $style) 
        {
            $style = Kitchenstyle::where('style',$style)->first();

            DB::table('booking_kitchenstyle')->insert(['booking_id' => $booking->id, 'kitchenstyle_id' => $style->id]);
        }
       
        
        // Loop through all interests here
        $interests = $request->interests;
        $arr_length = count($interests);

        for ($x = 0; $x < $arr_length; $x++) {
            $interest = Interest::where('interest', $interests[$x])->first();
            $interestid = $interest->id;
            DB::table('booking_interest')->insert(
                ['booking_id' => $booking->id, 'interest_id' => $interestid]
            );
        }

        return response()->json(['status' => 'success']);
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
        $interests = $booking->interests()->get();;
        $dishes = Dish::where('booking_id', $booking->id)->get();
        $kitchenstyles = $booking->kitchenstyles()->get();
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
            $interests      = $booking->interests()->get();
            $dishes         = Dish::where('booking_id', $booking->id)->get();
            $kitchenstyles  = $booking->kitchenstyles()->get();
            // put interests in $user

            foreach ($dishes as $dish) { // get dish images by dish for this booking
                $dish_images = Dish_Image::where('dish_id', $dish->id)->get();
                // put dish_images in $dish and push to dishesarray
                $dish->dish_images = $dish_images;
                array_push($dishesarray, $dish);
            }

            // put user(s), kitchenstyle(s) and dishesarray in $booking
            $booking->user          = $user;
            $booking->dishes        = $dishesarray;
            $booking->interests     = $interests;
            $booking->kitchenstyles = $kitchenstyles;
            // add this booking to bookingsarray
            array_push($bookingsarray, $booking);
        }

        return $bookingsarray;
    }

    public function getUserBookings($id)
    {
        $bookings = Booking::where('host_id', $id)->get();

        return response()->json(['bookings' => $bookings]);
    }
}
