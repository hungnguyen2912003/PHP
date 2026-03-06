<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\StepLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\Contest\ImportDataRequest;

class StepLogController extends BaseApiController
{
    public function importData(ImportDataRequest $request)
    {
        $user = auth()->user();

        DB::beginTransaction();
        try {
            // Create step logs
            foreach ($request->logs as $log) {
                StepLog::create([
                    'user_id' => $user->id,
                    'source' => $log['source'],
                    'steps' => $log['steps'],
                    'recorded_at' => $log['recorded_at'],
                ]);
            }

            DB::commit();

            return $this->success();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }
}