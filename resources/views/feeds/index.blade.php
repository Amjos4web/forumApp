@extends('layouts.app')

@section('content')
    <div class="row news-heading">
        <div class="col-md-12">
            <h3 class="text-center">Latest Trends</h3>
        </div>
    </div>
    @if(count($posts) > 0)
        <div class="row posts" id="post-data">
               @include('feeds.data') 
        </div><br><br>
        <div class="ajax-load text-center" style="display:none">
            <p><img src="storage/images/loadingmore.gif">Loading More Feeds</p>
        </div>
       
    @else
        <p>No Posts Available</p>
    @endif
@endsection

