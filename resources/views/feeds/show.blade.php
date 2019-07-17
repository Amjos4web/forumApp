@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <a href="/feeds" class="btn btn-info">Go back</a>
    </div>
    <div class="col-md-4" style="text-align: right">
        <span class="like-btn">
            <i class="fa fa-heart {{ auth()->user()->hasLiked($post) ? 'like-post' : " " }}" data-id="{{$post->id}}"></i> 
            @if (count($post->likers()->get()) > 0)
                <span class="likers">{{ $post->likers()->get()->count() }}</span>
            @else
                Be the first person to like this trend
            @endif
        </span>
        <div class="liker-details">
            <ul>
                @if (count($post->likers()->get()) <= 15)
                    @foreach( $post->likers()->take(15)->get() as $userName)
                        <li>{{ $userName->name }}</li>
                    @endforeach
                @else
                    @foreach( $post->likers()->take(15)->get() as $userName)
                        <li>{{ $userName->name }}</li>
                    @endforeach
                    <li>And others... </li>
                @endif

            </ul>
        </div>

    </div>
</div><br>
   
    <img src="/storage/cover_images/{{$post->cover_image}}" style="width: 100%; border: 2px solid #CECECE;">
    <h1>{{$post->title}}</h1>
    <p>{!!$post->body!!}</p>

    <hr>
    <small>Written on {{ date('F j, Y, g:i:a', strtotime($post->created_at))}} by {{$post->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href="/feeds/{{$post->id}}/edit" class="btn btn-default">Edit</a>
            <form action="{{ route('feeds.destroy', $post->id) }}" method="post" class="pull-right">
                {{ csrf_field()}}
                {{ method_field('DELETE') }}
                <input type="submit" value="Delete" class="btn btn-danger">
            </form><br><br><br>
        @endif
    @endif
    @include('comments.commentDisplay', ['comments' => $post->comments, 'post_id' => $post->id]) 
@endsection