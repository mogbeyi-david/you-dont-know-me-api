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

//LOGIN AND REGISTRATION ROUTES
Route::group(['namespace' => 'API'], function () {
    Route::post('register', 'UserController@register'); //Create Users
    Route::post('login', 'UserController@login'); // User Login
});

//USER ROUTES
Route::group(['namespace' => 'API', 'prefix' => 'users'], function () {
    Route::post('update/{id}', 'UserController@update'); //Update
    Route::get('', 'UserController@getAll'); // Read
    Route::post('delete/{id}', 'UserController@delete'); //Delete
});

//POST ROUTES
Route::group(['namespace' => 'API', 'prefix' => 'posts'], function () {
    Route::post('store', 'PostController@store'); //Create
    Route::get('', 'PostController@index'); // Read
    Route::post('update/{id}', 'PostController@update'); //Update
    Route::post('delete/{id}', 'PostController@delete'); //Delete
});

//COMMENT ROUTES

Route::group(['namespace' => 'API', 'prefix' => 'comments'], function () {
    Route::get('', 'CommentController@index');
});