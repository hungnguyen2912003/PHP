<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Mail\Client\ActivationMail;
use App\Models\User;

class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register
    |--------------------------------------------------------------------------
    */

    public function showRegistrationForm()
    {
        return view('client.pages.auth.register');
    }
    
    public function register(RegisterRequest $request)
    {
        //Check if user exists: email or username
        $existingUser = User::where('email', $request->email)->orWhere('username', $request->username)->first();
        if ($existingUser) {
            flash()->error(__('message.register.user_exists'), [], __('notification.error'));
            return redirect()->back()->withInput();
        }


        //Create activation token
        $plainToken = Str::random(64);
        $hashedToken = hash('sha256', $plainToken);

        //Create new user
        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'username' => $request->username,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'pending',
            'activation_token' => $hashedToken,
            'activation_token_sent_at' => Carbon::now(),
        ]);

        //Send activation email
        Mail::to($user->email)
            ->locale(App::getLocale())
            ->send(new ActivationMail($plainToken, $user, Carbon::now()->addMinutes(30)));

        //Success message
        flash()->success(__('message.register.success'), [], __('notification.success'));
        return redirect()->route('client.login');
    }   

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function showLoginForm()
    {
        return view('client.pages.auth.login');
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
        if (!Auth::guard('web')->attempt([
            $loginField => $request->login,
            'password'  => $request->password
        ], $request->boolean('remember'))) {
            flash()->error(__('message.login.invalid_credentials'), [], __('notification.error'));
            return back()->withInput($request->only('login', 'remember'));
        }

        $request->session()->regenerate();

        $user = Auth::guard('web')->user();
        $user->last_login_at = now();
        $user->save();

        flash()->success(
            __('message.login.status.success'),
            [],
            __('notification.success')
        );

        return redirect()->route('client.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout()
    {
        $locale = session('locale');
    
        Auth::guard('web')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Set locale session
        session(['locale' => $locale]);

        flash()->success(
            __('message.logout.status.success'),
            [],
            __('notification.success')
        );

        return redirect()->route('client.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Active Account
    |--------------------------------------------------------------------------
    */

    public function activate(Request $request, $token)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            flash()->error(__('message.user.activation.invalid_link'), [], __('notification.error'));
            return redirect()->route('client.login');
        }

        if ($user->status !== 'pending') {
            flash()->error(__('message.user.activation.already_active'), [], __('notification.error'));
            return redirect()->route('client.login');
        }

        if (!$user->activation_token || !hash_equals($user->activation_token, hash('sha256', $token))) {
            flash()->error(__('message.user.activation.invalid_link'), [], __('notification.error'));
            return redirect()->route('client.login');
        }

        $expiresAt = $user->activation_token_sent_at ? $user->activation_token_sent_at->copy()->addMinutes(30) : null;

        if (!$expiresAt || now()->gt($expiresAt)) {
            flash()->error(__('message.user.activation.expired_link'), [], __('notification.error'));
            return redirect()->route('client.login');
        }

        $user->update([
            'status' => 'active',
            'activation_token' => null,
            'activation_token_sent_at' => null,
            'email_verified_at' => now(),
        ]);

        flash()->success(__('message.user.activation.success'), [], __('notification.success'));

        return redirect()->route('client.login');
    }
}
