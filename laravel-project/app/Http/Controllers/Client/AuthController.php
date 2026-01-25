<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\ActivationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.pages.login');
    }

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
}
