<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class Role_PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $userRole = Role::where('name', 'User')->first();

        $permissions = Permission::all();

        $adminRole->permissions()->sync($permissions);

        $userPermissions = Permission::whereIn('name', [
            'manage_weights',
            'manage_heights',
        ])->get();

        $userRole->permissions()->sync($userPermissions);
    }
}
