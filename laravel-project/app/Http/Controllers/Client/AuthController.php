<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPaswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;
use App\Mail\ActivationMail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    ///////////////////////////////////////////////////////////////////////////
    // Register
    public function showRegisterForm()
    {
        return view('auth.pages.register');
    }
    public function register(RegisterRequest $request)
    {
        //Check if user exists: email or username
        $existingUser = User::where('email', $request->email)->orWhere('username', $request->username)->first();
        if ($existingUser) {
            if ($existingUser->isPending()) {
                toastr()->error('User is already registered and pending approval.');
                return redirect()->back();
            }
            toastr()->error('User already exists.');
            return redirect()->back();
        }

        $role = Role::where('name', 'User')->first();

        //Create activation token
        $activation_token = Str::random(64);

        //Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
            'status' => 'pending',
            'activation_token' => $activation_token,
            'activation_token_sent_at' => Carbon::now(),
        ]);

        //Send activation email
        Mail::to($user->email)->send(new ActivationMail($activation_token, $user, Carbon::now()->addMinutes(30)));

        //Success message
        toastr()->success('User registered successfully. Please check your email for activation link');
        return redirect()->route('login');

    }

    ///////////////////////////////////////////////////////////////////////////
    // Activate
    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            toastr()->error('Invalid activation token. Please register again.');
            return redirect()->route('login');
        }

        if ($user->activation_token_sent_at->addMinutes(30)->isPast()) {
            toastr()->error('Your activation token has expired. Please register again.');
            return redirect()->route('login');
        }

        $user->activation_token = null;
        $user->activation_token_sent_at = null;
        $user->status = 'active';
        $user->email_verified_at = Carbon::now();
        $user->save();
        toastr()->success('Your account has been activated successfully.');
        return redirect()->route('login');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Login
    public function showLoginForm()
    {
        return view('auth.pages.login');
    }

    public function login(LoginRequest $request)
    {
        // Determine if login is email or username
        $login = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $login => $request->login,
            'password' => $request->password,
            'status' => 'active'
        ];

        // Attempt Web Session Login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (in_array($user->role->name, ['Admin', 'User'])) {
                $user->last_login_at = Carbon::now();
                $user->save();
                toastr()->success('Login successfully.');
                return redirect()->route('home');
            }

            toastr()->warning('You are not authorized to access this page.');
            Auth::logout();
            return redirect()->route('login');
        }

        toastr()->error('Invalid login info.');
        return redirect()->route('login');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Logout
    public function logout()
    {
        Auth::logout();

        toastr()->success('Logout successfully.');
        return redirect()->route('login');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Forgot Password
    public function showForgotPasswordForm()
    {
        return view('auth.pages.forgot-password');
    }
    public function forgotPassword(ForgotPaswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = Str::random(64);

            // Update or Insert into password_reset_tokens
            \DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => Hash::make($token),
                    'created_at' => Carbon::now()
                ]
            );

            Mail::to($user->email)->send(new ForgotPasswordMail($token, $user->email, $user, Carbon::now()->addMinutes(60)));

            toastr()->success('Password reset link has been sent to your email.');
            return redirect()->route('login');
        }

        toastr()->error('Email not found.');
        return redirect()->route('forgot-password');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Reset Password
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.pages.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(ResetPasswordRequest $request, $token)
    {
        $reset = \DB::table('password_reset_tokens')->where('email', $request->email)->first();

        // Check if token exists
        if (!$reset) {
            toastr()->error('Invalid token.');
            return redirect()->route('login');
        }

        // Check if token is expired (60 mins)
        if ($reset && Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            toastr()->error('Token has expired. Please request a new one.');
            return redirect()->route('login');
        }

        // Check if token is valid
        if ($reset && Hash::check($token, $reset->token)) {

            $user = User::where('email', $request->email)->first();
            $user->update(['password' => Hash::make($request->password)]);

            // Delete the token
            \DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

            toastr()->success('Password reset successfully. You can now login with your new password.');
            return redirect()->route('login');
        }
    }
}
