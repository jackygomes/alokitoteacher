<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos() {
        return $this->hasMany(CourseVideo::class, 'course_id', 'id');
    }

    public function questions() {
        return $this->hasMany(CourseVideo::class, 'course_id', 'id');
    }
}
