<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestBooking extends Model
{
	public $table = "request_booking";

    public function users () {
    	$this->belongsToMany("App\User");
    }

    public function bookings () {
    	$this->belongsToMany("App\Booking");
    }
}
