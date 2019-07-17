@extends('layouts.app')

@section('content')
    
    <h1>Edit Post</h1>
    <form action="{{ route('feeds.update', $post->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{$post->title}}">
        </div>
        <div class="form-group">
            <label>Body</label>
            <textarea type="textarea" name="body" id="article-ckeditor" cols="30" rows="10" class="form-control" placeholder="Body Text">{{$post->body}}</textarea>
        </div>
        <div class="form-group">
            <label>Upload Image</label>
            <input type="file" name="cover_image" class="form-control">
        </div>
        <a href="/posts" class="btn btn-default">Go back</a>
        <input type="submit" name="submit" value="Update" class="btn btn-primary pull-right"> 
    </form><br><br><br>
@endsection