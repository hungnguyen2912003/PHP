<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\User\Height\StoreHeightRequest;
use App\Http\Requests\Api\User\Height\UpdateHeightRequest;
use App\Models\Height;

class HeightController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heights = Height::all();
        return $this->success($heights, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHeightRequest $request)
    {
        $height = $request->validated();
        $height = Height::create($height);
        return $this->success($height, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $height = Height::findOrFail($id);
        return $this->success($height, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHeightRequest $request, string $id)
    {
        $height = Height::findOrFail($id);
        $height->update($request->validated());
        return $this->success($height, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $height = Height::findOrFail($id);
        $height->delete();
        return $this->success(null, 200);
    }
}
