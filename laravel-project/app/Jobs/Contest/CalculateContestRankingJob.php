<?php

namespace App\Jobs\Contest;

use App\Models\Contest;
use App\Models\UserContest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CalculateContestRankingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;

    public function __construct(
        public Contest $contest,
    ) {}

    public function handle(): void
    {
        Log::info("[Contest Ranking] Starting ranking calculation for contest: {$this->contest->id}");

        // Get the number of prize tiers from contest_reward_settings
        $maxPrizeRank = $this->contest->contestRewardSettings()->count();

        // Get all eligible participants (completed & met target), ordered by ranking rules
        $rankedWinners = $this->contest->getRankedWinners()->get();

        $rank = 1;
        foreach ($rankedWinners as $participant) {
            if ($rank <= $maxPrizeRank) {
                // Only assign rank to users within prize tiers
                $participant->update([
                    'rank' => $rank,
                ]);
            } else {
                // Users who met target but didn't win a prize
                $participant->update([
                    'rank'  => null,
                    'score' => 0,
                ]);
            }
            $rank++;
        }

        // Set rank = null for participants who did not meet the criteria
        $this->contest->participants()
            ->where(function ($query) {
                $query->where('total_steps', '<', $this->contest->target)
                    ->orWhere('status', '!=', UserContest::STATUS_COMPLETED);
            })
            ->update([
                'rank'  => null,
                'score' => 0,
            ]);

        Log::info("[Contest Ranking] Ranked {$rankedWinners->count()} participants for contest: {$this->contest->id}");

        // Chain: dispatch reward distribution
        DistributeContestRewardsJob::dispatch($this->contest);
    }
}
