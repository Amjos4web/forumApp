@extends ('layouts.app')

@section ('content')
  <div class="jumbotron text-center">
    <h1>Welcome To HDS Connect</h1>
    <p>Connect with Family and Friends</p>
  </div>
  <hr>
  <div class="row news-heading">
      <div class="col-md-12">
          <h3 class="text-center">Latest Trends</h3>
      </div>
  </div>
  @if(count($posts) > 0)
 
          <div class="row posts">
              @foreach($posts as $post)
              <div class="col-md-6 col-lg-6">
              <div class="well well-sm">
                  <div class="row">
                      <div class="col-md-2">
                          <img src="/storage/images/{{ $post->user->profile_image}}" class="user-image" alt="{{ucwords($post->user->name)}}">
                      </div>
                      <div class="col-md-10">
                          <p><strong>
                              @guest
                                 {{ $post->user->name }}
                                @else
                                    @if (auth()->user()->id == $post->user->id)
                                        You
                                    @else
                                        {{ $post->user->name }}
                                    @endif
                                @endguest
                           
                            </strong> created a post </p>
                            <div class="post-body">
                                <p> <strong><a href="/feeds/{{$post->id}}">{{ ucwords($post->title) }}</a></strong></p>
                            </div>
                            <p><small class="text-muted" style="font-size: 12px"> <strong> Written: {{ strftime("%d %b, %Y %H:%M:%S",strtotime($post->created_at)) }}</strong></small></p>
                        <div class="post-body">
                          <p>{!! $post->body !!}</p><label style="float: right; margin-right: 10px"><a href="/feeds/{{$post->id}}" data-id="{{ $post->id}}">Read More</a></label>
                        </div>
                          
                      </div><br><br>
                      <div style="text-align: center">
                          <img src="/storage/cover_images/{{$post->cover_image}}" alt="{{$post->title}}" width="400px" height="300px;">
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
                        @guest 
                            
                            <i class="glyphicon glyphicon-thumbs-up like-post"></i> 
                            <span id="likers">{{ $post->likers()->get()->count()}}</span>
                            <p style="display: none"><small>You need to log in before you can like or comment on any post</small></p>
                        @else
                            <span class="like-btn likeBtn" data-id="{{ $post->id }}">
                                <i class="fa fa-heart {{ auth()->user()->hasLiked($post) ? 'like-post' : " " }}" data-id="{{$post->id}}"></i> 
                                <span class="likers">{{ $post->likers()->get()->count()}}</span>
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
                                        <label>And others... </label>
                                    @endif
                                </ul>
                            </div>
                        @endguest
                      </div>
                  </div>
              </div> 
          </div>  
      @endforeach
  </div>
      <div style="text-align: center">
          {{-- {{$posts->links()}} --}}
      </div>
  @else
      <p>No Posts Available</p>
  @endif
@endsection
