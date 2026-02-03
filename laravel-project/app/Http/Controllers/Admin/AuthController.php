<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
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
        if (!in_array($user->role->name, ['Admin', 'Staff'], true)) {
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
}
