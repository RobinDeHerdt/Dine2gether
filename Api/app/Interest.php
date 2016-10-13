<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
