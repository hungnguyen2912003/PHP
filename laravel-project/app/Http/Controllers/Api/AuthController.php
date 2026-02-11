<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\Client\ActivationMail;
use Carbon\Carbon;
use Illuminate\Support\Str;


class AuthController extends BaseApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Notice: Middlewares are better defined in routes/api.php in newer Laravel versions
    }

    public function register(RegisterRequest $request)
    {
        //Create activation token
        $plainToken = Str::random(64);
        $hashedToken = hash('sha256', $plainToken);

        $user = $request->validated();
        $user['role'] = $request->role ?? 'user';
        $user['password'] = Hash::make($user['password']);
        $user['activation_token'] = $hashedToken;
        $user['activation_token_sent_at'] = Carbon::now();

        $user = User::create($user);

        //Send activation email
        Mail::to($user->email)->send(new ActivationMail($plainToken, $user, Carbon::now()->addMinutes(30)));

        return $this->success(new UserResource($user), 201);
    }

    public function login(LoginRequest $request)
    {
        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $field => $login,
            'password' => $request->input('password'),
        ];
        if (!$token = auth('api')->attempt($credentials)) {
            return $this->error('Invalid credentials', 401);
        }
        return $this->success($this->respondWithToken($token), 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth('api')->user();


        return $this->success(new UserResource($user), 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = auth('api')->user();


        auth('api')->logout();

        return $this->success(null, 200, 'Logout successfully');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = auth('api')->refresh();
        $user = auth('api')->setToken($token)->user();


        return $this->success($this->respondWithToken($token), 200);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return array
     */
    protected function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}
