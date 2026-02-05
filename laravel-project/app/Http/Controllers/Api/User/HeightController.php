<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\User\Height\StoreHeightRequest;
use App\Http\Requests\Api\User\Height\UpdateHeightRequest;
use App\Models\Height;
use App\Http\Resources\Api\User\Height\HeightResource;


class HeightController extends BaseApiController
{
    public function __construct()
    {
        $this->authorizeResource(Height::class, 'height');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $heights = $user->isAdmin() ? Height::all() : Height::where('user_id', $user->id)->get();
        return $this->success(HeightResource::collection($heights), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHeightRequest $request)
    {
        $height = Height::create($request->validated());
        return $this->success(new HeightResource($height), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Height $height)
    {
        return $this->success(new HeightResource($height), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHeightRequest $request, Height $height)
    {
        $height->update($request->validated());
        return $this->success(new HeightResource($height), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Height $height)
    {
        $height->delete();
        return $this->success(null, 200);
    }
}
