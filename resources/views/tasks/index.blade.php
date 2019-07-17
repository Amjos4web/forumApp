@extends('layouts.app')

@section('content')
    <h2 style="text-transform: uppercase">Tasks</h2>
    @if(count($tasks) > 0)
        @foreach($tasks as $task)
            <div class="well">
               
                <h4 style="color:brown">{{$task->title}}</h4>
                <small>Created on {{$task->created_at}}</small> 
                <p>{!! $task->description !!}</p>
                @if($task->is_complete == false)
                    <p style="color: orange; font-size: 14px;">Status: In Progress</p>
                @else
                    <p style="color: green; font-size: 14px;">Status: Completed</p>
                @endif
            </div>
         @endforeach
        <div style="text-align: center">
            {{$tasks->links()}}
        </div>
    @else
        <p>You have No Task</p>
    @endif
@endsection