<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Laravel API Documentation',
    description: 'API Documentation for Laravel API',
    contact: new OA\Contact(
        email: 'admin@example.com'
    ),
    license: new OA\License(
        name: 'Apache 2.0',
        url: 'http://www.apache.org/licenses/LICENSE-2.0.html'
    )
)]
abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;
}
