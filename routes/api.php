<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BankDetailsController;
use Illuminate\Support\Facades\Route;

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

Route::group(
    [
        'prefix' => 'auth'
    ],
    function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/registration', [AuthController::class, 'registration']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/me', [AuthController::class, 'me']);
    }
);

Route::group(
    [
        'prefix' => 'users'
    ],
    function () {
        Route::post('/all', [UsersController::class, 'all']);
        Route::post('/create', [UsersController::class, 'create']);
        Route::post('/read', [UsersController::class, 'read']);
        Route::post('/update', [UsersController::class, 'update']);
        Route::post('/delete', [UsersController::class, 'delete']);
        Route::post('/search', [UsersController::class, 'search']);
    }
);

Route::group(
    [
        'prefix' => 'cat'
    ],
    function () {
        Route::post('/index', [CategoriesController::class, 'index']);
        Route::post('/create', [CategoriesController::class, 'create']);
        Route::post('/get', [CategoriesController::class, 'get']);
        Route::post('/update', [CategoriesController::class, 'update']);
        Route::post('/delete', [CategoriesController::class, 'delete']);
        Route::post('/search', [CategoriesController::class, 'search']);
    }
);

Route::group(
    [
        'prefix' => 'project'
    ],
    function () {
        Route::post('/tools', [ProjectController::class, 'tools']);
        Route::post('/create', [ProjectController::class, 'create']);
        Route::post('/list', [ProjectController::class, 'list']);
        Route::post('/get', [ProjectController::class, 'get']);
        Route::post('/update', [ProjectController::class, 'update']);
        Route::post('/delete', [ProjectController::class, 'delete']);
        Route::post('/search', [ProjectController::class, 'search']);
    }
);

Route::group(
    [
        'prefix' => 'company'
    ],
    function () {
        Route::post('/updatemain', [CompanyController::class, 'updateMain']);
        Route::post('/details', [BankDetailsController::class, 'getDetails']);
        Route::post('/newdetail', [BankDetailsController::class, 'create']);
    }
);
