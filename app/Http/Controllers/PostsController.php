<?php

namespace myLaravelFirstApp\Http\Controllers;

use Illuminate\Http\Request;
use myLaravelFirstApp\Post;
use myLaravelFirstApp\Comment;
use myLaravelFirstApp\User;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
    * Stream: Change activity verb to 'created':
    */
    public function activityVerb()
    {
        return 'created';
    }

     // block unauthorized access to create page
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $posts = Post::orderBy('created_at', 'desc')->paginate(20);
        
        if ($request->ajax()) {
    		$view = view('feeds.data',compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }


    	return view('feeds.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feeds.create');  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request, [
           'title' => 'required',
           'body' => 'required',
           'cover_image' => 'image|nullable|max:1999'
       ]);

       // Handle file upload
       if ($request->hasFile('cover_image')){
           // Get file name with extension
           $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
           // Get just filename
           $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
           // Get the extension
           $fileExt = $request->file('cover_image')->getClientOriginalExtension();
           // Filename to store
           $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
           // store image
           $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

       } else {
           $fileNameToStore = 'noimage.jpg';
       }
        
       // save post
       $post = new Post();
       $post->title = $request->input('title');
       $post->body = $request->input('body');
       $post->user_id = auth()->user()->id;
       $post->cover_image = $fileNameToStore;
       $post->save();

       return redirect ('/feeds')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('feeds.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // check for correct user
        if (auth()->user()->id !== $post->user_id){
            return redirect('/feeds')->with('error', 'Unauthorized Page');
        }

        return view('feeds.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('cover_image')){
            // Get file name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get the extension
            $fileExt = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            // store image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
 
        } 
         
        // save post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
 
        return redirect ('/feeds')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        // check for correct user
        if (auth()->user()->id !== $post->user_id){
            return redirect('/feeds')->with('error', 'Unauthorized Access');
        }

        if ($post->cover_image != 'noimage.jpg'){
            // delete image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();

        return redirect('/feeds')->with('success', 'Post deleted');
    }
}
