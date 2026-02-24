<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ForgotPasswordController as AdminForgotPasswordController;
use App\Http\Controllers\Admin\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\ContestController as AdminContestController;
use App\Http\Controllers\Admin\ContestDetailController as AdminContestDetailController;
use App\Http\Controllers\Admin\MeasurementController as AdminMeasurementController;

use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\Client\SettingController as ClientSettingController;
use App\Http\Controllers\Client\AuthController as ClientAuthController;
use App\Http\Controllers\Client\ForgotPasswordController as ClientForgotPasswordController;
use App\Http\Controllers\Client\ResetPasswordController as ClientResetPasswordController;

use App\Http\Controllers\Client\MeasurementController;


use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;


/*
|--------------------------------------------------------------------------
| Guest (web)
|--------------------------------------------------------------------------
*/
Route::name('client.')->group(function () {
    // Moved to auth group below
});

Route::middleware('guest:web')->name('client.')->group(function () {

    Route::get('/login', [ClientAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ClientAuthController::class, 'login'])->name('login.post');

    Route::get('/register', [ClientAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [ClientAuthController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [ClientForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [ClientForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot-password.post');

    Route::get('/reset-password/{token}', [ClientResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password/{token}', [ClientResetPasswordController::class, 'resetPassword'])->name('password.update');

    Route::get('/activate/{token}', [ClientAuthController::class, 'activate'])->name('activate');
});


/*
|--------------------------------------------------------------------------
| User (web) - authenticated
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web'])->name('client.')->group(function () {

    Route::match(['get', 'post'], '/logout', [ClientAuthController::class, 'logout'])->name('logout');

    Route::get('/', [ClientDashboardController::class, 'index'])->name('dashboard');

    Route::post('/resend-activation', [ClientAuthController::class, 'resendActivation'])->name('resend-activation');

    Route::get('/dashboard/chart-data', [ClientDashboardController::class, 'getChartData'])->name('dashboard.chart-data');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ClientProfileController::class, 'index'])->name('index');
        Route::put('/avatar', [ClientProfileController::class, 'updateAvatar'])->name('avatar.update');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/account', [ClientSettingController::class, 'account'])->name('account');
        Route::put('/account', [ClientSettingController::class, 'updateAccount'])->name('account.update');

        Route::get('/change-password', [ClientSettingController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [ClientSettingController::class, 'changePasswordUpdate'])->name('change-password.update');
    });

    Route::prefix('measurement')->name('measurement.')->group(function () {

        Route::get('/', [MeasurementController::class, 'index'])->name('index');
        Route::get('/show/{id}', [MeasurementController::class, 'show'])->name('show');

        Route::get('/create', [MeasurementController::class, 'create'])->name('create');
        Route::post('/store', [MeasurementController::class, 'store'])->name('store');

        Route::get('/edit/{id}', [MeasurementController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [MeasurementController::class, 'update'])->name('update');

        Route::delete('/destroy/{id}', [MeasurementController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Admin (prefix /admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

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

        Route::get('/activate/{token}', [AdminAuthController::class, 'activate'])->name('activate');
        Route::post('/activate/{token}', [AdminAuthController::class, 'setFirstPassword'])->name('activate.password');
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin.auth', 'role:Admin,Staff'])->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');

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

        Route::middleware('role:Admin')->prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/show/{id}', [UserController::class, 'show'])->name('show');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::post('/edit/{id}', [UserController::class, 'editPost'])->name('update');
            Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('/resend-activation/{id}', [AdminAuthController::class, 'resendActivation'])->name('resend-activation');
        });

        Route::prefix('measurements')->name('measurements.')->group(function () {
            Route::get('/', [AdminMeasurementController::class, 'index'])->name('index');
            Route::get('/user/{id}', [AdminMeasurementController::class, 'user'])->name('user');
            Route::post('/import/{id}', [AdminMeasurementController::class, 'import'])->name('import');
            Route::get('/edit/{id}', [AdminMeasurementController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [AdminMeasurementController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [AdminMeasurementController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('contests')->name('contests.')->group(function () {
            Route::get('/', [AdminContestController::class, 'index'])->name('index');
            Route::get('/show/{id}', [AdminContestController::class, 'show'])->name('show');
            Route::get('/create', [AdminContestController::class, 'create'])->name('create');
            Route::post('/store', [AdminContestController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [AdminContestController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [AdminContestController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [AdminContestController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('contest-details')->name('contest-details.')->group(function () {
            Route::get('/', [AdminContestDetailController::class, 'index'])->name('index');
            Route::get('/show/{id}', [AdminContestDetailController::class, 'show'])->name('show');
            Route::get('/create', [AdminContestDetailController::class, 'create'])->name('create');
            Route::post('/store', [AdminContestDetailController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [AdminContestDetailController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [AdminContestDetailController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [AdminContestDetailController::class, 'destroy'])->name('destroy');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'vi', 'ja', 'zh'])) {
        abort(400);
    }

    session()->put('locale', $locale);
    return redirect()->back();
})->name('change-language');

Route::fallback(fn() => abort(404));
