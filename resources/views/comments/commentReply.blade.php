
        @if (count($comments) > 0)
            @foreach($comments as $commentReply)
            <div class="well well-sm" id="commentReply{{ $commentReply->id }}">
                <p style="font-size: 16px; color: cadetblue"><i class="fa fa-reply"></i> Reply</p>
                <div class="row">
                
                <div class="col-md-2">
                   
                    <img src="/storage/images/{{$commentReply->user->profile_image}}" class="user-image" alt="{{ $commentReply->user->name}}">
                </div>
                <div class="col-md-10">
                    @if ($commentReply->user->id !== auth()->user()->id)
                        <p><i class="fa fa-user"></i> <strong><a href="{{ route('user.view', $commentReply->user->id) }}">
                            {{ $commentReply->user->name}}
                        </strong></a> Replied <label style="color: cadetblue">{{ $comment->user->name }}'s</label> Comment ...{!! Helper::timeElapsedString(strtotime($commentReply->created_at->toDateTimeString())) !!}
                    @else
                        <p><i class="fa fa-user"></i> <strong><a href="/profile">
                            You
                        </strong></a> Replied <label style="color: cadetblue">{{ $comment->user->name }}'s</label> Comment ...{!! Helper::timeElapsedString(strtotime($commentReply->created_at->toDateTimeString())) !!}
                    @endif
                    <div class="comment-body">
                    <p id="comment-body{{ $commentReply->id}}" class="comment-body-p"><i class="fa fa-edit"></i> {{ $commentReply->body}}</p>
                    @if ($commentReply->user->id == auth()->user()->id)
                        <label style="float: right; margin-right: 10px; cursor: pointer; color: #fff; background: darkred; padding: 6px;" data-id="{{ $commentReply->id }}" data-toggle="modal" data-target="#editComment" class="editComment">Edit</label>
                    @endif
                    </div>
                </div><br><br>
            </div><br>
        </div>
        <input type="hidden" value="{{ auth()->user()->profile_image}}" id="profile-image">
        <input type="hidden" value="{{ auth()->user()->name}}" id="user-name">
        <input type="hidden" value="{{ auth()->user()->id}}" id="user-id">
        <input type="hidden" value="{{ $commentReply->user->name}}" id="comment-user-name">
        <input type="hidden" value="{{ $commentReply->user->id}}" id="comment-user-id">
        @endforeach
        @endif
        
              
   