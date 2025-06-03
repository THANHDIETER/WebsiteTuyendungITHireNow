<?php
// File: database/seeders/EmployerReviewSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EmployerReviewSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $employerIds = DB::table('users')->where('role', 'employer')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();
        foreach ($employerIds as $employerId) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                DB::table('employer_reviews')->insert([
                    'employer_id' => $employerId,
                    'user_id' => $faker->randomElement($userIds),
                    'rating' => $faker->numberBetween(1, 5),
                    'comment' => $faker->paragraph,
                    'created_at' => now(),
                ]);
            }
        }
    }
}