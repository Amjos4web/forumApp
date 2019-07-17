@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <div class="alert alert-info col-md-12 col-center bigfont animated fadeIn" style="margin-top: 10px;">
            <span title="Formats">Welcome to your Dashboard. Here you can create new post and task for yourself and connect with friends</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <img src="/storage/images/{{ $user->profile_image}}" class="profile-image" style="border-radius: 0px; margin-left: 80px">
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">My Posts<label style="float: right"><a href="{{ route('feeds.create') }}" class="btn btn-default sm">Create Post</a></label></div>

                <div class="panel-body">
                    @if (count($posts) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th>Edit</th>
                                <th>View</th>
                                <th>Delete</th>
                            </tr>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{$post->title}}</td>
                                    <td><a href="/feeds/{{$post->id}}/edit" class="btn btn-default">Edit</a></td>
                                    <td><a href="/feeds/{{$post->id}}" class="btn btn-default">View</a></td>
                                    <td>
                                        <form action="{{ route('feeds.destroy', $post->id) }}" method="post">
                                            {{ csrf_field()}}
                                            {{ method_field('DELETE') }}
                                            <input type="submit" value="Delete" class="btn btn-danger">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>You have no post yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">My Profile</div>
        
                        <div class="panel-body">
                            <p style="color: #888888; font-size: 15px;"><i class="fa fa-info"></i> You have <span class="badge badge-primary">{{ $user->followers()->get()->count()}}</span> Followers</p>
                            <p style="color: #888888; font-size: 15px;"><i class="fa fa-info"></i> You are following <span class="badge badge-primary">{{ $user->followings()->get()->count()}}</span> People</p>
                            <p style="color: #888888; font-size: 15px;"><i class="fa fa-info"></i> You have <span class="badge badge-primary">{{ count($user->posts)}}</span> Trends</p>
                            <p style="color: #888888; font-size: 15px;"><i class="fa fa-info"></i> You have <span class="badge badge-primary">{{ count($user->tasks)}}</span> Tasks</p>
                        </div>
                    </div>
        </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">My Tasks<label style="float: right"><a href="{{ route('tasks.create') }}" class="btn btn-default sm">Create Task</a></label></div>
    
                    <div class="panel-body">
                        @if (count($tasks) > 0)
                            <table class="table table-striped">
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>View</th>
                                    <th>Delete</th>
                                </tr>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{$task->title}}</td>
                                        @if ($task->is_complete == true)
                                            <td><button type="button" class="btn btn-primary disabled">Completed</button></td>
                                        @else
                                            <td><a href="/tasks/{{$task->id}}/edit" class="btn btn-primary">Complete</a></td>
                                        @endif
                                        <td><a href="/tasks/{{$task->id}}" class="btn btn-default">View</a></td>
                                        <td>
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                                                {{ csrf_field()}}
                                                {{ method_field('DELETE') }}
                                                <input type="submit" value="Delete" class="btn btn-danger">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p>You have no task yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
