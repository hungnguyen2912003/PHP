<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Contest\ImportStepsRequest;
use App\Http\Resources\Api\ContestDetailResource;
use App\Http\Resources\Api\ContestResource;
use App\Models\Contest;
use App\Models\ContestDetail;
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

        $query = Contest::withCount(['details as total_participants']);

        // Return collection of contest IDs the user has joined
        $joined = ContestDetail::where('user_id', $user->id)->select('contest_id');

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
                $detail = ContestDetail::where('user_id', $user->id)
                    ->where('contest_id', $contest->id)
                    ->first();
                
                if ($detail) {
                    return $this->error(__('message.contest_already_joined'), 400);
                }

                // Check if contest is in progress
                if ($contest->status !== Contest::STATUS_INPROGRESS || now() < $contest->start_date || now() > $contest->end_date) {
                    return $this->error(__('message.contest_not_active'), 400);
                }
                
                $detail = ContestDetail::create([
                    'user_id' => $user->id,
                    'contest_id' => $contest->id,
                    'joined_at' => now(),
                    'status' => ContestDetail::STATUS_INPROGRESS,
                ]);

                ContestSession::create([
                    'contest_detail_id' => $detail->id,
                    'start_time' => now(),
                    'total_steps' => 0,
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 500);
            }
        }

        $contest->loadCount(['details as total_participants']);

        // Load user's participation detail
        $contest->setRelation('user_detail',
            ContestDetail::where('contest_id', $contest->id)
                ->where('user_id', $user->id)
                ->first()
        );

        return $this->success(new ContestDetailResource($contest));
    }

    /**
     * Get ranking list for a contest.
     */
    public function ranking(Contest $contest)
    {
        $user = auth()->user();

        $participants = ContestDetail::with('user')
            ->where('contest_id', $contest->id)
            ->orderByDesc('final_steps')
            ->get();

        // Build ranking list
        $rankings = $participants->values()->map(function ($detail, $index) {
            $rank = $index + 1;

            return [
                'rank' => $rank,
                'user_id' => $detail->user_id,
                'fullname' => $detail->user->fullname ?? $detail->user->username ?? 'User',
                'avatar_url' => $detail->user->avatar_url,
                'final_steps' => $detail->final_steps ?? 0,
                'joined_at' => $detail->joined_at?->timestamp,
            ];
        });

        // Find current user's rank
        $myRank = $rankings->firstWhere('user_id', $user->id);

        return $this->success([
            'my_rank' => $myRank,
            'rankings' => $rankings,
        ]);
    }

    /**
     * Import steps for the authenticated user and update a specific contest.
     */
    public function importSteps(ImportStepsRequest $request, Contest $contest)
    {
        $user = auth()->user();

        $totalSteps = $request->input('total_steps');
        $startTime = $request->input('start_time');
        $stopTime = $request->input('stop_time');

        // Allow updates only if the contest is currently in progress
        if ($contest->status !== Contest::STATUS_INPROGRESS || now() < $contest->start_date || now() > $contest->end_date) {
            return $this->error(__('message.contest_not_active'), 400, __('message.contest_not_active'));
        }

        // Validate that imported times are within the contest's allowed date range
        if ($contest->start_date->greaterThan($startTime) || $contest->end_date->lessThan($stopTime)) {
            return $this->error(__('message.invalid_import_dates'), 400, __('message.invalid_import_dates'));
        }

        // Find or create the contest detail record (auto-join)
        $detail = ContestDetail::firstOrCreate([
            'user_id' => $user->id,
            'contest_id' => $contest->id,
        ], [
            'joined_at' => now(),
        ]);

        // Prevent update if already completed or cancelled
        if ($detail->status === ContestDetail::STATUS_COMPLETED || $detail->status === ContestDetail::STATUS_CANCELLED) {
            return $this->error(__('message.contest_detail_not_updatable'), 400, __('message.contest_detail_not_updatable'));
        }

        DB::beginTransaction();
        try {
            // Create a contest session record
            $detail->sessions()->create([
                'start_time' => $startTime,
                'stop_time' => $stopTime,
                'total_steps' => $totalSteps,
            ]);

            // Update final_steps on contest detail
            $detail->final_steps = $detail->sessions()->sum('total_steps');

            // Check if target reached
            if ($detail->final_steps >= $contest->target) {
                $detail->status = ContestDetail::STATUS_COMPLETED;
            }

            $detail->save();

            DB::commit();

            return response()->json([
                'status' => 201,
                'success' => true,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 500);
        }
    }
}
