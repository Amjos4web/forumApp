@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    <form action="{{ route('feeds.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter Title">
        </div>
        <div class="form-group">
            <label>Body</label>
            <textarea type="textarea" name="body" id="article-ckeditor" cols="30" rows="10" class="form-control" placeholder="Body"></textarea>
        </div>
        <div class="form-group">
            <label>Upload Image</label>
            <input type="file" name="cover_image" class="form-control">
        </div>
        <input type="submit" name="submit" value="Create Post" class="btn btn-primary pull-right">
    </form><br><br><br>
@endsection