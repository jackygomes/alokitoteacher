<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    protected $fillable = [
        'user_id', 'institute', 'passing_year', 'exam_type', 'academic', 'academic_details', 'cgpa',
    ];
}
