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
//User
Route::prefix('user')->group(function() {
    // UserList Screen
    Route::get('/', array('as'=>'user.userlist', 'uses'=>'User\UserController@index'))->middleware('type');

    Route::post('/', array('as'=>'Search', 'uses'=>'User\UserController@search'));

    // Create User
    Route::get('/create', array('as'=>'user.create', 'uses'=>'User\UserController@create'))->middleware('type');

    Route::post('/createConfirm', array('as'=>'user.creaateConfirm', 'uses'=>'User\UserController@createConfirm'));

    Route::post('/store', array('as'=>'user.store', 'uses'=>'User\UserController@store'));
    // End Create User

    Route::post('/showUser', array('as'=>'ShowUserModal', 'uses'=>'User\UserController@show'));

    Route::delete('/destory/{id}', array('as'=>'user.delete', 'uses'=>'User\UserController@destory'));
    // End UserList Screen

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
Route::prefix('post')->group(function() {
    Route::get('/', array('as'=>'post.postlist', 'uses'=>'Post\PostController@index'));

    Route::post('/', array('as'=>'post.search', 'uses'=>'Post\PostController@search'));

    Route::get('/create', array('as'=>'post.create', 'uses'=>'Post\PostController@create'));

    Route::post('/showPost', array('as'=>'ShowPostModal', 'uses'=>'Post\PostController@show'));

    Route::post('/createConfirm', array('as'=>'post.createConfirm', 'uses'=>'Post\PostController@createConfirm'));

    Route::post('/store', array('as'=>'post.store', 'uses'=>'Post\PostController@store'));

    Route::get('/edit/{id}', array('as'=>'post.edit', 'uses'=>'Post\PostController@edit'));

    Route::put('/edit/{id}', array('as'=>'post.editConfirm', 'uses'=>'Post\PostController@editConfirm'));

    Route::post('/update/{id}', array('as'=>'post.update', 'uses'=>'Post\PostController@update'));

    Route::delete('destory/{id}', array('as'=>'post.delete', 'uses'=>'Post\PostController@destory'));

    Route::get('/upload', array('as'=>'post.upload', 'uses'=>'Post\PostController@upload'));

    Route::post('/import', array('as'=>'post.import', 'uses'=>'Post\PostController@import'));

    Route::get('/download', array('as'=>'export', 'uses'=>'Post\PostController@export'));
});
