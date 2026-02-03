<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPaswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SetFirstPasswordRequest;
use Illuminate\Http\Request;
use App\Mail\ActivationMail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    ///////////////////////////////////////////////////////////////////////////
    // Register
    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }
    public function register(RegisterRequest $request)
    {
        //Check if user exists: email or username
        $existingUser = User::where('email', $request->email)->orWhere('username', $request->username)->first();
        if ($existingUser) {
            if ($existingUser->isPending()) {
                flash()->error(__('messages.user_pending_approval'), [], __('messages.error'));
                return redirect()->back();
            }
            flash()->error(__('messages.user_exists'), [], __('messages.error'));
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
        Mail::to($user->email)->locale(App::getLocale())->send(new ActivationMail($activation_token, $user, Carbon::now()->addMinutes(30)));

        //Success message
        flash()->success(__('messages.register_success'), [], __('messages.success'));
        return redirect()->route('login');

    }

    ///////////////////////////////////////////////////////////////////////////
    // Activate
    public function activate(Request $request, $token)
    {
        $email = $request->query('email');
        $user = User::where('activation_token', $token)->where('email', $email)->first();

        if (!$user) {
            flash()->error(__('messages.activation_token_invalid'), [], __('messages.error'));
            return redirect()->route('login');
        }

        if ($user->activation_token_sent_at->addMinutes(30)->isPast()) {
            flash()->error(__('messages.activation_token_expired'), [], __('messages.error'));
            return redirect()->route('login');
        }

        // If user has role 'User', just activate and redirect to verified-account
        if ($user->role->name === 'User') {
            $user->activation_token = null;
            $user->activation_token_sent_at = null;
            $user->status = 'active';
            $user->email_verified_at = Carbon::now();
            $user->save();

            flash()->success(__('messages.activation_success'), [], __('messages.success'));
            session()->flash('verified_access', true);
            return redirect()->route('verified-account');
        }

        return view('pages.auth.set-first-password', [
            'token' => $token,
            'email' => $email,
            'username' => $user->username
        ]);
    }

    public function setFirstPassword(SetFirstPasswordRequest $request, $token)
    {
        $user = User::where('activation_token', $token)
                    ->where('email', $request->email)
                    ->where('username', $request->username)
                    ->first();

        if (!$user) {
            flash()->error(__('messages.activation_token_invalid'), [], __('messages.error'));
            return redirect()->route('login');
        }

        if ($user->activation_token_sent_at->addMinutes(30)->isPast()) {
            flash()->error(__('messages.activation_token_expired'), [], __('messages.error'));
            return redirect()->route('login');
        }

        $user->activation_token = null;
        $user->activation_token_sent_at = null;
        $user->status = 'active';
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make($request->password);
        $user->save();

        flash()->success(__('messages.activation_success'), [], __('messages.success'));
        session()->flash('verified_access', true);
        
        return redirect()->route('login');
    }

    public function verifiedAccount()
    {
        if (!session('verified_access')) {
            return redirect()->route('login');
        }
        return view('pages.auth.verified-account');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Login
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role->name === 'Admin') {
                return redirect()->route('dashboard');
            }
            return redirect()->route('dashboard');
        }
        return view('pages.auth.login');
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
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $user->last_login_at = Carbon::now();
            $user->save();

            if ($user->status === 'pending') {
                // Keep the flash message as warning for pending users
                flash()->warning(__('messages.activate_account_require_all'), [], __('messages.warning'));
            } else {
                 flash()->success(__('messages.login_success'), [], __('messages.success'));
            }

            if ($user->role->name === 'Admin') {
                return redirect()->route('dashboard');
            }
            
            if ($user->status === 'pending') {
                 return redirect()->route('profile');
            }
            
            return redirect()->route('dashboard');
        }

        flash()->error(__('messages.login_invalid'), [], __('messages.error'));
        return redirect()->route('login');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Logout
    public function logout()
    {
        Auth::logout();

        flash()->success(__('messages.logout_success'), [], __('messages.success'));
        return redirect()->route('login');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Forgot Password
    public function showForgotPasswordForm()
    {
        return view('pages.auth.forgot-password');
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

            Mail::to($user->email)->locale(App::getLocale())->send(new ForgotPasswordMail($token, $user->email, $user, Carbon::now()->addMinutes(60)));

            flash()->success(__('messages.password_reset_link_sent'), [], __('messages.success'));
            return redirect()->route('login');
        }

        flash()->error(__('messages.email_not_found'), [], __('messages.error'));
        return redirect()->route('forgot-password');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Reset Password
    public function showResetPasswordForm(Request $request, $token)
    {
        $user = User::where('email', $request->email)->first();
        $username = $user ? $user->username : '';

        return view('pages.auth.reset-password', [
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
            flash()->error(__('messages.token_invalid'), [], __('messages.error'));
            return redirect()->route('login');
        }

        // Check if token is expired (60 mins)
        if ($reset && Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            flash()->error(__('messages.token_expired'), [], __('messages.error'));
            return redirect()->route('login');
        }

        // Check if token is valid
        if ($reset && Hash::check($token, $reset->token)) {

            $user = User::where('email', $request->email)->first();
            $user->update(['password' => Hash::make($request->password)]);

            // Delete the token
            \DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

            flash()->success(__('messages.password_reset_success'), [], __('messages.success'));
            return redirect()->route('login');
        }
    }
}
