<?php

namespace myLaravelFirstApp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use myLaravelFirstApp\Follow;
use myLaravelFirstApp\User;

class FollowController extends Controller
{
    // block unauthorized access to create page
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $users = User::where('id', '!=', auth()->user()->id)->paginate(8);
        return view ('users.index')->with('users', $users);
    }

    public function follow(User $user){
        if (!Auth::user()->isFollowing($user->id)){
            // create an instance for authenticated user
            Auth::user()->follows()->create([
                'target_id' => $user->id,
            ]);

            \FeedManager::followUser(Auth::id(), $user->id);

            return back()->with('success', 'You are now friends with '. $user->name);
        } else {
            return back()->with('error', 'You are already following this person');
        }
    }

    public function unfollow(User $user){
        if (Auth::user()->isFollowing($user->id)) {
            $follow = Auth::user()->follows()->where('target_id', $user->id)->first();
            
            // update feed manager to unfollow
            \FeedManager::unfollowUser(Auth::id(), $follow->target_id);
            $follow->delete();

            return back()->with('success', 'You are no longer friends with '. $user->name);
        } else {
            return back()->with('error', 'You are not following this person');
        }
    }
}
