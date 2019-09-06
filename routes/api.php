<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('post', 'PostController@store');
    Route::put('post/{id}', 'PostController@update');
    Route::delete('post/{id}', 'PostController@destroy');
    Route::post('post/{id}/comment', 'CommentController@store');
    Route::get('post/{id}/comment', 'CommentController@show');
});

Route::post('register', 'Auth\RegisterController@register');

Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout');

Route::get('posts', 'PostController@index');

Route::get('post/{id}', 'PostController@show');

Route::get('comments', 'CommentController@index');
