<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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