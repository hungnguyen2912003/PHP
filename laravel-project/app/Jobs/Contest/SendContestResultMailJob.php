<?php

namespace App\Jobs\Contest;

use App\Mail\Client\ContestResultMail;
use App\Models\Contest;
use App\Models\UserContest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContestResultMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 120;

    public function __construct(
        public UserContest $userContest,
    ) {}

    public function handle(): void
    {
        $userContest = $this->userContest->load(['user', 'contest']);
        $user = $userContest->user;
        $contest = $userContest->contest;

        if (!$user || !$user->email) {
            Log::warning("[Contest Mail] Skipping mail for user_contest {$userContest->id}: no user or email");
            return;
        }

        $duration = Contest::formatDuration($userContest->start_time, $userContest->end_time);

        Mail::to($user->email)->send(new ContestResultMail(
            user: $user,
            contest: $contest,
            rank: $userContest->rank ?? 0,
            reward: $userContest->score ?? 0,
            duration: $duration,
            startAt: $userContest->start_time,
            endAt: $userContest->end_time,
            totalSteps: $userContest->total_steps,
        ));

        Log::info("[Contest Mail] Sent contest result email to {$user->email} for contest: {$contest->id}");
    }
}
