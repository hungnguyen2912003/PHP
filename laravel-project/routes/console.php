<?php

use App\Jobs\FinalizeContestJob;
use App\Models\Contest;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-finalize contests when calculate_at has passed
Schedule::call(function () {
    Contest::where('status', Contest::STATUS_INPROGRESS)
        ->whereNotNull('calculate_at')
        ->where('calculate_at', '<=', now())
        ->each(function ($contest) {
            FinalizeContestJob::dispatch($contest);
        });
})->everyMinute()->name('finalize-contests')->withoutOverlapping();
