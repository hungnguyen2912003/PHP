<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

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
