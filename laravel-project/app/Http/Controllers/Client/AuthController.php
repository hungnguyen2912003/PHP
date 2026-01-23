<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;

use App\Models\User;

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
        $user = User::create($request->validated());
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    } 
}
