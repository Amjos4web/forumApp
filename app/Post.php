<?php

namespace myLaravelFirstApp;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeLiked;

class Post extends Model
{
    use CanBeLiked;
    //table name
    protected $table = 'posts';
    public $primaryKey = 'id';

    public function user(){
        return $this->belongsTo('myLaravelFirstApp\User');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->orderBy('created_at', 'desc');
    }

    
}
