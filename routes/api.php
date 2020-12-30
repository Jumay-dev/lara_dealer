<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ClinicalController;
use App\Http\Controllers\ProjectController;

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
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/registration', [AuthController::class, 'registration']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);
});

Route::group([
    'prefix' => 'users'
], function() {
    Route::post('/all', [UsersController::class, 'all']);
    Route::post('/create', [UsersController::class, 'create']);
    Route::post('/read', [UsersController::class, 'read']);
    Route::post('/update', [UsersController::class, 'update']);
    Route::post('/delete', [UsersController::class, 'delete']);
    Route::post('/search', [UsersController::class, 'search']);
});

Route::group([
    'prefix' => 'company'
], function() {
    Route::post('/create', [CompanyController::class, 'create']);
    Route::post('/get', [CompanyController::class, 'get']);
    Route::post('/update', [CompanyController::class, 'update']);
    Route::post('/delete', [CompanyController::class, 'delete']);
    Route::post('/search', [CompanyController::class, 'search']);
});

Route::group([
    'prefix' => 'project'
], function() {
    Route::post('/create', [ProjectController::class, 'create']);
    Route::post('/get', [ProjectController::class, 'get']);
    Route::post('/update', [ProjectController::class, 'update']);
    Route::post('/delete', [ProjectController::class, 'delete']);
    Route::post('/search', [ProjectController::class, 'search']);
});

Route::group([
    'prefix' => 'clinic'
], function() {
    Route::post('/create', [ClinicalController::class, 'create']);
    Route::post('/get', [ClinicalController::class, 'get']);
    Route::post('/update', [ClinicalController::class, 'update']);
    Route::post('/delete', [ClinicalController::class, 'delete']);
    Route::post('/search', [ClinicalController::class, 'search']);
});
