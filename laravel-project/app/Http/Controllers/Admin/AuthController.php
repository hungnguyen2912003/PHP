<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SetFirstPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\Admin\ActivationMail;
use App\Models\User;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function showLoginForm()
    {
        return view('admin.pages.auth.login');
    }

    public function login(LoginRequest $request)
    {
        // Determine if login is email or username
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($loginField, $request->login)->first();

        // Check account exist
        if (!$user) {
            flash()->error(__('message.login.account_not_found'), [], __('notification.error'));
            return back()->withInput($request->only('login', 'remember'));
            }

        // Check incorrect password
        if (!Auth::guard('admin')->attempt([
            $loginField => $request->login,
            'password'  => $request->password
        ], $request->boolean('remember'))) {
            flash()->error(__('message.login.invalid_credentials'), [], __('notification.error'));
            return back()->withInput($request->only('login', 'remember'));
        }

        // Check role
        if (!in_array($user->role, ['admin', 'staff', 'Admin', 'Staff'], true)) {
            flash()->error(__('message.login.no_admin_permission'), [], __('notification.error'));
            return back()->withInput($request->only('login', 'remember'));
        }

        $request->session()->regenerate();

        $user = Auth::guard('admin')->user();
        $user->last_login_at = now();
        $user->save();

        flash()->success(
            __('message.login.status.success'),
            [],
            __('notification.success')
        );

        return redirect()->route('admin.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout()
    {
        $locale = session('locale');
    
        Auth::guard('admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Set locale session
        session(['locale' => $locale]);

        flash()->success(
            __('message.logout.status.success'),
            [],
            __('notification.success')
        );

        return redirect()->route('admin.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Set First Password
    |--------------------------------------------------------------------------
    */

    public function activate(Request $request, $token)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            flash()->error(__('message.user.activation.invalid_link'), [], __('notification.error'));
            return redirect()->route('admin.login');
        }

        if ($user->status !== User::STATUS_PENDING) {
            flash()->error(__('message.user.activation.already_active'), [], __('notification.error'));
            return redirect()->route('admin.login');
        }

        if (!$user->activation_token || !hash_equals($user->activation_token, hash('sha256', $token))) {
            flash()->error(__('message.user.activation.invalid_link'), [], __('notification.error'));
            return redirect()->route('admin.login');
        }

        $expiresAt = $user->activation_token_sent_at ? $user->activation_token_sent_at->copy()->addMinutes(30) : null;

        if (!$expiresAt || now()->gt($expiresAt)) {
            flash()->error(__('message.user.activation.expired_link'), [], __('notification.error'));
            return redirect()->route('admin.login');
        }

        return view('admin.pages.auth.set-first-password', [
            'token' => $token,
            'email' => $email,
            'username' => $user->username,
        ]);
    }

    public function setFirstPassword(SetFirstPasswordRequest $request, $token)
    {
        $hashedToken = hash('sha256', $token);
        $user = User::where('activation_token', $hashedToken)
                    ->where('email', $request->email)
                    ->where('username', $request->username)
                    ->first();

        if (!$user) {
            flash()->error(__('message.user.activation.invalid_link'), [], __('notification.error'));
            return redirect()->route('admin.login');
        }

        $expiresAt = $user->activation_token_sent_at ? $user->activation_token_sent_at->copy()->addMinutes(30) : null;

        if (!$expiresAt || now()->gt($expiresAt)) {
            flash()->error(__('message.user.activation.expired_link'), [], __('notification.error'));
            return redirect()->route('admin.login');
        }

        $user->update([
            'password' => Hash::make($request->password),
            'status' => User::STATUS_ACTIVE,
            'activation_token' => null,
            'activation_token_sent_at' => null,
            'email_verified_at' => now(),
        ]);

        flash()->success(__('message.user.activation.success'), [], __('notification.success'));
        
        return redirect()->route('admin.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Resend Activation
    |--------------------------------------------------------------------------
    */

    public function resendActivation($id)
    {
        $user = User::findOrFail($id);

        if ($user->status !== User::STATUS_PENDING) {
            flash()->error(__('message.user.resend_activation_failed'), [], __('notification.error'));
            return back();
        }

        $cooldownSeconds = 300;
        $key = 'resend-activation:' . $user->id;

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $retryAfter = RateLimiter::availableIn($key);
            flash()->error(__('message.user.please_wait_seconds', ['seconds' => $retryAfter]), [], __('notification.error'));
            return back();
        }
        RateLimiter::hit($key, $cooldownSeconds);

        $now = now();
        $expiresInMinutes = 30;

        $plainToken = Str::random(64);
        $hashedToken = hash('sha256', $plainToken);

        try {
            DB::transaction(function () use ($user, $hashedToken, $now, $plainToken, $expiresInMinutes) {
                $user->update([
                    'activation_token' => $hashedToken,
                    'activation_token_sent_at' => $now,
                ]);

                Mail::to($user->email)
                    ->locale(app()->getLocale())
                    ->send(new ActivationMail($plainToken, $user, $now->copy()->addMinutes($expiresInMinutes)));
            });

            flash()->success(__('message.user.resend_activation_success'), [], __('notification.success'));
            return back();
        } catch (\Throwable $e) {
            report($e);
            flash()->error(__('message.user.resend_activation_failed'), [], __('notification.error'));
            return back();
        }
    }
}
