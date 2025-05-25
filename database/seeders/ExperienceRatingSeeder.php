<?php
// File: database/seeders/ExperienceRatingSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ExperienceRatingSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $experienceIds = DB::table('experiences')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();
        foreach ($experienceIds as $experienceId) {
            DB::table('experience_ratings')->insert([
                'experience_id' => $experienceId,
                'reviewer_id' => $faker->randomElement($userIds),
                'rating' => $faker->numberBetween(1, 5),
                'comment' => $faker->paragraph,
                'created_at' => now(),
            ]);
        }
    }
}