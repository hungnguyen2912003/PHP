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
        summary: "Đăng ký tài khoản",
        description: "Đăng ký tài khoản người dùng.",
        operationId: "registerUser",
        tags: ["Auth"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: "#/components/schemas/RegisterRequest")
    )]
    #[OA\Response(
        response: 201,
        description: "User registered successfully",
        content: new OA\JsonContent(
            example: [
                "status" => 201,
                "body" => [
                    "data" => [
                        "id" => "019c4042-12c0-7014-8b0b-33e181251437",
                        "fullname" => "John Doe",
                        "username" => "test1",
                        "email" => "test@example.com",
                        "role" => "user",
                        "status" => "active",
                        "avatar_url" => null,
                        "created_at" => "2026-02-09 09:36:37",
                        "updated_at" => "2026-02-09 09:36:37"
                    ]
                ]
            ]
        )
    )]
    #[OA\Response(
        response: 422,
        description: "Validate exception",
        content: new OA\JsonContent(
            example: [
                "status" => 422,
                "body" => [
                    "errors" => [
                        "fullname" => ["The fullname field is required."],
                        "email" => ["The email field is required"],
                        "username" => ["The username has already been taken."]
                    ]
                ]
            ]
        )
    )]
    #[OA\Response(
        response: "default",
        description: "Server error",
        content: new OA\JsonContent(
            example: [
                "status" => 500,
                "body" => [
                    "errors" => []
                ]
            ]
        )
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
        summary: "Đăng nhập",
        description: "Đăng nhập tài khoản người dùng.",
        operationId: "loginUser",
        tags: ["Auth"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: "#/components/schemas/LoginRequest",
            example: [
                "login" => "test1",
                "password" => "12345678"
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Login successfully",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    example: [
                        "status" => 200,
                        "body" => [
                            "data" => [
                                "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
                                "token_type" => "bearer",
                                "expires_in" => 3600
                            ]
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 422,
        description: "Validation Error (missing or invalid fields)",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 422,
                        "body" => [
                            "errors" => [
                                "login" => ["The login field is required."],
                                "password" => ["The password field is required."]
                            ]
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Invalid credentials (wrong username or password)",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 401,
                        "body" => [
                            "errors" => []
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: "default",
        description: "Server error",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 500,
                        "body" => [
                            "errors" => []
                        ]
                    ]
                )
            ]
        )
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
            return $this->error('Invalid credentials', 401);
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
        summary: "Lấy thông tin tài khoản hiện tại",
        description: "Lấy thông tin cá nhân người dùng đang đăng nhập.",
        operationId: "profileUser",
        tags: ["Auth"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Fetch successfully",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    example: [
                        "status" => 200,
                        "body" => [
                            "data" => [
                                "id" => "019c4042-12c0-7014-8b0b-33e181251437",
                                "fullname" => "John Doe",
                                "username" => "test1",
                                "email" => "test@example.com",
                                "role" => "user",
                                "status" => "active",
                                "avatar_url" => null,
                                "created_at" => "2026-02-09 09:36:37",
                                "updated_at" => "2026-02-09 09:36:37"
                            ]
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized (missing/invalid/expired token)",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 401,
                        "body" => [
                            "errors" => []
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: "default",
        description: "Server error",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 500,
                        "body" => [
                            "errors" => []
                        ]
                    ]
                )
            ]
        )
    )]
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
    #[OA\Post(
        path: "/api/auth/logout",
        summary: "Đăng xuất",
        description: "Đăng xuất tài khoản người dùng",
        operationId: "logoutUser",
        tags: ["Auth"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Logout successfully",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    example: [
                        "status" => 200,
                        "body" => [
                            "data" => null
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized (missing/invalid/expired token)",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 401,
                        "body" => [
                            "errors" => []
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: "default",
        description: "Server error",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 500,
                        "body" => [
                            "errors" => []
                        ]
                    ]
                )
            ]
        )
    )]
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
    #[OA\Post(
        path: "/api/auth/refresh",
        summary: "Làm mới token cho người dùng trong session",
        description: "Tạo access token mới từ token hiện tại.",
        operationId: "refreshToken",
        tags: ["Auth"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Refresh token successfully",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ApiResponse"),
                new OA\Schema(
                    example: [
                        "status" => 200,
                        "body" => [
                            "data" => [
                                "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
                                "token_type" => "bearer",
                                "expires_in" => 3600
                            ]
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized (missing/invalid/expired token)",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 401,
                        "body" => [
                            "errors" => []
                        ]
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: "default",
        description: "Server error",
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(ref: "#/components/schemas/ErrorResponse"),
                new OA\Schema(
                    example: [
                        "status" => 500,
                        "body" => [
                            "errors" => []
                        ]
                    ]
                )
            ]
        )
    )]
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
