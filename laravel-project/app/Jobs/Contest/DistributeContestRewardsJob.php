<?php

namespace App\Jobs\Contest;

use App\Models\Contest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DistributeContestRewardsJob implements ShouldQueue
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
        Log::info("[Contest Rewards] Starting reward distribution for contest: {$this->contest->id}");

        // Load reward settings keyed by rank
        $rewardSettings = $this->contest->contestRewardSettings()
            ->pluck('reward_percent', 'rank');

        // Get all ranked participants
        $rankedParticipants = $this->contest->participants()
            ->whereNotNull('rank')
            ->orderBy('rank', 'asc')
            ->get();

        foreach ($rankedParticipants as $participant) {
            $rewardPercent = $rewardSettings[$participant->rank] ?? null;
            
            if ($rewardPercent !== null) {
                $score = (int) round($this->contest->reward_points * ($rewardPercent / 100));
            } else {
                // Consolation prize for those who reached the target but didn't place in top ranks
                $score = (int) $this->contest->consolation_points;
            }

            $participant->update([
                'score'         => $score,
                'is_calculated' => true,
            ]);
        }

        // Mark non-ranked participants as calculated with score = 0
        $this->contest->participants()
            ->whereNull('rank')
            ->update([
                'score'         => 0,
                'is_calculated' => true,
            ]);

        Log::info("[Contest Rewards] Distributed rewards to {$rankedParticipants->count()} participants for contest: {$this->contest->id}");

        // Chain: dispatch email notification for each participant
        $allParticipants = $this->contest->participants()
            ->with('user')
            ->get();

        foreach ($allParticipants as $participant) {
            SendContestResultMailJob::dispatch($participant);
        }
    }
}
