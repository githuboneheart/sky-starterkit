<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@sky.test'],
            [
                'name'              => 'Super Administrator',
                'phone'             => '081234567890',
                'password'          => Hash::make('password'),
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('Super Admin');

        // 2. Akun Admin Operasional
        $admin = User::firstOrCreate(
            ['email' => 'staff@sky.test'],
            [
                'name'              => 'Staff Admin',
                'phone'             => '089876543210',
                'password'          => Hash::make('password'),
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('Admin');
    }
}
