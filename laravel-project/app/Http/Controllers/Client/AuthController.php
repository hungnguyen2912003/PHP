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

        //Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
            'status' => 'pending',
        ]);

        // Create activation token
        $activation_token = Str::random(64);
        \DB::table('activation_tokens')->insert([
            'email' => $user->email,
            'token' => $activation_token,
            'created_at' => now(),
        ]);

        //Send activation email
        Mail::to($user->email)->send(new ActivationMail($activation_token, $user));

        //Success message
        toastr()->success('User registered successfully. Please check your email for activation link (valid for 24h).');
        return redirect()->route('login');

    }

    ///////////////////////////////////////////////////////////////////////////
    // Activate
    public function activate(Request $request, $token)
    {
        $email = $request->query('email');
        if (!$email) {
            toastr()->error('Invalid activation link (missing email).');
            return redirect()->route('login');
        }

        $activationRecord = \DB::table('activation_tokens')->where([
            'email' => $email,
            'token' => $token
        ])->first();

        if ($activationRecord && \Carbon\Carbon::parse($activationRecord->created_at)->addHours(24)->isFuture()) {

            $user = User::where('email', $email)->first();
            if ($user) {
                $user->status = 'active';
                $user->save();

                // Delete the token
                \DB::table('activation_tokens')->where(['email' => $email])->delete();

                toastr()->success('User activated successfully.');
                return redirect()->route('login');
            }
        }

        toastr()->error('Invalid or expired activation token.');
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

                // Generate JWT Token
                $token = auth('api')->login($user);

                // Create HTTP-Only Cookie (1 day duration)
                $cookie = cookie('jwt_token', $token, 60 * 24, null, null, false, true);

                toastr()->success('Login successfully.');
                return redirect()->route('home')->withCookie($cookie);
            }

            toastr()->warning('You are not authorized to access this page.');
            Auth::logout();
            return redirect()->route('login');
        }

        // Check if user is pending (for better error message)
        $user = User::where($login, $request->login)->first();
        if ($user && $user->isPending()) {
            toastr()->warning('Your account is pending approval. Please check your email for activation link.');
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

        // Remove JWT Cookie
        $cookie = cookie()->forget('jwt_token');

        toastr()->success('Logout successfully.');
        return redirect()->route('login')->withCookie($cookie);
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
                    'token' => $token,
                    'created_at' => now()
                ]
            );

            Mail::to($user->email)->send(new ForgotPasswordMail($token, $user->email));

            toastr()->success('Password reset link has been sent to your email (valid for 60 mins).');
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
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $resetRecord = \DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $token,
        ])->first();

        // Check if token exists and is not expired (60 mins)
        if ($resetRecord && \Carbon\Carbon::parse($resetRecord->created_at)->addMinutes(60)->isFuture()) {

            $user = User::where('email', $request->email)->first();
            $user->update(['password' => Hash::make($request->password)]);

            // Delete the token
            \DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

            toastr()->success('Password reset successfully. You can now login with your new password.');
            return redirect()->route('login');
        }

        toastr()->error('Invalid or expired reset token.');
        return redirect()->route('login');
    }
}
