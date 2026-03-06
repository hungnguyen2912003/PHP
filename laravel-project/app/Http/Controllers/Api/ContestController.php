<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\ContestResource;
use App\Models\Contest;
use App\Models\UserContest;
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
            case 'current':
                $query->whereIn('id', $joined)
                    ->where('status', Contest::STATUS_INPROGRESS)
                    ->where('end_date', '>=', now());
                break;

            case 'recommend':
                $query->whereNotIn('id', $joined)
                    ->where('status', Contest::STATUS_INPROGRESS)
                    ->where('end_date', '>=', now());
                break;

            case 'history':
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

        return $this->success(ContestResource::collection($contests));
    }

    /**
     * Get contest detail with user's participation data.
     */
    public function show(Request $request, Contest $contest)
    {
        $user = auth()->user();

        if($request->input('join') == 1) {
            DB::beginTransaction();
            try {
                // Check if user has already joined the contest
                $userContest = UserContest::where('user_id', $user->id)
                    ->where('contest_id', $contest->id)
                    ->first();
                
                if ($userContest) {
                    return $this->error(__('message.contest_already_joined'), 400);
                }

                // Check if contest is in progress
                if ($contest->status !== Contest::STATUS_INPROGRESS || now() < $contest->start_date || now() > $contest->end_date) {
                    return $this->error(__('message.contest_not_active'), 400);
                }
                
                $userContest = UserContest::create([
                    'user_id' => $user->id,
                    'contest_id' => $contest->id,
                    'joined_at' => now(),
                    'latest_start_time' => now(),
                    'total_steps' => 0,
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 500);
            }
        }

        $contest->loadCount(['participants as total_participants']);

        // Load user's participation detail
        $contest->setRelation('user_contest',
            UserContest::where('contest_id', $contest->id)
                ->where('user_id', $user->id)
                ->first()
        );

        return $this->success(new ContestResource($contest));
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

        return $this->success([
            'my_rank' => $myRank,
            'rankings' => $rankings,
        ]);
    }
}
