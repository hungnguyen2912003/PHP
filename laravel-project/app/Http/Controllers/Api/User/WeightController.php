<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\User\Weight\StoreWeightRequest;
use App\Http\Requests\Api\User\Weight\UpdateWeightRequest;
use App\Models\Weight;
use App\Http\Resources\Api\User\Weight\WeightResource;


class WeightController extends BaseApiController
{
    public function __construct()
    {
        $this->authorizeResource(Weight::class, 'weight');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $weights = $user->isAdmin() ? Weight::all() : Weight::where('user_id', $user->id)->get();
        return $this->success(WeightResource::collection($weights), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWeightRequest $request)
    {
        $weight = Weight::create($request->validated());
        return $this->success(new WeightResource($weight), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Weight $weight)
    {
        return $this->success(new WeightResource($weight), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWeightRequest $request, Weight $weight)
    {
        $weight->update($request->validated());
        return $this->success(new WeightResource($weight), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weight $weight)
    {
        $weight->delete();
        return $this->success(null, 200);
    }
}
