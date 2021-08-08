<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'user_id', 'name', 'slug', 'short_description', 'thumbnail', 'content', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'model_id')->where('likes.model', '=', 'blog');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'model_id')->where('comments.model', '=', 'blog');
    }
}
