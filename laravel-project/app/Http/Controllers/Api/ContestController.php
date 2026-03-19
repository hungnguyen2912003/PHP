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

        $query = Contest::query();

        // Get contest that user has joined
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

            // Tab 3: History contests (contests that the user has joined and are finalized)
            case '3':
                $query->whereIn('id', $joined)
                    ->where('status', Contest::STATUS_FINALIZED);
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

        // Get total participants count
        foreach ($contests as $contest) {
            $contest->total_participants = UserContest::where('contest_id', $contest->id)->count();
        }

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

        // 1. Count total participants
        $contest->total_participants = UserContest::where('contest_id', $contest->id)->count();

        // 2. Count completed participants
        $contest->total_completed_participants = UserContest::where('contest_id', $contest->id)
            ->where('status', UserContest::STATUS_COMPLETED)
            ->count();

        // 3. Get user's participation detail
        $contest->user_progress = UserContest::where('contest_id', $contest->id)
            ->where('user_id', $user->id)
            ->first();

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

        // Check if user is already participating in another contest with the same type
        $hasConflict = UserContest::where('user_id', $user->id)
            ->where('contest_id', '!=', $contest->id)
            ->whereHas('contest', function ($q) use ($contest) {
                $q->where('type', $contest->type)
                  ->where('end_date', '>=', now());
            })
            ->exists();

        if ($hasConflict) {
            return $this->error(400, __('message.contest_type_conflict'));
        }

        DB::beginTransaction();
        try {
            $userContest = UserContest::where('user_id', $user->id)
                ->where('contest_id', $contest->id)
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
            'end_date' => $contest->end_date->timestamp,
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

        $isFinal = $contest->status == Contest::STATUS_FINALIZED;

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

        // completed users first, then by duration, start_time
        $ranking = UserContest::where('contest_id', $contest->id)
            ->orderByRaw('CASE WHEN total_steps >= ? AND status = ? THEN 0 ELSE 1 END ASC', [
                $contest->target,
                UserContest::STATUS_COMPLETED,
            ])
            ->orderBy('duration', 'asc')
            ->orderBy('start_time', 'asc')
            ->orderBy('id', 'asc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Calculate rank for current user
        if ($userRanking) {
            $userRanking->rank = $this->calculateUserRank($contest, $userRanking);
        }

        // Assign rank based on position in the sorted list
        $ranking->each(function ($item, $key) use ($offset) {
            if (is_null($item->rank)) {
                $item->rank = $offset + $key + 1;
            }
        });

        $total = UserContest::where('contest_id', $contest->id)->count();

        return $this->success(200, [
            'user_ranking' => $userRanking ? RankingResource::make($userRanking) : null,
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

        // Calculate rank for current user if rank is null (didn't win a prize)
        if ($userRanking) {
            $userRanking->rank = $this->calculateUserRank($contest, $userRanking);
        }

        // Get ranking list - only prize winners
        $total = UserContest::where('contest_id', $contest->id)
            ->whereNotNull('rank')
            ->count();

        $ranking = UserContest::where('contest_id', $contest->id)
            ->whereNotNull('rank')
            ->orderBy('rank', 'asc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        return $this->success(200, [
            'user_ranking' => $userRanking ? RankingResource::make($userRanking) : null,
            'ranking_list' => RankingResource::collection($ranking),
        ], [
            'total'    => $total,
            'offset'   => $offset,
            'limit'    => $limit,
        ]);
    }
    /**
     * Calculate current relative rank of a user
     */
    private function calculateUserRank(Contest $contest, UserContest $userRanking)
    {
        if (!is_null($userRanking->rank)) {
            return $userRanking->rank;
        }

        $isCompleted = $userRanking->total_steps >= $contest->target
            && $userRanking->status === UserContest::STATUS_COMPLETED;

        return UserContest::where('contest_id', $contest->id)
            ->where(function ($q) use ($contest, $userRanking, $isCompleted) {
                if ($isCompleted) {
                    // Only count completed users
                    $q->where('total_steps', '>=', $contest->target)
                      ->where('status', UserContest::STATUS_COMPLETED)
                      ->where(function ($q2) use ($userRanking) {
                          $q2->where('duration', '<', $userRanking->duration)
                             ->orWhere(function ($q3) use ($userRanking) {
                                 $q3->where('duration', $userRanking->duration)
                                    ->where('start_time', '<', $userRanking->start_time);
                             });
                      });
                } else {
                    // All completed users + non-completed users
                    $q->where(function ($sub) use ($contest) {
                        $sub->where('total_steps', '>=', $contest->target)
                            ->where('status', UserContest::STATUS_COMPLETED);
                    })->orWhere(function ($sub) use ($contest, $userRanking) {
                        $sub->where(function ($s) use ($contest) {
                            $s->where('total_steps', '<', $contest->target)
                              ->orWhere('status', '!=', UserContest::STATUS_COMPLETED);
                        })->where(function ($s) use ($userRanking) {
                            $s->where('duration', '<', $userRanking->duration)
                              ->orWhere(function ($s2) use ($userRanking) {
                                  $s2->where('duration', $userRanking->duration)
                                     ->where('start_time', '<', $userRanking->start_time);
                              });
                        });
                    });
                }
            })
            ->count() + 1;
    }
}

