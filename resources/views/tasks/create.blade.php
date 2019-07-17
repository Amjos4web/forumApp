@extends('layouts.app')

@section('content')
    <h2>Create Task</h2>
    <form action="{{ route('tasks.store') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter Title">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea type="textarea" name="description" id="article-ckeditor" cols="30" rows="10" class="form-control" placeholder="Body"></textarea>
        </div>
        
        <input type="submit" name="submit" value="Create" class="btn btn-primary pull-right">
    </form><br><br><br>
@endsection