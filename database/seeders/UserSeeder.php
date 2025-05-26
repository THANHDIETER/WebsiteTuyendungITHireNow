<?php
// File: database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'email' => $faker->unique()->safeEmail,
                'password_hash' => Hash::make('password'),
                'role' => $faker->randomElement(['job_seeker', 'employer', 'admin']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}