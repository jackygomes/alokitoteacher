<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable = [
        'name', 'thumbnail', 'description', 'price', 'preview_video', 'trainers', 'type', 'duration', 'total_credit_hours',
        'date_time', 'last_date'
    ];
}
