<?php

namespace myLaravelFirstApp\Http\Controllers;

use myLaravelFirstApp\Events\ChatEvent;
use Illuminate\Http\Request;
use myLaravelFirstApp\User;
use illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function chat()
    {
        return view ('pages.chat');
    }

    public function send(Request $request)
    {
        $user = User::find(Auth::id());
        $message = $request->message;
        $this->saveToSession($request);
        event (new ChatEvent($message, $user));

    }

    public function saveToSession(Request $request)
    {
        session()->put('chat', $request->chat);
    }
}
