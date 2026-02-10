<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Resources\Api\UserResource;
use OpenApi\Attributes as OA;


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

    #[OA\Post(
        path: "/api/auth/register",
        summary: "Register a new user",
        tags: ["Auth"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["fullname", "email", "username", "password"],
            properties: [
                new OA\Property(property: "fullname", type: "string", example: "John Doe"),
                new OA\Property(property: "email", type: "string", format: "email", example: "test@example.com"),
                new OA\Property(property: "username", type: "string", example: "test1"),
                new OA\Property(property: "password", type: "string", format: "password", example: "12345678"),
                new OA\Property(property: "role", type: "string", enum: ["user", "admin", "staff"], example: "user")
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "User registered successfully",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: "body",
                            properties: [
                                new OA\Property(property: "message", type: "string", example: "Success"),
                                new OA\Property(
                                    property: "data",
                                    properties: [
                                        new OA\Property(property: "id", type: "string", example: "019c4042-12c0-7014-8b0b-33e181251437"),
                                        new OA\Property(property: "fullname", type: "string", example: "John Doe"),
                                        new OA\Property(property: "username", type: "string", example: "test1"),
                                        new OA\Property(property: "email", type: "string", format: "email", example: "test@example.com"),
                                        new OA\Property(property: "role", type: "string", nullable: true, example: "user"),
                                        new OA\Property(property: "status", type: "string", nullable: true, example: "active"),
                                        new OA\Property(property: "avatar_url", type: "string", nullable: true),
                                        new OA\Property(property: "created_at", type: "string", example: "2026-02-09 09:36:37"),
                                        new OA\Property(property: "updated_at", type: "string", example: "2026-02-09 09:36:37")
                                    ]
                                )
                            ]
                        )
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 422,
        description: "Validation error",
        content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
    )]
    public function register(RegisterRequest $request)
    {
        $user = $request->validated();
        $user['password'] = Hash::make($user['password']);

        $user = User::create($user);

        return $this->success(new UserResource($user), 201);
    }

    #[OA\Post(
        path: "/api/auth/login",
        summary: "Get a JWT via given credentials",
        tags: ["Auth"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["login", "password"],
            properties: [
                new OA\Property(property: "login", type: "string", example: "test1", description: "Email or username"),
                new OA\Property(property: "password", type: "string", format: "password", example: "12345678")
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Login successful",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: "body",
                            properties: [
                                new OA\Property(property: "message", type: "string", example: "Success"),
                                new OA\Property(
                                    property: "data",
                                    properties: [
                                        new OA\Property(property: "access_token", type: "string", example: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
                                        new OA\Property(property: "token_type", type: "string", example: "bearer"),
                                        new OA\Property(property: "expires_in", type: "integer", example: 3600),
                                        new OA\Property(property: "refresh_token", type: "string", example: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...")
                                    ]
                                )
                            ]
                        )
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized",
        content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
    )]
    public function login(LoginRequest $request)
    {
        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $field => $login,
            'password' => $request->input('password'),
        ];
        if (!$token = auth('api')->attempt($credentials)) {
            return $this->error('Unauthorized', 401);
        }
        return $this->success($this->respondWithToken($token), 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    #[OA\Get(
        path: "/api/auth/me",
        summary: "Get the authenticated User",
        tags: ["Auth"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Fetch successful",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: "data",
                            properties: [
                                new OA\Property(property: "id", type: "string", example: "019c4042-12c0-7014-8b0b-33e181251437"),
                                new OA\Property(property: "fullname", type: "string", example: "John Doe"),
                                new OA\Property(property: "username", type: "string", example: "test1"),
                                new OA\Property(property: "email", type: "string", example: "test@example.com"),
                                new OA\Property(property: "role", type: "string", nullable: true, example: "user"),
                                new OA\Property(property: "status", type: "string", nullable: true, example: "active"),
                                new OA\Property(property: "avatar_url", type: "string", nullable: true),
                                new OA\Property(property: "created_at", type: "string", example: "2026-02-09 09:36:37"),
                                new OA\Property(property: "updated_at", type: "string", example: "2026-02-09 09:36:37")
                            ]
                        )
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized",
        content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
    )]
    public function me()
    {
        return $this->success(new UserResource(auth('api')->user()), 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    #[OA\Post(
        path: "/api/auth/logout",
        summary: "Log the user out (Invalidate the token)",
        tags: ["Auth"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Successfully logged out",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: "body",
                            properties: [
                                new OA\Property(property: "message", type: "string", example: "Success"),
                                new OA\Property(property: "data", type: "object", nullable: true, example: null)
                            ]
                        )
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized",
        content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
    )]
    public function logout()
    {
        auth('api')->logout();

        return $this->success(null, 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    #[OA\Post(
        path: "/api/auth/refresh",
        summary: "Refresh a token",
        tags: ["Auth"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Token refreshed successfully",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: "body",
                            properties: [
                                new OA\Property(property: "message", type: "string", example: "Success"),
                                new OA\Property(
                                    property: "data",
                                    properties: [
                                        new OA\Property(property: "access_token", type: "string"),
                                        new OA\Property(property: "token_type", type: "string", example: "bearer"),
                                        new OA\Property(property: "expires_in", type: "integer"),
                                        new OA\Property(property: "refresh_token", type: "string")
                                    ]
                                )
                            ]
                        )
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized",
        content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
    )]
    public function refresh()
    {
        return $this->success($this->respondWithToken(auth('api')->refresh()), 200);
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
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'refresh_token' => $token
        ];
    }
}
