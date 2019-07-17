
        @foreach($posts as $post)
        <div class="col-md-6 col-lg-6">
        <div class="well well-sm" id="post-area" next="/feeds">
            <div class="row">
                <div class="col-md-2">
                    <img src="/storage/images/{{ $post->user->profile_image}}" class="user-image" alt="{{ $post->user->name }}">
                </div>
                <div class="col-md-10">
                    <p><strong>
                        @if (auth()->user()->id == $post->user->id)
                            You
                        @else
                            {{ $post->user->name }}
                        @endif
                    </strong> created a post</p> 
                    <div class="post-body">
                        <p> <strong><a href="/feeds/{{$post->id}}">{{ ucwords($post->title) }}</a></strong>
                    </div> 
                    <p><b>Written:</b> <small class="text-muted" style="font-size: 12px"> <strong>{{ strftime("%d %b, %Y %H:%M:%S",strtotime($post->created_at)) }}</strong></small></p>
                    <div class="post-body">
                    <p>{!! $post->body !!}</p><label style="float: right; margin-right: 10px"><a href="/feeds/{{$post->id}}" data-id="{{ $post->id}}">Read More</a></label>
                    </div>
                    
                </div><br><br>
                <div style="text-align: center">
                    <img src="/storage/cover_images/{{$post->cover_image}}" alt="{{$post->title}}" width="400px" height="300px;" class="post-image">
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-4">
                    
                </div>
                <div class="col-md-4">
                    <i class="fa fa-comments"></i>
                        @if(count($post->comments) > 0) 
                          {{ count($post->comments)}}
                        @else
                          No comment
                        @endif
                </div>
                <div class="col-md-4">
                    <span class="like-btn likeBtn" data-id="{{ $post->id }}">
                        <i class="fa fa-heart {{ auth()->user()->hasLiked($post) ? 'like-post' : " " }}" data-id="{{$post->id}}"></i> 
                        @if (count($post->likers()->get()->count()) > 0)
                            <span class="likers">{{ $post->likers()->get()->count() }}</span>
                        @else
                            Be the first to like this trend
                        @endif
                    </span>
                    <div class="liker-details-home{{ $post->id }}" id="liker-details-home">
                        <ul>
                            @if (count($post->likers()->get()) <= 10)
                                @foreach( $post->likers()->take(10)->get() as $userName)
                                    <li>{{ $userName->name }}</li>
                                @endforeach
                            @else
                                @foreach( $post->likers()->take(10)->get() as $userName)
                                    <li>{{ $userName->name }}</li>
                                @endforeach
                                <li>And others... </li>
                            @endif
                        </ul>
        
                    </div>
                </div> 
            </div>
        </div> 
    </div>  

@endforeach
