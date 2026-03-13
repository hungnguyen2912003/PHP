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

        $perPage = (int) $request->query('limit', 10);
        $paginator = $query->latest()->paginate($perPage)->withQueryString();

        return ContestResource::collection($paginator);
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
        $perPage = (int) $request->query('limit', 10);

        // Build ranked query: order by steps desc, then duration asc
        $query = UserContest::where('contest_id', $contest->id)
            ->with('user')
            ->orderByDesc('total_steps')
            ->orderBy('duration', 'asc')
            ->orderBy('start_time', 'asc');

        $paginator = $query->paginate($perPage)->withQueryString();

        // Calculate rank offset based on current page
        $rankOffset = ($paginator->currentPage() - 1) * $paginator->perPage();
        $paginator->getCollection()->transform(function ($item, $index) use ($rankOffset) {
            $item->rank = $rankOffset + $index + 1;
            return $item;
        });

        // Get current user's ranking
        $currentUserRanking = null;
        $userContest = UserContest::where('contest_id', $contest->id)
            ->where('user_id', $user->id)
            ->with('user')
            ->first();

        if ($userContest) {
            // Count users ranked above the current user
            $rankAbove = UserContest::where('contest_id', $contest->id)
                ->where(function ($q) use ($userContest) {
                    $q->where('total_steps', '>', $userContest->total_steps)
                      ->orWhere(function ($q2) use ($userContest) {
                          $q2->where('total_steps', $userContest->total_steps)
                             ->where('duration', '<', $userContest->duration);
                      })
                      ->orWhere(function ($q2) use ($userContest) {
                          $q2->where('total_steps', $userContest->total_steps)
                             ->where('duration', $userContest->duration)
                             ->where('start_time', '<', $userContest->start_time);
                      });
                })
                ->count();

            $userContest->rank = $rankAbove + 1;
            $currentUserRanking = new RankingResource($userContest);
        }

        return RankingResource::collection($paginator)
            ->additional(['current_user_ranking' => $currentUserRanking]);
    }
}

