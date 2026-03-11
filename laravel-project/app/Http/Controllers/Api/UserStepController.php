<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\UserStep\ImportDataRequest;
use App\Models\UserStep;
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
                $contest->update([
                    'total_steps' => UserStep::where('user_id', $user->id)
                        ->where('recorded_at', '>=', $contest->start_time)
                        ->where('recorded_at', '<=', now())
                        ->sum('steps'),
                ]);
            }

            DB::commit();

            return $this->success(201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error(400, $e->getMessage());
        }
    }
}
