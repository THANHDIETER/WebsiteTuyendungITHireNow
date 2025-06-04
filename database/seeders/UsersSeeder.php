<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'name' => 'Admin User',
                'phone_number' => '0123456789',
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'email' => 'employer@example.com',
                'password' => Hash::make('password'),
                'name' => 'Employer User',
                'phone_number' => '0987654321',
                'role' => 'employer',
                'status' => 'active',
            ],
            [
                'email' => 'seeker@example.com',
                'password' => Hash::make('password'),
                'name' => 'Job Seeker',
                'phone_number' => '0912345678',
                'role' => 'job_seeker',
                'status' => 'active',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                array_merge($user, [
                    'email_verified_at' => now(),
                    'last_login_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
