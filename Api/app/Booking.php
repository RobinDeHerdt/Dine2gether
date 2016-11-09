<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function dishes()
    {
    	return $this->hasMany('App\Dish');
    }

    public function bookingdates() 
    {
        return $this->hasMany('App\Bookingdate', 'booking_id','user_id');
    }

    public function interests()
    {
        return $this->belongsToMany('App\Interest');
    }

    public function kitchenstyles()
    {
        return $this->belongsToMany('App\Kitchenstyle');
    }
}
