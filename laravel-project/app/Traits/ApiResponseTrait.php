<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Send a success response.
     *
     * @param  mixed  $data
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'body' => $data,
        ], $statusCode);
    }

    /**
     * Send an error response.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'body' => [
                'message' => $message,
            ],
        ], $statusCode);
    }
}
