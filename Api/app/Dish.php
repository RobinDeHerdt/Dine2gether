<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
	public function booking()
    {
        return $this->belongsTo('App\Booking');
    }

    public function dish_images()
    {
        return $this->hasMany('App\Dish_image');
    }
}
