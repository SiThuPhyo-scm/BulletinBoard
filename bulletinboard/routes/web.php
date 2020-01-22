<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    //User
    Route::prefix('user')->group(function() {
        // UserList Screen
        Route::get('/', array('as'=>'user.userlist', 'uses'=>'User\UserController@index'));

        Route::post('/search', array('as'=>'Search', 'uses'=>'User\UserController@search'));

        Route::get('/create', array('as'=>'user.create', 'uses'=>'User\UserController@create'));

        Route::post('/createConfirm', array('as'=>'user.creaateConfirm', 'uses'=>'User\UserController@createConfirm'));

        Route::post('/store', array('as'=>'user.store', 'uses'=>'User\UserController@store'));

        Route::post('/showUser', array('as'=>'ShowUserModal', 'uses'=>'User\UserController@show'));

        Route::delete('/destory/{id}', array('as'=>'user.delete', 'uses'=>'User\UserController@destory'));

        // User Profile Screen
        Route::get('/profile', array('as'=>'user.profile', 'uses'=>'User\UserController@profile'));

        Route::get('/edit/{id}', array('as'=>'user.edit', 'uses'=>'User\UserController@edit'));

        Route::put('/edit/{id}', array('as'=>'user.editConfirm', 'uses'=>'User\UserController@editConfirm'));

        Route::post('/update/{id}', array('as'=>'user.update', 'uses'=>'User\UserController@update'));

        // Password Change
        Route::get('/password/{id}', array('as'=>'user.password', 'uses'=>'User\UserController@password'));

        Route::post('/passwordchange/{id}', array('as'=>'user.passwordchange', 'uses'=>'User\UserController@changepassword'));
    });
    //Post
    Route::get('/posts', array('as'=>'post.postlist', 'uses'=>'Post\PostController@index'));

    Route::post('/posts', array('as'=>'post.search', 'uses'=>'Post\PostController@search'));

    Route::get('/post/create', array('as'=>'post.create', 'uses'=>'Post\PostController@create'));

    Route::post('/showPost', array('as'=>'ShowPostModal', 'uses'=>'Post\PostController@show'));

    Route::post('/post/create', array('as'=>'post.createConfirm', 'uses'=>'Post\PostController@createConfirm'));

    Route::post('/post/store', array('as'=>'post.store', 'uses'=>'Post\PostController@store'));

    Route::get('/post/{id}', array('as'=>'post.edit', 'uses'=>'Post\PostController@edit'));

    Route::put('/post/{id}', array('as'=>'post.editConfirm', 'uses'=>'Post\PostController@editConfirm'));

    Route::post('/post/{id}', array('as'=>'post.update', 'uses'=>'Post\PostController@update'));

    Route::delete('post/{id}', array('as'=>'post.delete', 'uses'=>'Post\PostController@destory'));

    Route::get('/csv/upload', array('as'=>'post.upload', 'uses'=>'Post\PostController@upload'));

    Route::post('/csv/upload', array('as'=>'post.import', 'uses'=>'Post\PostController@import'));

    Route::get('/download', array('as'=>'export', 'uses'=>'Post\PostController@export'));
});
