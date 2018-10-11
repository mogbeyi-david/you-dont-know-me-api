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

Route::group(['namespace' => 'API'], function () {
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@login');
});

Route::group(['namespace' => 'API', 'prefix' => 'users'], function () {
    Route::post('{id}', 'UserController@update');
});

Route::group(['namespace' => 'API', 'prefix' => 'posts'], function () {
    Route::post('store', 'PostController@store');
    Route::get('', 'PostController@index');
});