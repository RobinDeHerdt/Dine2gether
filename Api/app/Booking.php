<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * A booking belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * A booking has many dishes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function dishes()
    {
        return $this->hasMany('App\Dish');
    }

    /**
     * A booking has many bookingdates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function bookingDates()
    {
        return $this->hasMany('App\Bookingdate');
    }

    /**
     * A booking belongs to many interests.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function interests()
    {
        return $this->belongsToMany('App\Interest');
    }

    /**
     * A booking belongs to many kitchenstyles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function kitchenstyles()
    {
        return $this->belongsToMany('App\Kitchenstyle');
    }
}
