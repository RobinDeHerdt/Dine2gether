<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestBooking extends Model
{
    public function users () {
    	$this->BelongsToMany("App\User");
    }

    public function bookings () {
    	$this->BelongsToMany("App\Booking");
    }
}
