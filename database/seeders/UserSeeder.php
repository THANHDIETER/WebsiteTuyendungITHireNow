<?php
// File: database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Tạo 2 admin
        for ($i = 0; $i < 2; $i++) {
            DB::table('users')->insert([
                'email' => 'admin' . $i . '@example.com',
                'password_hash' => Hash::make('admin123'),
                'role' => 'admin',
                'is_blocked' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Tạo 6 employer
        for ($i = 0; $i < 6; $i++) {
            DB::table('users')->insert([
                'email' => 'employer' . $i . '@example.com',
                'password_hash' => Hash::make('employer123'),
                'role' => 'employer',
                'is_blocked' => $faker->boolean(10), // 10% bị block
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Tạo 12 job seeker
        for ($i = 0; $i < 12; $i++) {
            DB::table('users')->insert([
                'email' => 'seeker' . $i . '@example.com',
                'password_hash' => Hash::make('seeker123'),
                'role' => 'job_seeker',
                'is_blocked' => $faker->boolean(5), // 5% bị block
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

