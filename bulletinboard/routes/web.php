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
    Route::get('/users', array('as'=>'user.userlist', 'uses'=>'User\UserController@index'));

    Route::post('/users', array('as'=>'Search', 'uses'=>'User\UserController@search'));

    Route::get('/user/create', array('as'=>'user.create', 'uses'=>'User\UserController@create'));

    Route::post('/user/createConfirm', array('as'=>'user.creaateConfirm', 'uses'=>'User\UserController@createConfirm'));

    Route::post('/user/store', array('as'=>'user.store', 'uses'=>'User\UserController@store'));

    Route::get('/user/profile', array('as'=>'user.profile', 'uses'=>'User\UserController@profile'));

    Route::get('/user/{id}', array('as'=>'user.edit', 'uses'=>'User\UserController@edit'));

    Route::put('/user/{id}', array('as'=>'user.editConfirm', 'uses'=>'User\UserController@editConfirm'));

    Route::post('/user/{id}', array('as'=>'user.update', 'uses'=>'User\UserController@update'));

    Route::get('/user/password/{id}', array('as'=>'user.password', 'uses'=>'User\UserController@password'));

    Route::post('/user/passwordchange/{id}', array('as'=>'user.passwordchange', 'uses'=>'User\UserController@passwordchange'));

    //Post
    Route::get('/posts', array('as'=>'post.postlist', 'uses'=>'Post\PostController@index'));

    Route::post('/posts', array('as'=>'post.search', 'uses'=>'Post\PostController@search'));

    Route::get('/post/create', array('as'=>'post.create', 'uses'=>'Post\PostController@create'));

    Route::post('/post/create', array('as'=>'post.createConfirm', 'uses'=>'Post\PostController@createConfirm'));

    Route::post('/post/store', array('as'=>'post.store', 'uses'=>'Post\PostController@store'));

    Route::get('/post/{id}', array('as'=>'post.edit', 'uses'=>'Post\PostController@edit'));

    Route::put('/post/{id}', array('as'=>'post.editConfirm', 'uses'=>'Post\PostController@editConfirm'));

    Route::post('/post/{id}', array('as'=>'post.update', 'uses'=>'Post\PostController@update'));

    Route::get('/csv/upload', array('as'=>'post.upload', 'uses'=>'Post\PostController@upload'));

    Route::post('/csv/upload', array('as'=>'post.import', 'uses'=>'Post\PostController@import'));

});
