<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    /**
     * A dish belongs to a booking.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }

    /**
     * A dish has many images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function dishImages()
    {
        return $this->hasMany('App\DishImage');
    }
}
