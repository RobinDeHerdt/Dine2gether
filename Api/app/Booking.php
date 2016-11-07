<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function dishes()
    {
    	return $this->hasMany('App\Dish');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'booking_user', 'guest_id', 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'host_id');
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
