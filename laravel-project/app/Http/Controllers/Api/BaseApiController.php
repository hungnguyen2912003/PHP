<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\ApiResponse;

class BaseApiController extends Controller
{
    use AuthorizesRequests, ApiResponse;
}
