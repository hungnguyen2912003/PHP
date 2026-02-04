<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    protected function success($data = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'status_code' => $status,
            'data' => $data,
        ], $status);
    }

    protected function error($data = null, int $status = 400): JsonResponse
    {
        return response()->json([
            'status_code' => $status,
            'data' => $data,
        ], $status);
    }
}
