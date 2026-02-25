<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Contest\ImportStepsRequest;
use App\Models\Contest;
use App\Models\ContestDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContestController extends BaseApiController
{
    /**
     * Get a list of active and upcoming contests.
     */
    public function index(Request $request)
    {
        $contests = Contest::all();

        return $this->success($contests);
    }

    /**
     * Import steps for the authenticated user and update a specific contest.
     */
    public function importSteps(ImportStepsRequest $request, Contest $contest)
    {
        $user = auth()->user();
        
        $totalSteps = $request->input('total_steps');
        $deviceType = $request->input('device_type', 1);
        $startAt = $request->input('start_at');
        $endAt = $request->input('end_at');

        // Allow updates only if the contest is currently in progress
        if ($contest->status !== Contest::STATUS_INPROGRESS || now() < $contest->start_date || now() > $contest->end_date) {
             return $this->error(__('message.contest_not_active'), 400, __('message.contest_not_active'));
        }

        // Validate that imported start_at and end_at are within the contest's allowed date range
        $importStart = \Carbon\Carbon::parse($startAt);
        $importEnd = \Carbon\Carbon::parse($endAt);

        if ($importStart < $contest->start_date || $importEnd > $contest->end_date) {
             return $this->error(__('message.invalid_import_dates'), 400, __('message.invalid_import_dates'));
        }

        // Find or create the contest detail record (auto-join)
        $detail = ContestDetail::firstOrCreate([
            'user_id' => $user->id,
            'contest_id' => $contest->id,
        ]);
        
        // Prevent update if already completed or cancelled
        if ($detail->status === ContestDetail::STATUS_COMPLETED || $detail->status === ContestDetail::STATUS_CANCELLED) {
             return $this->error(__('message.contest_detail_not_updatable'), 400, __('message.contest_detail_not_updatable'));
        }

        DB::beginTransaction();
        try {
            // Overwrite steps and data with the latest imported values
            $detail->total_steps = $totalSteps;
            $detail->device_type = $deviceType;
            $detail->start_at = $startAt;
            $detail->end_at = $endAt;
            
            // Check if target reached
            if ($detail->total_steps >= $contest->target) {
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
