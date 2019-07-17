<?php

namespace myLaravelFirstApp\Http\Controllers;

use Illuminate\Http\Request;
use GetStream\StreamLaravel\Enrich;

class FeedsController extends Controller
{
    public function newsFeed(Request $request)
    {
        // Timeline Feed
        $feed = \FeedManager::getNewsFeeds($request->user()->id)['timeline'];
        //  get 25 most recent activities from the timeline feed:
        $activities = $feed->getActivities(0,25)['results'];
        $activities = $this->enrich()->enrichActivities($activities);

        return view ('feeds.newsfeed')>with('activities', $activities);
    }

    public function notification(Request $request)
    {
        //Notification feed:
        $feed = \FeedManager::getNotificationFeed($request->user()->id);
        //  get 25 most recent activities from the notification feed:
        $activities = $feed->getActivities(0,25)['results'];
        $activities = $this->enrich()->enrichActivities($activities);

        return view('feeds.notifications', [
            'activities' => $activities,
        ]);
    }

    private function enrich()
    {
        return new Enrich;
    }
}
