<?php

namespace myLaravelFirstApp\Http\Controllers;

use Illuminate\Http\Request;
use myLaravelFirstApp\User;
use myLaravelFirstApp\Post;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return view('dashboard')->with(['posts' => $user->posts, 'tasks' => $user->tasks, 'user' => $user]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function profile()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if (auth()->user()->id !== $user->id){
            return back ('user.edit')->with('error', 'Unauthorized Access');
        }
        return view ('user.edit')->with('user', $user);
    }

    public function editProfile(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'profile_image' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('profile_image')){
            // get filename name with extension
            $fileNameExtension = $request->file('profile_image')->getClientOriginalName();
            // get filename only
            $fileName = pathinfo($fileNameExtension, PATHINFO_FILENAME); 
            // get only extension 
            $fileExt = $request->file('profile_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $path = $request->file('profile_image')->storeAs('public/images', $fileNameToStore);
        } 

        $user = User::find($id);
        $user->name = $request->input('name');
        if ($request->hasFile('profile_image')){
            $user->profile_image = $fileNameToStore;
        }
        
        if (auth()->user()->id !== $user->id){
            return redirect ('/profile')->with('error', 'Unauthorized Access');
        }
        $user->save();
        return redirect ('/profile')->with('success', 'Profile Updated');
    }

    public function users()
    {
        $users = User::where('id', '!=', auth()->user()->id)->paginate(30);
        return view ('user.index')->with('users', $users);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function user($id)
    {
        $user = User::find($id);
        return view ('user.view')->with('user', $user);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function ajaxRequest(Request $request)
    {
        $user = User::find($request->user_id);
        $response = auth()->user()->toggleFollow($user);

        return response()->json(["success" => $response]);
    }

    public function like(Request $request)
    {
        $post = Post::find($request->id);
        $response = auth()->user()->toggleLike($post);

        return response()->json(["success" => $response]);
    }
}
