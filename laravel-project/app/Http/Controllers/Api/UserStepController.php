<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\UserStep\ImportDataRequest;
use App\Models\UserStep;
use Illuminate\Support\Facades\Cache;
use App\Models\UserContest;

use Illuminate\Support\Facades\DB;

class UserStepController extends BaseApiController
{
    public function importData(ImportDataRequest $request)
    {
        $user = auth()->user();

        DB::beginTransaction();
        try {

            $data = [];
            foreach ($request->logs as $log) {
                $data[] = [
                    'user_id' => $user->id,
                    'device_source' => $request->device_source,
                    'recorded_at' => $log['recorded_at'],
                    'steps' => $log['steps'],
                ];
            }

            UserStep::upsert(
                $data,
                ['user_id', 'device_source', 'recorded_at'],
                ['steps']
            );

            $contests = UserContest::where('user_id', $user->id)
                ->where('status', UserContest::STATUS_INPROGRESS)
                ->get();

            foreach ($contests as $contest) {
                $totalSteps = UserStep::where('user_id', $user->id)
                    ->where('recorded_at', '>=', $contest->start_time)
                    ->where('recorded_at', '<=', now())
                    ->sum('steps');

                $contest->update([
                    'total_steps'   => $totalSteps,
                    'device_source' => $request->device_source,
                ]);

                // Cache total_steps
                Cache::put(
                    "user_contest_steps:{$user->id}:{$contest->contest_id}",
                    (int) $totalSteps,
                    now()->addHours(24)
                );
            }

            DB::commit();

            return $this->success(201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error(400, $e->getMessage());
        }
    }
}
