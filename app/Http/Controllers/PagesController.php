<?php

namespace myLaravelFirstApp\Http\Controllers;

use Illuminate\Http\Request;
use myLaravelFirstApp\Post;

class PagesController extends Controller
{
    public function index(){
        $posts = Post::orderBy('created_at', 'desc')->take(4)->get();
        return view ('pages.index')->with('posts', $posts);
    }

    public function about(){
        return view ('pages.about');
    }

    public function chat(){
        return view('pages.chat');
    }
}
