<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    /**
     * An interest belongs to many bookings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function bookings()
    {
        return $this->belongsToMany('App\Booking');
    }

    /**
     * An interest belongs to many bookings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Booking');
    }
}
