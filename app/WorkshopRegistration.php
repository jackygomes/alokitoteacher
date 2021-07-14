<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkshopRegistration extends Model
{
    protected $fillable = [
        'name', 'user_id', 'gender', 'dob', 'phone', 'email', 'institution', 'passing_year', 'subject', 'education_level',
        'is_teacher', 'years_teaching', 'teaching_institution', 'school_type', 'classes', 'status'
    ];
}
