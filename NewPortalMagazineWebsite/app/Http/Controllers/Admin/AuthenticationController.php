<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginHandleRequest;
use App\Http\Requests\Admin\ForgotPasswordHandleRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\SendResetPasswordLinkMail;
use App\Http\Requests\Admin\ResetPasswordHandleRequest;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function handleLogin(LoginHandleRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function forgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetPasswordLink(ForgotPasswordHandleRequest $request)
    {
        $token = Str::random(60);

        $admin = Admin::where('email', $request->email)->first();

        $admin->remember_token = $token;
        $admin->save();

        Mail::to($admin->email)->send(new SendResetPasswordLinkMail($token, $admin->email));

        return redirect()->back()->with('success', 'Reset password link sent to your email');
    }

    public function resetPassword($token)
    {
        return view('admin.auth.reset-password', compact('token'));
    }

    public function handleResetPassword(ResetPasswordHandleRequest $request)
    {
        $token = $request->input('token');

        $admin = Admin::where('email', $request->email)->where('remember_token', $token)->first();

        if (!$admin) {
            return redirect()->back()->with('error', 'Invalid email or token');
        }

        $admin->password = Hash::make($request->password);
        $admin->remember_token = null;
        $admin->save();

        return redirect()->route('admin.login')->with('success', 'Password reset successfully, please login with your new password');
    }
}
