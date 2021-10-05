<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkshopRegistration extends Model
{
    protected $fillable = [
        'workshop_id', 'name', 'user_id', 'gender', 'dob', 'phone', 'email', 'institution', 'passing_year', 'subject', 'education_level',
        'is_teacher', 'years_teaching', 'teaching_institution', 'school_type', 'classes', 'status', 'subjects', 'previous_training',
        'training_programs', 'online_workshop', 'ambassador', 'ambassador_ref', 'lead'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function workshop() {
        return $this->hasOne(Workshop::class, 'id', 'workshop_id');
    }
}
