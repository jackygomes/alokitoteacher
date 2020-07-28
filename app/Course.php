<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos() {
        return $this->hasMany(CourseVideo::class, 'course_id', 'id');
    }

    public function quizzes() {
        return $this->hasMany(CourseQuiz::class, 'course_id', 'id');
    }

//    public function completedQuizzes() {
////        $userId = Auth::user()->id;
//        return $this->hasMany(CourseHistory::class,'user_id', $userId);
//    }


}
