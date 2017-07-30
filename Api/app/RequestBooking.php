<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestBooking extends Model
{
    public $table = "request_booking";

    /**
     * A request belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany("App\User");
    }

    /**
     * A request belongs to many bookings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function bookings()
    {
        return $this->belongsToMany("App\Booking");
    }
}
