<?php

namespace App\Services;

use Carbon\Carbon;

class TimestampService
{
    /**
     * Convert Unix timestamp to Carbon datetime.
     *
     * @param int|float $timestamp
     * @return Carbon
     */
    public static function toDatetime(int|float $timestamp): Carbon
    {
        return Carbon::createFromTimestamp($timestamp);
    }
}
