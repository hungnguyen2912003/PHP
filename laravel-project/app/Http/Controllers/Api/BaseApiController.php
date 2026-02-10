<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Healthify API",
    version: "1.0.0",
    description: "API documentation for the Healthify project"
)]
#[OA\Server(
    url: "http://localhost:8080",
    description: "Local Server"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    name: "Authorization",
    in: "header",
    bearerFormat: "JWT",
    scheme: "bearer",
)]
#[OA\Schema(
    schema: "ApiResponse",
    title: "Standard API Response",
    description: "Standard wrapper for successful API responses",
    properties: [
        new OA\Property(property: "status", type: "integer", example: 200),
        new OA\Property(
            property: "body",
            properties: [
                new OA\Property(property: "data", type: "object", nullable: true)
            ]
        )
    ]
)]
#[OA\Schema(
    schema: "ErrorResponse",
    title: "Standard Error Response",
    description: "Standard wrapper for error responses",
    properties: [
        new OA\Property(property: "status", type: "integer", example: 400),
        new OA\Property(
            property: "body",
            properties: [
                new OA\Property(property: "errors", type: "object", nullable: true)
            ]
        )
    ]
)]
#[OA\Schema(
    schema: "Measurement",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid"),
        new OA\Property(property: "user_id", type: "string", format: "uuid"),
        new OA\Property(property: "weight", type: "number", format: "float"),
        new OA\Property(property: "height", type: "number", format: "float"),
        new OA\Property(property: "recorded_at", type: "string", format: "date-time"),
        new OA\Property(property: "attachment_url", type: "string", nullable: true),
    ]
)]
class BaseApiController extends Controller
{
    use AuthorizesRequests;

    protected function success(mixed $data = null, int $status = 200, string $message = 'Success'): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'body' => [
                'data' => $data,
            ],
        ], $status);
    }

    protected function error(string $message = 'Error', int $status = 400, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'body' => [
                'errors' => $errors,
            ],
        ], $status);
    }
}
