<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\ContestResource;
use App\Models\Contest;
use App\Models\UserContest;
use App\Models\UserStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContestController extends BaseApiController
{
    /**
     * Get a list of contests filtered by tab: current, recommend, history.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $tab = $request->query('tab', 'current');

        $query = Contest::withCount(['participants as total_participants']);

        // Return collection of contest IDs the user has joined
        $joined = UserContest::where('user_id', $user->id)->select('contest_id');

        switch ($tab) {
            case '1':
                $query->whereIn('id', $joined)
                    ->where('status', Contest::STATUS_INPROGRESS)
                    ->where('end_date', '>=', now());
                break;

            case '2':
                $query->whereNotIn('id', $joined)
                    ->where('status', Contest::STATUS_INPROGRESS)
                    ->where('end_date', '>=', now());
                break;

            case '3':
                $query->whereIn('id', $joined)
                    ->where(function ($q) {
                        $q->where('status', Contest::STATUS_COMPLETED)
                          ->orWhere('end_date', '<', now());
                    });
                break;

            default:
                $query->where('status', Contest::STATUS_INPROGRESS)
                    ->where('end_date', '>=', now());
                break;
        }

        $contests = $query->orderByDesc('created_at')->get();

        return $this->success(200, ContestResource::collection($contests));
    }

    /**
     * Get contest detail with user's participation data.
     */
    public function show(Contest $contest)
    {
        $user = auth()->user();

        $contest->loadCount([
            'participants as total_participants',
            'participants as total_completed' => function ($query) {
                $query->whereNotNull('completed_at');
            }
        ]);
        

        // Load user's participation detail
        $contest->setRelation('user_contest',
            UserContest::where('contest_id', $contest->id)
                ->where('user_id', $user->id)
                ->first()
        );

        return $this->success(200, new ContestResource($contest));
    }

    /**
     * User action start contest
     */
    public function start(Request $request, Contest $contest)
    {
        $user = auth()->user();

        // Check if contest is in progress
        if ($contest->status !== Contest::STATUS_INPROGRESS || now() < $contest->start_date || now() > $contest->end_date) {
            return $this->error(400, __('message.contest_not_active'));
        }

        try {
            DB::beginTransaction();
            
            $userContest = UserContest::where('user_id', $user->id)
                ->where('contest_id', $contest->id)
                ->lockForUpdate()
                ->first();

            if ($userContest) {
                // Already started and not stopped → not allow to start again
                if ($userContest->start_time && 
                    (!$userContest->end_time || $userContest->start_time > $userContest->end_time)) {
                    DB::rollBack();
                    return $this->error(400, __('message.contest_already_started'));
                }

                // Already stopped → allow to start again, update start_time
                $userContest->update([
                    'start_time' => now(),
                ]);
            } else {
                // Not joined yet → create new
                $userContest = UserContest::create([
                    'user_id' => $user->id,
                    'contest_id' => $contest->id,
                    'total_steps' => 0,
                    'start_time' => now(),
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error(500, $e->getMessage());
        }

        return $this->success(200);
    }

    /**
     * User action stop contest
     */
    public function stop(Contest $contest)
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();
            
            $userContest = UserContest::where('user_id', $user->id)
                ->where('contest_id', $contest->id)
                ->lockForUpdate()
                ->first();
            
            // Not joined contest
            if (!$userContest) {
                DB::rollBack();
                return $this->error(400, __('message.contest_not_joined'));
            }

            // Not started or already stopped → not allow to stop again
            if (!$userContest->start_time || 
                ($userContest->end_time && $userContest->end_time >= $userContest->start_time)) {
                DB::rollBack();
                return $this->error(400, __('message.contest_not_started'));
            }

            $endTime = now();

            // Sum steps from user_steps table in the period start_time → end_time
            $stepsInPeriod = UserStep::where('user_id', $user->id)
                ->where('recorded_at', '>=', $userContest->start_time)
                ->where('recorded_at', '<=', $endTime)
                ->sum('steps');

            $userContest->update([
                'end_time' => $endTime,
                'total_steps' => $userContest->total_steps + $stepsInPeriod,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error(500, $e->getMessage());
        }

        return $this->success(200);
    }

    /**
     * Get ranking list for a contest.
     */
    public function ranking(Contest $contest)
    {
        $user = auth()->user();

        $participants = UserContest::with('user')
            ->where('contest_id', $contest->id)
            ->orderByDesc('total_steps')
            ->get();

        // Build ranking list
        $rankings = $participants->values()->map(function ($userContest, $index) {
            $rank = $index + 1;

            return [
                'rank' => $rank,
                'user_id' => $userContest->user_id,
                'fullname' => $userContest->user->fullname ?? $userContest->user->username ?? 'User',
                'avatar_url' => $userContest->user->avatar_url,
                'total_steps' => $userContest->total_steps ?? 0,
                'joined_at' => $userContest->joined_at?->timestamp,
            ];
        });

        // Find current user's rank
        $myRank = $rankings->firstWhere('user_id', $user->id);

        return $this->success(200, [
            'my_rank' => $myRank,
            'rankings' => $rankings,
        ]);
    }
}
