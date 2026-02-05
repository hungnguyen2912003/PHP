<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\DataTables\RolesDataTable;
use App\Http\Requests\Admin\roles\StoreRoleRequest;
use App\Http\Requests\Admin\roles\UpdateRoleRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.roles.index');
    }

    public function create()
    {
        return view('admin.pages.roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();

        Role::create($validated);

        flash()->success(__('message.role.created'), [], __('notification.success'));
        return redirect()->route('admin.roles.index');
    }

    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        return view('admin.pages.roles.show', compact('role'));
    }

    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return view('admin.pages.roles.edit', compact('role'));
    }

    public function editPost(UpdateRoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->validated());

        flash()->success(__('message.role.updated'), [], __('notification.success'));
        return redirect()->route('admin.roles.index');
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        
        // Prevent deleting Admin role if it's the core one, or check for users
        if ($role->name === 'Admin') {
            flash()->error(__('message.role.delete_admin_denied'), [], __('notification.error'));
            return redirect()->back();
        }

        if ($role->users()->count() > 0) {
            flash()->error(__('message.role.has_users'), [], __('notification.error'));
            return redirect()->back();
        }

        $role->delete();

        flash()->success(__('message.role.deleted'), [], __('notification.success'));
        return redirect()->back();
    }
}
