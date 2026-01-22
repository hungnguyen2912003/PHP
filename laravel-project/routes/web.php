<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Common\AuthController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', function () {
        return view('admin.pages.auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('admin.pages.auth.register');
    })->name('register');

    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.pages.dashboard');
        })->name('dashboard');
        Route::get('/users', function () {
            return view('admin.pages.user');
        })->name('users');
    });
});
