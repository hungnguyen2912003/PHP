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
            'role' => 'admin',
            'status' => User::STATUS_ACTIVE,
        ]);

        User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'fullname' => 'User',
            'username' => 'user',
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'status' => User::STATUS_ACTIVE,
        ]);
    }
}
