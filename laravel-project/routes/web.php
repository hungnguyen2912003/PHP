<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ForgotPasswordController as AdminForgotPasswordController;
use App\Http\Controllers\Admin\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Guest (web)
|--------------------------------------------------------------------------
*/
Route::middleware('guest:web')->group(function () {
    // Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    // Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
    // Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.post');

    // Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    // Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.update');

    // Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('activate');
    // Route::post('/activate/{token}', [AuthController::class, 'setFirstPassword'])->name('activate.password');
});


/*
|--------------------------------------------------------------------------
| User (web) - authenticated
|--------------------------------------------------------------------------
*/
// Route::middleware(['auth:web'])->group(function () {

//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//     Route::post('/resend-activation', [AuthController::class, 'resendActivation'])->name('resend-activation');

//     Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
//     Route::put('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

//     Route::prefix('setting')->name('setting.')->group(function () {
//         Route::get('/account', [SettingController::class, 'account'])->name('account');
//         Route::put('/account', [SettingController::class, 'updateAccount'])->name('account.update');

//         Route::get('/change-password', [SettingController::class, 'changePassword'])->name('change-password');
//         Route::post('/change-password', [SettingController::class, 'changePasswordUpdate'])->name('change-password.update');
//     });
// });

/*
|--------------------------------------------------------------------------
| Admin (prefix /admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Guest
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

        Route::get('/forgot-password', [AdminForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');
        Route::post('/forgot-password', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot-password.post');

        Route::get('/reset-password/{token}', [AdminResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
        Route::post('/reset-password/{token}', [AdminResetPasswordController::class, 'resetPassword'])->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth:admin', 'role:Admin,Staff'])->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [AdminProfileController::class, 'index'])->name('index');
            Route::put('/avatar', [AdminProfileController::class, 'updateAvatar'])->name('avatar.update');
        });

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/account', action: [AdminSettingController::class, 'account'])->name('account');
            Route::put('/account', action: [AdminSettingController::class, 'updateAccount'])->name('account.update');
            
            Route::get('/change-password', action: [AdminSettingController::class, 'changePassword'])->name('change-password');
            Route::post('/change-password', action: [AdminSettingController::class, 'changePasswordUpdate'])->name('change-password.update');
        });

        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/show/{id}', [UserController::class, 'show'])->name('show');

            Route::get('/create', [UserController::class, 'store'])->name('create');
            Route::post('/create', [UserController::class, 'storePost'])->name('store');

            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::post('/edit/{id}', [UserController::class, 'editPost'])->name('update');

            Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');

            Route::post('/resend-activation/{id}', [UserController::class, 'resendActivation'])->name('resend-activation');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('language/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'vi', 'ja'])) {
        abort(400);
    }

    session()->put('locale', $locale);
    return redirect()->back();
})->name('change-language');

Route::fallback(fn () => abort(404));
