<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\AuthController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', function () {
        return view('admin.pages.auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('admin.pages.auth.register');
    })->name('register');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/', function () {
            return view('admin.pages.dashboard');
        })->name('dashboard');

        Route::prefix('users')->group(function () {
            Route::get('/', function () {
                return view('admin.pages.user.index');
            })->name('users');

            Route::get('/add', function () {
                return view('admin.pages.user.add');
            })->name('users.add');

            Route::get('/edit/{id}', function ($id) {
                return view('admin.pages.user.edit', compact('id'));
            })->name('users.edit');

            Route::get('/delete/{id}', function ($id) {
                return view('admin.pages.user.delete', compact('id'));
            })->name('users.delete');
        });
    });
});

Route::get('/', function () {
    return view('client.pages.home');
})->name('home');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.post');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset-password.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('activate');


