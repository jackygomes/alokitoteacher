<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'user_id', 'training_title', 'topic', 'institute', 'country', 'location', 'year', 'duration',
    ];
}