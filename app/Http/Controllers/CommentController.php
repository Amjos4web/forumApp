<?php

namespace myLaravelFirstApp\Http\Controllers;

use Illuminate\Http\Request;
use myLaravelFirstApp\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
       
        $this->validate($request, [
            'comment' => 'required',
        ]);
        if (Auth::user()){
            $comment = new Comment();
            $comment->body = $request->input('comment');
            $comment->user_id = auth()->user()->id;
            $comment->post_id = $request->input('post_id');
            $comment->parent_id = $request->input('parent_id');

            $comment->save();
        
            return back();
        }
    }

    public function replyComment(Request $request)
    {
        if (Auth::user()){
            
            
            try{
                $comment = new Comment();
                $comment->body = $request->comment;
                $comment->user_id = auth()->user()->id;
                $comment->post_id = $request->post_id;
                $comment->parent_id = $request->comment_id;
                $comment->save();
                return response()->json(["success" => array("success"=>TRUE)]);
            }
            catch(Exception $e){
                return response()->json(["success" => array("success"=>$e->getMessage())]);
            }
            

            //return response()->json(["success" => $comment]);
        } else {
            return response()->json(["success", false]);
        }
        
    }

    public function editComment(Request $request, $id)
    {
        $this->validate($request, [
            'comment-body' => 'required',
        ]);
        
        if (Auth::user()){

            $comment = Comment::find($id);
            $comment->body = $request->input('comment-body');
            if(auth()->user()->id !== $comment->user_id){
                return back();
            }
            $comment->save();

            return response()->json(["success" => $comment]); 
        }
    }
    
}
