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
        return $this->belongsToMany('App\User');
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
