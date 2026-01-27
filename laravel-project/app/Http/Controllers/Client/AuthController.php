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
                flash()->error('User is already registered and pending approval.');
                return redirect()->back();
            }
            flash()->error('User already exists.');
            return redirect()->back();
        }

        $role = Role::where('name', 'User')->first();

        //Create activation token
        $activation_token = Str::random(64);

        //Create new user
        $user = User::create([
            'fullname' => $request->fullname,
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
        flash()->success('User registered successfully. Please check your email for activation link');
        return redirect()->route('login');

    }

    ///////////////////////////////////////////////////////////////////////////
    // Activate
    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            flash()->error('Invalid activation token. Please login your account then go to Profile page to send activation email again.');
            return redirect()->route('login');
        }

        if ($user->activation_token_sent_at->addMinutes(30)->isPast()) {
            flash()->error('Your activation token has expired. Please login your account then go to Profile page to send activation email again.');
            return redirect()->route('login');
        }

        $user->activation_token = null;
        $user->activation_token_sent_at = null;
        $user->status = 'active';
        $user->email_verified_at = Carbon::now();
        $user->save();
        flash()->success('Your account has been activated successfully.');
        session()->flash('verified_access', true);
        return redirect()->route('verified-account');
    }

    public function resendActivation(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            flash()->error('User not found.');
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        if ($user->status !== 'pending') {
            flash()->error('Account is already active.');
            return response()->json(['success' => false, 'message' => 'Account is already active.'], 400);
        }

        // Create new activation token
        $activation_token = Str::random(64);

        // Update user
        $user->update([
            'activation_token' => $activation_token,
            'activation_token_sent_at' => Carbon::now(),
        ]);

        // Send activation email
        Mail::to($user->email)->send(new ActivationMail($activation_token, $user, Carbon::now()->addMinutes(30)));

        flash()->success('Activation link sent to your email.');
        return response()->json(['success' => true, 'message' => 'Activation link sent to your email.']);
    }

    public function verifiedAccount()
    {
        if (!session('verified_access')) {
            return redirect()->route('login');
        }
        return view('auth.pages.verified-account');
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
            'password' => $request->password
        ];

        // Attempt Web Session Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $user->last_login_at = Carbon::now();
            $user->save();
            flash()->success('Login successfully.');
            return redirect()->route('home');
        }

        flash()->error('Invalid login info.');
        return redirect()->route('login');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Logout
    public function logout()
    {
        Auth::logout();

        flash()->success('Logout successfully.');
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

            flash()->success('Password reset link has been sent to your email.');
            return redirect()->route('login');
        }

        flash()->error('Email not found.');
        return redirect()->route('forgot-password');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Reset Password
    public function showResetPasswordForm(Request $request, $token)
    {
        $user = User::where('email', $request->email)->first();
        $username = $user ? $user->username : '';

        return view('auth.pages.reset-password', [
            'token' => $token,
            'email' => $request->email,
            'username' => $username
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request, $token)
    {
        $reset = \DB::table('password_reset_tokens')->where('email', $request->email)->first();

        // Check if token exists
        if (!$reset) {
            flash()->error('Invalid token.');
            return redirect()->route('login');
        }

        // Check if token is expired (60 mins)
        if ($reset && Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            flash()->error('Token has expired. Please request a new one.');
            return redirect()->route('login');
        }

        // Check if token is valid
        if ($reset && Hash::check($token, $reset->token)) {

            $user = User::where('email', $request->email)->first();
            $user->update(['password' => Hash::make($request->password)]);

            // Delete the token
            \DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

            flash()->success('Password reset successfully. You can now login with your new password.');
            return redirect()->route('login');
        }
    }
}
