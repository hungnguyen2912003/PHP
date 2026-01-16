<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

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

Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'store']);
    Route::get('/{id}', [TaskController::class, 'show']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);
});