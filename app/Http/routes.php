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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/signup', [
    'uses'  => 'UserController@signUp',
    'as'    => 'signup'
]);

Route::post('/signin', [
    'uses'  => 'UserController@signIn',
    'as'    => 'signin'
]);

Route::get('logout', [
    'uses' => 'UserController@logout',
    'as' => 'logout'
]);

Route::post('account/edit', [
    'uses' => 'UserController@editUser',
    'as'    => 'account.edit'
]);

Route::group(['middleware' => 'check.login'], function () {

    Route::get('account', [
        'uses' => 'UserController@getAccount',
        'as'    => 'account'
    ]);

    Route::get('post/{post}/delete', [
        'uses' => 'PostController@deletePost',
        'as' => 'post.delete'
    ]);

    Route::get('/dashboard', [
        'uses' => 'UserController@getDashboard',
        'as' => 'dashboard'
    ]);

    Route::post('post/{post}/edit', [
        'uses'  => 'PostController@editPost',
        'as'    => 'post.edit'
    ]);

    Route::post('post/like/{post}', [
        'uses' => 'PostController@likePost',
        'as' => 'post.like'
    ]);

    Route::post('/post/create', [
        'uses' => 'PostController@createPost',
        'as' => 'post.create'
    ]);

    Route::get('user/image/{image}', [
        'uses' => 'UserController@getUserImage',
        'as'    => 'account.image'
    ]);

});