<?php

namespace App\Jobs;

use App\Mail\Client\ContestResultMail;
use App\Models\Contest;
use App\Models\ContestDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FinalizeContestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Contest $contest)
    {
    }

    public function handle(): void
    {
        if ($this->contest->status === Contest::STATUS_COMPLETED) {
            return;
        }

        // 1. Finalize the contest
        $this->contest->update(['status' => Contest::STATUS_COMPLETED]);

        // 2. Get ranked participants (same logic as ContestController::rankingData final)
        $rankedDetails = ContestDetail::with('user')
            ->where('contest_id', $this->contest->id)
            ->where('total_steps', '>=', $this->contest->target)
            ->orderByRaw('TIMESTAMPDIFF(SECOND, start_at, end_at) ASC')
            ->orderBy('start_at', 'asc')
            ->limit($this->contest->win_limit)
            ->get();

        // 3. Calculate reward and send email to each ranked user
        foreach ($rankedDetails as $index => $detail) {
            $rank = $index + 1;
            $reward = $this->calculateReward($rank, $this->contest->reward_points);

            $duration = '-';
            if ($detail->start_at && $detail->end_at) {
                $seconds = abs($detail->start_at->diffInSeconds($detail->end_at));
                $h = intdiv($seconds, 3600);
                $m = intdiv($seconds % 3600, 60);
                $s = $seconds % 60;
                $duration = sprintf('%02d:%02d:%02d', $h, $m, $s);
            }

            if ($detail->user && $detail->user->email) {
                try {
                    Mail::to($detail->user->email)->send(new ContestResultMail(
                        user: $detail->user,
                        contest: $this->contest,
                        rank: $rank,
                        reward: $reward,
                        duration: $duration,
                        startAt: $detail->start_at,
                        endAt: $detail->end_at,
                        totalSteps: $detail->total_steps,
                    ));
                } catch (\Exception $e) {
                    Log::error("Failed to send contest result email to [{$detail->user->email}]: {$e->getMessage()}");
                }
            }
        }

        Log::info("Contest [{$this->contest->id}] has been finalized. Emails sent to {$rankedDetails->count()} participants.");
    }

    private function calculateReward(int $rank, int $rewardPoints): int
    {
        return match (true) {
            $rank === 1 => $rewardPoints,
            $rank === 2 => (int) round($rewardPoints * 0.8),
            $rank === 3 => (int) round($rewardPoints * 0.7),
            default => (int) round($rewardPoints * 0.6),
        };
    }
}
