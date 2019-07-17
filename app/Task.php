<?php

namespace myLaravelFirstApp;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $casts = [
        'is_complete' => 'boolean',
    ];

    protected $fillable = [
        'title', 'description',
    ];


    public function user(){
        return $this->belongsTo('myLaravelFirstApp\User');
    }
}
