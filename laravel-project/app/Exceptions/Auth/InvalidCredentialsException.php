<?php

namespace App\Exceptions\Auth;

use App\Exceptions\ApiException;

class InvalidCredentialsException extends ApiException
{
    public function __construct()
    {
        parent::__construct([
            'error' => 'INVALID_CREDENTIALS',
        ], 401);
    }
}
