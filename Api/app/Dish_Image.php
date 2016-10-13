<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish_Image extends Model
{
    public function dish()
    {
    	return $this->belongsTo('App\Dish');
    }
}
