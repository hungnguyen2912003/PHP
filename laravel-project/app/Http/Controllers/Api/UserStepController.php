<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\UserStep\ImportDataRequest;
use App\Http\Resources\Api\UserStepResource;
use App\Models\UserStep;
use Illuminate\Support\Facades\DB;

class UserStepController extends BaseApiController
{
    public function importData(ImportDataRequest $request)
    {
        $user = auth()->user();

        DB::beginTransaction();
        try {
            foreach ($request->logs as $log) {
                UserStep::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'device_source' => $request->device_source,
                        'recorded_at' => $log['recorded_at'],
                    ],
                    [
                        'steps' => $log['steps'],
                    ]
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
