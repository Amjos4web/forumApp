<?php

namespace myLaravelFirstApp;

use Illuminate\Database\Eloquent\Model;
use \GetStream\StreamLaravel\Eloquent\ActivityTrait;

class Follow extends Model
{
    protected $fillable = ['target_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function target()
    {
        return $this->belongsTo(User::class);
    }

    public function activityNotify()
    {
        $targetFeed = \FeedManager::getNotificationFeed($this->target_id);
        return array($targetFeed);
    }

    public function activityVerb()
    {
        return 'follow';
    }

    public function activityExtraData()
    {
        return array('followed' => $this->target, 'follower' => $this->user);
    }
}
