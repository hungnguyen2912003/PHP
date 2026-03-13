<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Return a success JSON response.
     *
     * @param int $status
     * @param mixed $data
     * @return JsonResponse
     */
    protected function success(int $status = 200, mixed $data = null, mixed $meta = null): JsonResponse
    {
        $response = [
            'status' => $status,
            'success' => true,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        if ($meta !== null) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $status);
    }

    /**
     * Return an error JSON response.
     *
     * @param int $status
     * @param mixed $errors
     * @return JsonResponse
     */
    protected function error(int $status = 400, mixed $errors = null): JsonResponse
    {
        $response = [
            'status' => $status,
            'success' => false,
        ];

        if ($errors !== null) {
            if (is_string($errors)) {
                $response['errors'] = [
                    'message' => [
                        $errors
                    ]
                ];
            } else {
                $response['errors'] = $errors;
            }
        }

        return response()->json($response, $status);
    }
}
