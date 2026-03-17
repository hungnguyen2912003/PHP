<?php

namespace App\Console\Commands;

use App\Jobs\Contest\CalculateContestRankingJob;
use App\Models\Contest;
use Illuminate\Console\Command;

class FinalizeCompletedContestsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'contest:finalize';

    /**
     * The console command description.
     */
    protected $description = 'Finalize completed contests: calculate rankings, distribute rewards, and send result emails';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $contests = Contest::where('status', Contest::STATUS_COMPLETED)
            ->where('calculate_at', '<=', now())
            ->get();

        if ($contests->isEmpty()) {
            $this->info('No contests to finalize.');
            return self::SUCCESS;
        }

        $this->info("Found {$contests->count()} contest(s) to finalize.");

        foreach ($contests as $contest) {
            // Mark as finalized immediately to prevent duplicate processing
            $contest->update(['status' => Contest::STATUS_FINALIZED]);

            // Dispatch ranking calculation job
            CalculateContestRankingJob::dispatch($contest);

            $this->info("Dispatched finalization job for contest: {$contest->id}");
        }

        $this->info('All contest finalization jobs dispatched successfully.');

        return self::SUCCESS;
    }
}
