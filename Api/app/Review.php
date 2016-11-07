<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }
}
