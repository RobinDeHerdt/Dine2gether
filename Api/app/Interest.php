<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    /**
     * An interest belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_interest');
    }
}
