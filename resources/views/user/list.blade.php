@if($users->count())

    @foreach($users as $user)

        <div class="col-md-3 profile-box text-center">

            <img src="/storage/images/{{ $user->profile_image}}" class="card-img-top" alt="{{ $user->name }}">
                <div class="card-body">
                    <div class="card-title">
                        <h5 class="m-0"><a href="{{ route('user.view', $user->id) }}"><strong>{{ $user->name }}</strong></a></h5>
                    </div>

                    <p class="card-text">

                        <small>Following: <span class="badge badge-primary">{{ $user->followings()->get()->count() }}</span></small>

                        <small>Followers: <span class="badge badge-primary tl-follower">{{ $user->followers()->get()->count() }}</span></small>

                    </p>
                    
                       
                        <button class="btn btn-info btn-sm action-follow" data-id="{{ $user->id }}"><strong>

                        @if(auth()->user()->isFollowing($user))

                            UnFollow

                        @else

                            Follow

                        @endif

                        </strong></button>
                    
                </div>
        </div>

    @endforeach
       
@endif