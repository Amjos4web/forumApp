@extends('layouts.app')

@section('content')
    <a href="/dashboard" class="btn btn-default">Go back</a><br><br>
    <h1>{{$tasks->title}}</h1>
    <p>{!!$tasks->description!!}</p>
    <hr>
    <small>Created on {{$tasks->created_at}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $tasks->user_id)
            @if($tasks->is_complete == false)
                <a href="/tasks/{{$tasks->id}}/edit" class="btn btn-default">Complete</a>
                <form action="{{ route('tasks.destroy', $tasks->id) }}" method="post" class="pull-right">
                    {{ csrf_field()}}
                    {{ method_field('DELETE') }}
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form><br><br>
            @endif
            @if($tasks->is_complete == false)
                <p style="color: orange; font-size: 18px;">Status: In Progress</p>
            @else
                <p style="color: green; font-size: 18px;">Status: Completed</p>
            @endif
        @endif
    @endif
@endsection