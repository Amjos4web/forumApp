<?php

namespace myLaravelFirstApp;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeLiked;

class Comment extends Model

{
    use CanBeLiked;
    
    protected $fillable = ['user_id', 'post_id', 'parent_id', 'body'];

    // This means a comment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // this method is saying replies belongs to a comment
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'desc');
    }
}
