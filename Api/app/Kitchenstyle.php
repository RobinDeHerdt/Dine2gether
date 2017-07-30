<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchenstyle extends Model
{
    /**
     * A kitchenstyle belongs to many bookings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function bookings()
    {
        return $this->belongsToMany('App\Booking');
    }
}
