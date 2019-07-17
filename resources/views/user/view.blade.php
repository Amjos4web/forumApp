@extends('layouts.app')


@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-12">

                <div class="news-heading" style="font-size: 22px;">

                    {{ $user->name }}

                    <br/>

                    <small>
                        <strong>Email: </strong>{{ $user->email }}

                    </small>

                </div><br>

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
        
    </div>
   
</div><br><br><br>
<div style="text-align: center">
    <a href="/user" class="btn btn-default">Go back</a>
  </div>
@endsection