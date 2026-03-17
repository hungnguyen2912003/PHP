<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Contest Lifecycle
|--------------------------------------------------------------------------
| 1. contest:complete — Mark expired contests as completed (INPROGRESS → COMPLETED)
| 2. contest:finalize — Finalize completed contests: rankings, rewards, emails (COMPLETED → FINALIZED)
|
*/
Schedule::command('contest:complete')->everyMinute();
Schedule::command('contest:finalize')->everyMinute();
