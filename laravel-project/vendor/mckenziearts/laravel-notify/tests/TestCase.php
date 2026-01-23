<?php

declare(strict_types=1);

namespace Tests;

use Mckenziearts\Notify\NotifyServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            NotifyServiceProvider::class,
        ];
    }
}
