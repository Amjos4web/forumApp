@extends('layouts.app')

@section('content')
    <h1>Edit Task</h1>
    <form action="{{ route('tasks.update', $tasks->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{$tasks->title}}">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea type="textarea" name="description" id="article-ckeditor" cols="30" rows="10" class="form-control" placeholder="Body">{{$tasks->description}}</textarea>
        </div>
        <input type="submit" name="submit" value="Complete Task" class="btn btn-primary pull-right">
    </form><br><br><br>
@endsection