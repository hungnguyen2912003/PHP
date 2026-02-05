<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\User\Weight\StoreWeightRequest;
use App\Http\Requests\Api\User\Weight\UpdateWeightRequest;
use App\Models\Weight;

class WeightController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weights = Weight::all();
        return $this->success($weights, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWeightRequest $request)
    {
        $weight = $request->validated();
        $weight = Weight::create($weight);
        return $this->success($weight, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $weight = Weight::findOrFail($id);
        return $this->success($weight, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWeightRequest $request, string $id)
    {
        $weight = Weight::findOrFail($id);
        $weight->update($request->validated());
        return $this->success($weight, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $weight = Weight::findOrFail($id);
        $weight->delete();
        return $this->success(null, 200);
    }
}
