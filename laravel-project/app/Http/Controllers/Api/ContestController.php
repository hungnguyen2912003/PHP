<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\ContestResource;
use App\Http\Resources\Api\RankingResource;
use App\Models\Contest;
use App\Models\UserContest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContestController extends BaseApiController
{
    /**
     * Get a list of contests filtered by tab: current, recommend, history.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $tab = $request->query('tab', '1');

        $query = Contest::withCount(['participants as total_participants']);

        // Return collection of contest IDs the user has joined
        $joined = UserContest::where('user_id', $user->id)->select('contest_id');

        switch ($tab) {
            // Tab 1: Current contests (contests that the user has joined and are still in progress)
            case '1':
                $query->whereIn('id', $joined)
                    ->where('status', Contest::STATUS_INPROGRESS)
                    ->where('end_date', '>=', now());
                break;

            // Tab 2: Recommend contests (contests that the user has not joined and are still in progress)
            case '2':
                $query->whereNotIn('id', $joined)
                    ->where('status', Contest::STATUS_INPROGRESS)
                    ->where('end_date', '>=', now());
                break;

            // Tab 3: History contests (contests that the user has joined and are completed or ended)
            case '3':
                $query->whereIn('id', $joined)
                    ->where(function ($q) {
                        $q->where('status', Contest::STATUS_COMPLETED)
                          ->orWhere('end_date', '<', now());
                    });
                break;

            // Default: Tab 1 (current contests)
            default:
                $query->whereIn('id', $joined)
                    ->where('status', Contest::STATUS_INPROGRESS)
                    ->where('end_date', '>=', now());
                break;
        }

        // Paginate with offset + limit
        // Default offset = 0, limit = 10
        $offset = max((int)$request->query('offset', 0), 0);
        $limit  = max((int)$request->query('limit', 10), 1);

        // Get total count
        $total = $query->count();

        // Get contests with paginations
        $contests = $query->skip($offset)->take($limit)->get();

        return $this->success(200, ContestResource::collection($contests), [
            'total'    => $total,
            'offset'   => $offset,
            'limit'    => $limit,
        ]);
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
                $query->where('status', 1);
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
        $now = now();

        // Check if contest is in progress
        if ($contest->status !== Contest::STATUS_INPROGRESS || $now < $contest->start_date || $now > $contest->end_date) {
            return $this->error(400, __('message.contest_not_active'));
        }
        
        DB::beginTransaction();
        try {
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
                    'start_time' => $now,
                    'end_time' => null,
                    'duration' => 0,
                ]);
            } else {
                // Not joined yet → create new
                UserContest::create([
                    'user_id' => $user->id,
                    'contest_id' => $contest->id,
                    'start_time' => $now,
                    'end_time' => null,
                    'duration' => 0,
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
     * Show steps in time
     */
    public function tracking(Contest $contest)
    {
        $user = auth()->user();

        $userContest = UserContest::where('user_id', $user->id)
            ->where('contest_id', $contest->id)
            ->first();

        // Not joined contest
        if (!$userContest) {
            return $this->error(400, __('message.contest_not_joined'));
        }

        // Not started or already stopped
        if (!$userContest->start_time || 
            ($userContest->end_time && $userContest->end_time >= $userContest->start_time)) {
            return $this->error(400, __('message.contest_not_started'));
        }

        $totalSteps = (int) Cache::get(
            "user_contest_steps:{$user->id}:{$contest->id}",
            $userContest->total_steps ?? 0
        );

        return $this->success(200, [
            'total_steps'    => $totalSteps,
            'remaining_time' => max(0, $contest->end_date->getTimestamp() - now()->getTimestamp()),
        ]);
    }

    /**
     * User action stop contest
     */
    public function stop(Contest $contest)
    {
        $user = auth()->user();
        $now = now();

        // Check if contest is in progress
        if ($contest->status !== Contest::STATUS_INPROGRESS || $now < $contest->start_date || $now > $contest->end_date) {
            return $this->error(400, __('message.contest_not_active'));
        }

        DB::beginTransaction();
        try {
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

            // Check if user completed the contest
            $isCompleted = $userContest->total_steps >= $contest->target;
            $duration = $now->getTimestamp() - $userContest->start_time->getTimestamp();

            $userContest->update([
                'end_time' => $now,
                'duration' => $duration,
                'status' => $isCompleted ? UserContest::STATUS_COMPLETED : UserContest::STATUS_INPROGRESS,
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
    public function ranking(Request $request, Contest $contest)
    {
        $user = auth()->user();

        $offset = max((int)$request->query('offset', 0), 0);
        $limit  = max((int)$request->query('limit', 10), 1);

        $isFinal = $contest->status == 3;

        if ($isFinal) {
            return $this->finalRanking($contest, $user, $offset, $limit);
        }

        return $this->temporaryRanking($contest, $user, $offset, $limit);
    }

    /**
     * Temporary ranking (before finalize)
     */
    private function temporaryRanking(Contest $contest, $user, $offset, $limit)
    {
        // Get current user participation
        $userRanking = UserContest::where('contest_id', $contest->id)
            ->where('user_id', $user->id)
            ->first();

        // Get ranking list: same criteria as admin (getRankedWinners)
        $query = UserContest::where('contest_id', $contest->id)
            ->where('total_steps', '>=', $contest->target)
            ->where('status', UserContest::STATUS_COMPLETED);

        $total = $query->count();

        $ranking = (clone $query)
            ->orderBy('duration', 'asc')
            ->orderBy('start_time', 'asc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Calculate rank for current user if it's null
        if ($userRanking && is_null($userRanking->rank)) {
            $isEligible = $userRanking->total_steps >= $contest->target
                && $userRanking->status === UserContest::STATUS_COMPLETED;

            if ($isEligible) {
                $userRanking->rank = UserContest::where('contest_id', $contest->id)
                    ->where('total_steps', '>=', $contest->target)
                    ->where('status', UserContest::STATUS_COMPLETED)
                    ->where(function ($q) use ($userRanking) {
                        $q->where('duration', '<', $userRanking->duration)
                          ->orWhere(function ($q2) use ($userRanking) {
                              $q2->where('duration', '=', $userRanking->duration)
                                 ->where('start_time', '<', $userRanking->start_time);
                          });
                    })
                    ->count() + 1;
            }
        }

        // Calculate ranks for the ranking list if null
        $ranking->each(function ($item, $key) use ($offset) {
            if (is_null($item->rank)) {
                $item->rank = $offset + $key + 1;
            }
        });

        return $this->success(200, [
            'user_ranking' => RankingResource::make($userRanking),
            'ranking_list' => RankingResource::collection($ranking),
        ], [
            'total'    => $total,
            'offset'   => $offset,
            'limit'    => $limit,
        ]);
    }

    /**
     * Final ranking (after finalize)
     */
    private function finalRanking(Contest $contest, $user, $offset, $limit)
    {
        // Get current user ranking
        $userRanking = UserContest::where('contest_id', $contest->id)
            ->where('user_id', $user->id)
            ->first();

        // Get ranking list with offset + limit
        $query = UserContest::where('contest_id', $contest->id)
            ->where('status', UserContest::STATUS_COMPLETED);

        $total = $query->count();

        $ranking = $query->orderBy('rank', 'asc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        return $this->success(200, [
            'user_ranking' => RankingResource::make($userRanking),
            'ranking_list' => RankingResource::collection($ranking),
        ], [
            'total'    => $total,
            'offset'   => $offset,
            'limit'    => $limit,
        ]);
    }
}

