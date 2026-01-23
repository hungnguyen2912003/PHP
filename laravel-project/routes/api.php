<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::middleware(['auth:api', 'role:admin'])->group(function () {

        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);

        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
        });
    });
});


Route::prefix('user')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::middleware(['role:user', 'auth:api'])->group(function () {

        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);

        Route::prefix('weight')->group(function () {
            Route::get('/', [WeightController::class, 'index']);
            Route::post('/', [WeightController::class, 'store']);
            Route::get('/{id}', [WeightController::class, 'show']);
            Route::put('/{id}', [WeightController::class, 'update']);
            Route::delete('/{id}', [WeightController::class, 'destroy']);
        });

        Route::prefix('height')->group(function () {
            Route::get('/', [HeightController::class, 'index']);
            Route::post('/', [HeightController::class, 'store']);
            Route::get('/{id}', [HeightController::class, 'show']);
            Route::put('/{id}', [HeightController::class, 'update']);
            Route::delete('/{id}', [HeightController::class, 'destroy']);
        });
    });
});
