<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','email', 'password', 'image', 'street_number', 'postalcode', 'city',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function bookingdates()
    {
        // return $this->belongsToMany('App\Booking');
        return $this->belongsToMany('App\Bookingdate','booking_user', 'booking_id', 'user_id');
    }

    public function booking()
    {
        return $this->hasMany('App\Booking', 'host_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review', 'author_id');
    }
}
