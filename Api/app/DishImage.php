<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DishImage extends Model
{
    /**
     * A dish image belongs to a dish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function dish()
    {
        return $this->belongsTo('App\Dish');
    }
}
