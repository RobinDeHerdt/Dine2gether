<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * A review belongs to an author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    /**
     * A review belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
