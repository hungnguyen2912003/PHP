<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\LogInRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LogInRequest $request)
    {
        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginType => $request->input('login'),
            'password' => $request->input('password')
        ];

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json([
                'status_code' => 401,
                'body' => [
                    'data' => []
                ]
            ], 401);
        }

        $user = auth('api')->user();

        $user->last_login_at = now();
        $user->save();

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->success(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $token = $request->bearerToken() ?? $request->cookie('auth_token');
            if ($token) {
                auth('api')->setToken($token)->logout();
            }
        } catch (\Exception $e) {
            // Token might be already invalid, ignore error
        }

        $cookie = cookie()->forget('auth_token');

        return $this->success(null)->withCookie($cookie);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $ttl = auth('api')->factory()->getTTL(); // Minutes
        $cookie = cookie('auth_token', $token, $ttl, '/', null, false, true, false, 'Lax');

        return $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl * 60,
            'user' => auth('api')->user()
        ])->withCookie($cookie);
    }
}
