<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'uses' => 'SlideController@show',
    'as' => 'welcome'
]);

Route::auth();

Route::get('/home', [
    'uses' => 'HomeController@index',
    'as' => 'home'
]);

Route::get('/slides', [
    'uses' => 'SlideController@view',
    'as' => 'slides.view'
]);

/*Route::post('/account/update', [
   'uses' => 'UserController@saveAccount',
   'as' => 'account.update'
]);*/

Route::post('/user/avatar', [
    'uses' => 'ProfileController@editAvatar',
    'as' => 'avatar.update'
]);

Route::get('/profile/{email}', [
    'uses' => 'ProfileController@index',
    'as' => 'user.profile'
]);

Route::get('/user/image/{filename}', [
    'uses' => 'HomeController@image',
    'as' => 'account.image'
]);

Route::post('/createpost', [
    'uses' => 'PostController@create',
    'as' => 'post.create',
    'middleware' => 'auth'
]);

Route::get('/posts', [
    'uses' => 'PostController@dashboard',
    'as' => 'post.dashboard',
    'middleware' => 'auth'
]);

Route::get('/post/delete/{post_id}', [
    'uses' => 'PostController@delete',
    'as' => 'post.delete',
    'middleware' => 'auth'
]);

/*Route::post('/post/edit', function (\Illuminate\Http\Request $request) {
    return response()->json(['message' => $request['postId']]);
    /*
     * {
     *    message: '$request['body']'
     * }
     */
//})->name('edit');

Route::post('/post/edit', [
    'uses' => 'PostController@edit',
    'as' => 'post.edit'
]);

Route::post('/post/like', [
    'uses' => 'PostController@like',
    'as' => 'post.like'
]);

Route::post('/slide/edit', [
    'uses' => 'SlideController@edit',
    'as' => 'slide.edit'
]);


