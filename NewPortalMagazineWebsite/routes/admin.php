<?php

use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('login', [AuthenticationController::class, 'handleLogin'])->name('login.post');
    Route::get('forgot-password', [AuthenticationController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [AuthenticationController::class, 'handleForgotPassword'])->name('forgot-password.post');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
});
