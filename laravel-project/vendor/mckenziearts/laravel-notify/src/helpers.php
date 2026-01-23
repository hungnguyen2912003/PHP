<?php

declare(strict_types=1);

use Mckenziearts\Notify\Notify;

if (! function_exists('notify')) {
    function notify(): Notify
    {
        /** @var Notify $notify */
        $notify = app('notify');

        return $notify;
    }
}

if (! function_exists('notifyJs')) {
    function notifyJs(): string
    {
        return '<script type="text/javascript" src="'.asset('vendor/mckenziearts/laravel-notify/dist/notify.js').'"></script>';
    }
}

if (! function_exists('notifyCss')) {
    function notifyCss(): string
    {
        return '<link rel="stylesheet" type="text/css" href="'.asset('vendor/mckenziearts/laravel-notify/dist/notify.css').'"/>';
    }
}
