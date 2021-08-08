<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'model', 'model_id', 'user_id', 'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
