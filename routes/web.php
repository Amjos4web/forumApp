<?php
use myLaravelFirstApp\Post;
use Illuminate\Support\Facades\Input;

// all pages routes
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/chat', 'ChatController@chat');
Route::post('/send', 'ChatController@send');

// feeds and tasks routes
Route::resource('feeds', 'PostsController');
Route::resource('tasks', 'TaskController');
Auth::routes();

// user dashboard
Route::get('/dashboard', 'DashboardController@index');
Route::get('/user', 'DashboardController@users');
Route::get('user{id}', 'DashboardController@user')->name('user.view');
Route::get('user/{id}', 'DashboardController@user');
Route::post('ajaxRequest', 'DashboardController@ajaxRequest')->name('ajaxRequest');
Route::put('editComment/{id}', 'CommentController@editComment');
Route::post('/profile', 'DashboardController@editProfile')->name('editProfile');
Route::post('like', 'DashboardController@like')->name('like');
Route::post('replyComment', ['as' => 'replyComment', 'uses' => 'CommentController@replyComment']);
Route::post('/comments', 'CommentController@store')->name('comments.commentDisplay');
Route::get('/profile',  ['as' => 'user.edit', 'uses' => 'DashboardController@profile']);
Route::patch('/profile/{id}',  ['as' => 'user.editProfile', 'uses' => 'DashboardController@editProfile']);

// searching
Route::get('/search', function(){
    $searchResult = Input::get('searchText');
    $posts = Post::where( 'title', 'LIKE', '%' . $searchResult . '%' )->orWhere( 'body', 'LIKE', '%' . $searchResult . '%' )->simplePaginate(20);

    if (count($posts) > 0){
        return view ( 'searchResult' )->withDetails( $posts )->withQuery( $searchResult );
    } else {
        return view ('searchResult')->with('No result found');
    }
});

