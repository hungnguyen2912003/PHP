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
    return redirect()->route('admin.login');
});
