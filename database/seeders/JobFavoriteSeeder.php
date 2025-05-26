<?php
// File: database/seeders/JobFavoriteSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobFavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $jobIds = DB::table('job_posts')->pluck('id')->toArray();
        $jobSeekerIds = DB::table('users')->where('role', 'job_seeker')->pluck('id')->toArray();
        foreach ($jobSeekerIds as $userId) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                DB::table('job_favorites')->insert([
                    'user_id' => $userId,
                    'job_id' => $faker->randomElement($jobIds),
                    'favorited_at' => now(),
                ]);
            }
        }
    }
}