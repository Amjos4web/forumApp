@extends('layouts.app')

@section('content')
<div class="container login-section">
    <div class="row">
        <div class="col-md-6">
            
            <div class="profile-panel">
                <p>Welcome! {{ auth()->user()->name}}</p>
                <img src="/storage/images/{{ $user->profile_image}}" class="profile-image"><br><br>
                <p style="color: #888888; font-size: 15px;">You have <span class="badge badge-primary">{{ $user->followers()->get()->count()}}</span> Followers</p>
                <p style="color: #888888; font-size: 15px;">You are following <span class="badge badge-primary">{{ $user->followings()->get()->count()}}</span> People</p>
            </div>
          
            </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Update Profile</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('user.editProfile', $user->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('patch')}}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required >

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" disabled>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="profile-image" class="col-md-4 control-label">Upload Profile Image</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control" name="profile_image">
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
          
    </div><br><br><br>
    <nav>

            <div class="nav nav-tabs" id="nav-tab" role="tablist">

              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#followers" role="tab" aria-controls="nav-home" aria-selected="true">Followers <span class="badge badge-primary">{{ $user->followers()->get()->count() }}</span></a>&nbsp;&nbsp;

              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#following" role="tab" aria-controls="nav-profile" aria-selected="false">Following <span class="badge badge-primary">{{ $user->followings()->get()->count() }}</span></a>

            </div>

          </nav>

          <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="followers" role="tabpanel" aria-labelledby="nav-home-tab">

              <div class="row">

                  @include('user.list', ['users'=>$user->followers()->get()])

              </div>

            </div>

            <div class="tab-pane fade" id="following" role="tabpanel" aria-labelledby="nav-profile-tab">

              <div class="row">

                  @include('user.list', ['users'=>$user->followings()->get()])

              </div>

            </div>

          </div>
</div>
@endsection
