<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseQuestion extends Model
{
    protected $guarded = [];
    /**
     * Returns attached options for the Quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quizOptions()
    {
        return $this->hasMany(CourseQuizOption::class, 'question_id', 'id');
    }
}
