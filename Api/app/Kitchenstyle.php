<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchenstyle extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * A kitchenstyle belongs to many bookings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function bookings()
    {
        return $this->belongsToMany('App\Booking');
    }
}
