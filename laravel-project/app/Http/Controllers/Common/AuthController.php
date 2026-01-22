<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\LogInRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LogInRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            if ($user->role !== 'admin') {
                auth()->logout();
                return response()->json([
                    'message' => 'Unauthorized. Admin access only.'
                ], 403);
            }

            $token = $user->createToken('admin-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function refresh(Request $request)
    {
        // For Sanctum, "refresh" usually means just issuing a new token
        // But often strict refresh tokens are not standard.
        // We can just return a new token and delete the old one, or similar.
        // For simplicity, we can validly just issue a new one.

        $request->user()->currentAccessToken()->delete();
        $token = $request->user()->createToken('admin-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
