<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResourceRating;

class Resource extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function ratingCount() {
        // $count = ResourceRating::where('resource_id', 'id')->count();
        return $this->hasMany(ResourceRating::class, 'resource_id', 'id');
    }
}
