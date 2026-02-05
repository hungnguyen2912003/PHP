<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Admin\User\StoreUserRequest;
use App\Http\Requests\Api\Admin\User\UpdateUserRequest;
use App\Models\User;
use App\Http\Resources\Api\Admin\User\UserResource;


class UserController extends BaseApiController
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->get();
        return $this->success(UserResource::collection($users), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        return $this->success(new UserResource($user->load('role')), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->success(new UserResource($user->load('role')), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return $this->success(new UserResource($user->load('role')), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->success(null, 200);
    }
}
