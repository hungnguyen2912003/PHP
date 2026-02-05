<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Admin\Role\StoreRoleRequest;
use App\Http\Requests\Api\Admin\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Http\Resources\Api\Admin\Role\RoleResource;


class RoleController extends BaseApiController
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return $this->success(RoleResource::collection($roles), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());
        return $this->success(new RoleResource($role), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return $this->success(new RoleResource($role), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return $this->success(new RoleResource($role), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->success(null, 200);
    }
}
