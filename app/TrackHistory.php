<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackHistory extends Model
{
    //
    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
