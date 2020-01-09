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
//login
Route::post('/user/login', 'User\UserController@login');

Route::get('/posts', 'Post\PostController@index')->name('postList');

Route::get('/post/create', 'Post\PostController@createform');

Route::post('/post/create', 'Post\PostController@create');

Route::post('/post/store', 'Post\PostController@store');

Route::get('/post/{id}', 'Post\PostController@edit');

Route::post('/post/{id}', 'Post\PostController@editConfirm');

Route::post('/post/{id}', 'Post\PostController@update')->name('posts.update');
