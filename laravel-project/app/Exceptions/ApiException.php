<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected int $status;
    protected array $data;

    public function __construct(array $data = [], int $status = 400)
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
}
