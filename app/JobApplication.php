<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    //
    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function job() {
        return $this->hasOne(Job::class, 'id', 'job_id');
    }
}
