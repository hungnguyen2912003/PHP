<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;

// admin
Route::middleware('admin.auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/resend-activation', [AuthController::class, 'resendActivation'])->name('resend-activation');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/account', [SettingController::class, 'account'])->name('account');
        Route::put('/account', [SettingController::class, 'updateAccount'])->name('account.update');
        Route::get('/change-password', [SettingController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [SettingController::class, 'changePasswordUpdate'])->name('change-password.update');
    });
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/store', [UserController::class, 'store'])->name('store');
        Route::post('/store', [UserController::class, 'storePost'])->name('store.post');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::post('/update/{id}', [UserController::class, 'updatePost'])->name('update.post');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
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

// user
Route::middleware('user.auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/resend-activation', [AuthController::class, 'resendActivation'])->name('resend-activation');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/account', [SettingController::class, 'account'])->name('account');
        Route::put('/account', [SettingController::class, 'updateAccount'])->name('account.update');
        Route::get('/change-password', [SettingController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [SettingController::class, 'changePasswordUpdate'])->name('change-password.update');
    });
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('activate');
Route::post('/activate/{token}', [AuthController::class, 'setFirstPassword'])->name('activate.password');
Route::get('/verified-account', [AuthController::class,'verifiedAccount'])->name('verified-account');



Route::get('language/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'vi', 'ja'])) {
        abort(400);
    }

    session()->put('locale', $locale);

    return redirect()->back();
})->name('change-language');

Route::fallback(function () {
    abort(404);
});
