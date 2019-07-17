<div class="row">
    <div class="col-md-12 col-lg-12">
        @guest
            <h2>Join Discussion &nbsp;&nbsp;&nbsp; <label style="font-size: 16px;">Log in to add comment</label></h2>
        @else
            <h2>Join Discussion &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" id="addComment">Add Comment</button></h2>
        @endguest
        <hr>
        @if (count($comments) > 0)
            <p style="font-size: 18px; color: cadetblue">{{ count($comments) }} responses to {{ $post->title}}</p>
        @endif
    </div>
</div>
        <div class="row" style="display: none" id="comment-form">
        <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Comment Form</div>
    
                    <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/comments') }}">
                            {{ csrf_field() }}
    
                            <div class="form-group">
                                <label for="comment" class="col-md-4 control-label">Your Comment</label>
    
                                <div class="col-md-6">
                                    <textarea type="textarea" name="comment" rows="10" cols="10" id="comment-box" class="form-control" required></textarea>
                                </div>
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <input type="submit" value="Add Comment" class="btn btn-primary" id="addComment" name="addComment">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (count($comments) > 0)
            @foreach($comments as $comment)
                <div class="well well-sm">
                <div class="row">
                <div class="col-md-2">
                    <img src="/storage/images/{{$comment->user->profile_image}}" class="user-image" alt="{{ $comment->user->name}}">
                </div>
                
                <div class="col-md-10" id="commentSection{{ $comment->id }}">
                    <div id="comment-section{{ $comment->id }}">
                    @if ($comment->user->id !== auth()->user()->id)
                        <p><i class="fa fa-user"></i> <strong><a href="{{ route('user.view', $comment->user->id) }}">
                            {{ $comment->user->name}} 
                        </strong></a>Commented on {{ $post->title }} ... {!! Helper::timeElapsedString(strtotime($comment->created_at->toDateTimeString())) !!}</p> 
                    @else
                        <p><i class="fa fa-user"></i> <strong><a href="/profile">
                            You
                        </strong></a>Commented on {{ $post->title }}  ... {!! Helper::timeElapsedString(strtotime($comment->created_at->toDateTimeString())) !!}</span></i></p>
                    @endif
                    <div class="comment-body">
                    <p id="comment-body{{ $comment->id}}" class="comment-body-p"><i class="fa fa-edit"></i> {{ $comment->body }}</p>
                    <label style="float: right; margin-right: 10px; color: #fff; cursor: pointer; background: skyblue; padding: 6px;" data-id="{{ $comment->id }}" data-toggle="modal" class="replyBtn" data-target="#replyComment">Reply</label>
                    @if ($comment->user->id == auth()->user()->id)
                        <label style="float: right; margin-right: 10px; cursor: pointer; color: #fff; background: darkred; padding: 6px;" data-id="{{ $comment->id }}"  data-toggle="modal" data-target="#editComment" class="editComment">Edit</label>
                    @endif
                    {{-- <label style="float: right; margin-right: 10px; cursor: pointer; font-size: 17px;"><i class="fa fa-heart likeComment {{ auth()->user()->hasLiked($comment) ? 'like-comment' : " " }}" data-id="{{$comment->id}}"></i> <span class="likers">{{ $comment->likers()->get()->count() }}</span></label> --}}
                    </div>
                    </div>


                    <br><br>
                    
                     @include('comments.commentReply', ['comments' => $comment->replies, $comment->user->name])
                           
                </div><br><br>
            </div><br>
        </div>
       
            @endforeach
        @else
            <p style="font-size: 18px; color: cadetblue">No comment on this post yet</p>
        @endif
        <div class="modal fade" id="replyComment" role="dialog">
                <div class="modal-dialog modal-lg" style="max-height: 600px; overflow-x: auto;">
                    <!-- Modal content no 1-->
                        <div class="modal-content">
                        <form class="form-horizontal" id="replyForm" method="POST">
                            {!! csrf_field() !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-pencil-o"></i> Reply Comment</h4>
                        </div>
                            <div class="modal-body padtrbl">
                                <p style="text-align: center; font-size: 18px; font-family: Barlow; color: green" id="message"></p>
                                <div class="form-group">
                                    <label for="reply" class="col-md-4 control-label">Reply</label>
        
                                    <div class="col-md-6">
                                    <textarea type="textarea" name="reply" rows="10" cols="10" id="replyCommentText" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="post_id" id="post_id" value="{{ $post->id }}">
                                <input type="hidden" id="storeCommentID2" value=""/>
                                <input type="hidden" id="storePostID" value=""/>
                        
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-info" value="Reply" name="reply">
                        </div>
                    </form>
                </div>
                </div>
                </div>

                        
        <div class="modal fade" id="editComment" role="dialog">
                <div class="modal-dialog modal-lg" style="max-height: 600px; overflow-x: auto;">
            
                    <!-- Modal content no 1-->
                    <div class="modal-content">
                    <form class="form-horizontal" id="editCommentForm">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-pencil-o"></i> Edit Comment</h4>
                    </div>
                        <div class="modal-body padtrbl">
                            <p style="text-align: center; font-size: 18px; font-family: Barlow; color: green" id="message"></p>
                            <div class="form-group">
                                <label for="comment" class="col-md-4 control-label">Comment</label>
    
                                <div class="col-md-6">
                                    <textarea type="textarea" name="comment-body" rows="10" cols="10" id="editCommentText" class="form-control"></textarea>
                                </div>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-info" name="edit" id="editBtn" value="Save">
                    </div>
                </form>
                    </div>
                    </div>
                    </div>
                    <input type="hidden" id="storeCommentID" value=""/>
              
   