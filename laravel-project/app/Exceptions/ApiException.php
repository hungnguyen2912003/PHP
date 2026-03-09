<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected int $status;
    protected array $data;

    public function __construct(int $status = 400, array $data = [])
    {
        parent::__construct();
        $this->status = $status;
        $this->data = $data;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function render($request)
    {
        if ($request->is('api/*')) {
            $response = [
                'status' => $this->status,
                'success' => false,
            ];

            if (!empty($this->data)) {
                $response['errors'] = $this->data;
            }

            return response()->json($response, $this->status);
        }
        return false;
    }
}
