<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function () {
    return response()->json([
        'ok' => true,
        'message' => 'Pong'
    ]);
});

Route::get('/hello/{name}', function ($name) {
    return response()->json([
        'message' => "Hello {$name}"
    ]);
});

Route::prefix('/auth')->group(function () {
    Route::post('/register', function () {
        return response()->json([
            'message' => 'Register ok'
        ]);
    });

    Route::post('/login', function () {
        return response()->json([
            'message' => 'Login ok'
        ]);
    });
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Route not found'
    ], 404);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::apiResource('tasks', TaskController::class);
});
