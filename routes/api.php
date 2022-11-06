<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\PriorityController;
use App\Http\Controllers\Api\TaskController;

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

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::prefix('/auth')->group(function () {
            Route::post('/login', 'login')->withoutMiddleware('auth:sanctum');
            Route::post('/logout', 'logout');
        });
    });

    Route::controller(StatusController::class)->group(function () {
        Route::prefix('/statuses')->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::controller(ProjectController::class)->group(function () {
        Route::prefix('/projects')->group(function () {
            Route::get('/', 'index');
        });
    });

    // Route::controller(UserController::class)->group(function () {
    //     Route::prefix('/users')->group(function () {
    //         Route::get('/byProjects', 'byProjects');
    //     });
    // });

    Route::controller(PriorityController::class)->group(function () {
        Route::prefix('/priorities')->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::controller(TaskController::class)->group(function () {
        Route::prefix('/tasks')->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::put('/changeStatus/{id}', 'updateStatus')->whereNumber('id');
        });
    });
});
