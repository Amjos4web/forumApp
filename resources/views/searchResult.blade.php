@extends ('layouts.app')

@section ('content')
  <div class="row news-heading">
      @if (isset($details))
        @if (count($details) > 0)
        <div class="col-md-12">
            <h3 class="text-center">The Search results for your <b> {{ $query }} </b> are</h3>
            <p class="text-center"><b> {{ count($details) }} </b> result(s)found</p>
        </div>
        </div>
        <div class="row posts">
              @foreach($details as $post)
              <div class="col-md-12 col-lg-12">
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
                            <p><small class="text-muted" style="font-size: 12px"> <strong> Written: {!! Helper::timeElapsedString(strtotime($post->created_at->toDateTimeString())) !!}</strong></small></p>
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
                            <span class="like-btn">
                                <i class="fa fa-heart {{ auth()->user()->hasLiked($post) ? 'like-post' : " " }}" data-id="{{$post->id}}"></i> 
                                <span class="likers">{{ $post->likers()->get()->count()}}</span>
                            </span>
                        @endguest
                      </div>
                  </div>
              </div> 
          </div>  
      @endforeach
 
      <div style="text-align: center">
          {{$details->links()}}
      </div>
    @else 
      <p>No result found</p>
    @endif
    @else 
        <p style="font-size: 20px;">No result found... Try again</p>
    @endif
</div>
@endsection
