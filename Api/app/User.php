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

    /**
     * A user belongs to many booking dates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function bookingdates()
    {
        return $this->belongsToMany('App\Bookingdate');
    }

    /**
     * A user belongs to many booking dates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function acceptedBookings()
    {
        return $this->belongsToMany('App\Bookingdate')->wherePivot('accepted', true);
    }

    /**
     * A user belongs to many booking dates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function bookingRequests()
    {
        return $this->belongsToMany('App\Bookingdate')->wherePivot('accepted', false);
    }

    /**
     * A user belongs to many interests.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function interests()
    {
        return $this->belongsToMany('App\Interest', 'user_interest');
    }

    /**
     * A user has many reviews.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function receivedReviews()
    {
        return $this->hasMany('App\Review', 'user_id');
    }

    /**
     * A host has many bookings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function bookings()
    {
        return $this->hasMany('App\Booking', 'host_id');
    }

    /**
     * An author has many reviews.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function createdReviews()
    {
        return $this->hasMany('App\Review', 'author_id');
    }
}
