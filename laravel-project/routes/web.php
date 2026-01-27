<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\SettingController;

// admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', function () {
        return view('admin.pages.auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('admin.pages.auth.register');
    })->name('register');

    Route::middleware('admin.auth')->group(function () {
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

// guest
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.post');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('user.auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/resend-activation', [AuthController::class, 'resendActivation'])->name('resend-activation');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::prefix('setting')->name('setting.')->group(function () {
        //Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::get('/account', [SettingController::class, 'account'])->name('account');
        Route::put('/account', [SettingController::class, 'updateAccount'])->name('account.update');
        Route::get('/change-password', [SettingController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [SettingController::class, 'changePasswordUpdate'])->name('change-password.update');
    });
});

Route::get('/', function () {
    return view('client.pages.home');
})->name('home');

Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('activate');
Route::get('/verified-account', [AuthController::class,'verifiedAccount'])->name('verified-account');



Route::get('language/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'vi', 'ja'])) {
        abort(400);
    }

    session()->put('locale', $locale);

    return redirect()->back();
})->name('change-language');
