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
    Route::post('test', 'UsersController@test');
    Route::post('all', 'UsersController@all');
    Route::post('create', 'UsersController@create');
    Route::post('read', 'UsersController@read');
    Route::post('update', 'UsersController@update');
    Route::post('delete', 'UsersController@delete');
    Route::post('search', 'UsersController@search');
});

Route::group([
    'prefix' => 'company'
], function() {
    Route::post('create', 'CompanyController@create');
    Route::post('get', 'CompanyController@get');
    Route::post('update', 'CompanyController@update');
    Route::post('delete', 'CompanyController@delete');
    Route::post('search', 'CompanyController@search');
});

Route::group([
    'prefix' => 'project'
], function() {
    Route::post('create', 'ProjectController@create');
    Route::post('get', 'ProjectController@get');
    Route::post('update', 'ProjectController@update');
    Route::post('delete', 'ProjectController@delete');
    Route::post('search', 'ProjectController@search');
});

Route::group([
    'prefix' => 'clinic'
], function() {
    Route::post('create', 'ClinicalController@create');
    Route::post('get', 'ClinicalController@get');
    Route::post('update', 'ClinicalController@update');
    Route::post('delete', 'ClinicalController@delete');
    Route::post('search', 'ClinicalController@search');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
