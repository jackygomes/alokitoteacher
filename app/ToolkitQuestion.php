<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToolkitQuestion extends Model
{
    protected $guarded = [];
    /**
     * Returns attached options for the Quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quizOptions()
    {
        return $this->hasMany(ToolkitQuizOption::class, 'question_id', 'id');
    }
}
