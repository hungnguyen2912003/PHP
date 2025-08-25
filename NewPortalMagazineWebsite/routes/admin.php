<?php

use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('login', [AuthenticationController::class, 'handleLogin'])->name('login.post');
    Route::get('forgot-password', [AuthenticationController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [AuthenticationController::class, 'sendResetPasswordLink'])->name('forgot-password.post');
    Route::get('reset-password/{token}', [AuthenticationController::class, 'resetPassword'])->name('reset-password');
    Route::post('reset-password', [AuthenticationController::class, 'handleResetPassword'])->name('reset-password.post');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile/{id}', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/{id}/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
});
