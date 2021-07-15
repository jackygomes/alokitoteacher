<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable = [
        'name', 'slug', 'thumbnail', 'description', 'price', 'preview_video', 'trainers', 'type', 'duration', 'total_credit_hours',
        'date_time', 'last_date', 'starting_date', 'about_this_workshop', 'what_you_will_learn', 'status'
    ];
}
