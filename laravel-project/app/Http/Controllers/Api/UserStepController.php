<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\UserStep\ImportDataRequest;
use App\Http\Resources\Api\StepResource;
use App\Models\UserStep;
use Illuminate\Support\Facades\Auth;

class UserStepController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function importData(ImportDataRequest $request)
    {
        $data = $request->validated();

        $userStep = UserStep::create([
            'user_id' => Auth::id(),
            'steps' => $data['steps'],
            'device_source' => $data['device_source'],
            'recorded_at' => $data['recorded_at'],
        ]);

        return $this->successResponse(new StepResource($userStep));
    }
}
