<?php

namespace App\Console\Commands;

use App\Models\Contest;
use Illuminate\Console\Command;

class CompleteExpiredContestsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'contest:complete';

    /**
     * The console command description.
     */
    protected $description = 'Mark in-progress contests as completed when their end_date has passed';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $contests = Contest::where('status', Contest::STATUS_INPROGRESS)
            ->where('end_date', '<=', now())
            ->get();

        if ($contests->isEmpty()) {
            $this->info('No expired contests to complete.');
            return self::SUCCESS;
        }

        $this->info("Found {$contests->count()} expired contest(s) to mark as completed.");

        foreach ($contests as $contest) {
            $contest->update(['status' => Contest::STATUS_COMPLETED]);
            $this->info("Contest {$contest->id} marked as completed.");
        }

        $this->info('All expired contests have been marked as completed.');

        return self::SUCCESS;
    }
}
