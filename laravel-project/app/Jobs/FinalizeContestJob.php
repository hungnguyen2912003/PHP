<?php

namespace App\Jobs;

use App\Mail\Client\ContestResultMail;
use App\Models\Contest;
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
        if ($this->contest->status === Contest::STATUS_FINALIZED) {
            return;
        }

        // 1. Finalize the contest
        $this->contest->update(['status' => Contest::STATUS_FINALIZED]);

        // 2. Get ranked participants
        $rankedDetails = $this->contest->getRankedWinners()->get();

        // 3. Calculate reward and send email to each ranked user
        foreach ($rankedDetails as $index => $detail) {
            $rank = $index + 1;
            $reward = $this->contest->calculateReward($rank);
            $duration = Contest::formatDuration($detail->start_at, $detail->end_at);

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

}
