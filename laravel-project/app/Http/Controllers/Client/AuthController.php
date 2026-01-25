<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\ActivationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

        //Create activation token
        $activation_token = Str::random(64);
        $role = Role::where('name', 'User')->first();

        //Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
            'activation_token' => $activation_token,
            'status' => 'pending',
        ]);

        //Send activation email
        Mail::to($user->email)->send(new ActivationMail($activation_token, $user));

        //Success message
        toastr()->success('User registered successfully. Please check your email for activation link.');
        return redirect()->route('login');

    }

    ///////////////////////////////////////////////////////////////////////////
    // Activate
    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if ($user) {
            $user->activation_token = null;
            $user->status = 'active';
            $user->save();
            toastr()->success('User activated successfully.');
            return redirect()->route('login');
        }
        toastr()->error('Invalid activation or expired token.');
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
}
