<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $userRole = Role::where('name', 'User')->first();

        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'fullname' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);

        User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'fullname' => 'User',
            'username' => 'user',
            'password' => Hash::make('12345678'),
            'role_id' => $userRole->id,
            'status' => 'active',
        ]);
    }
}
