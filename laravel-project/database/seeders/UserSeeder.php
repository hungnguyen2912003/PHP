<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'fullname' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);

        User::firstOrCreate([
            'email' => 'staff@example.com',
        ], [
            'fullname' => 'Staff',
            'username' => 'staff',
            'password' => Hash::make('12345678'),
            'role' => User::ROLE_STAFF,
            'status' => User::STATUS_ACTIVE,
        ]);

        for ($i = 1; $i <= 20; $i++) {
            User::firstOrCreate([
                'email' => "user{$i}@example.com",
            ], [
                'fullname' => "User {$i}",
                'username' => "user{$i}",
                'password' => Hash::make('12345678'),
                'role' => User::ROLE_USER,
                'status' => User::STATUS_ACTIVE,
            ]);
        }
    }
}
