<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate([
            'name' => 'manage_users',
        ]);
        Permission::firstOrCreate([
            'name' => 'manage_roles',
        ]);
        Permission::firstOrCreate([
            'name' => 'manage_permissions',
        ]);
        Permission::firstOrCreate([
            'name' => 'manage_weights',
        ]);
        Permission::firstOrCreate([
            'name' => 'manage_heights',
        ]);
    }
}
