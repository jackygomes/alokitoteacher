<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toolkit extends Model
{
    /**
     * Return associated subject
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subject() {
        return $this->hasone(Subject::class, 'id', 'subject_id');
    }
}
