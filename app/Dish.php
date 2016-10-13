<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
	public function booking()
    {
        return $this->belongsTo('App\Booking');
    }
}
