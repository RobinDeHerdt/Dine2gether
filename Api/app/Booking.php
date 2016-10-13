<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function dishes()
    {
    	return $this->hasMany('App\Dish')
    }
}