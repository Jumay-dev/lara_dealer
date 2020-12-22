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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('registration', 'AuthController@registration');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group([
    'prefix' => 'users'
], function() {
    Route::post('all', 'UsersController@all');
    Route::post('create', 'UsersController@create');
    Route::post('read', 'UsersController@read');
    Route::post('update', 'UsersController@update');
    Route::post('delete', 'UsersController@delete');
    Route::post('search', 'UsersController@search');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
