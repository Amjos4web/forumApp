@extends('layouts.app')


@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="panel panel-default">
            <div class="panel-heading userlist-heading">
                <h3>List of Users</h3>
            </div>
            <div class="panel-body">
                <div class="col-md-12">

                        <div class="card">
            
                            {{-- <div class="card-header">List of Users</div>
            
            
                            <div class="card-body"> --}}
            
                                <div class="row">
            
                                    @include('user.list', ['users'=>$users])
            
                                </div>
            
                            {{-- </div> --}}
            
                        </div>
            
                    </div>
                    <div style="text-align: center">
                        {{ $users->links() }}
                    </div>
            </div>
        </div>

    </div>

</div>

@endsection
