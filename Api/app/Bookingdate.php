<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookingdate extends Model
{
    /**
     * A booking date belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function guests()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * A booking date belongs to a booking.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }
}
