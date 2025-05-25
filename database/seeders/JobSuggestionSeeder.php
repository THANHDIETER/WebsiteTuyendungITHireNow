<?php
// File: database/seeders/JobSuggestionSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobSuggestionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $jobIds = DB::table('job_posts')->pluck('id')->toArray();
        $jobSeekerIds = DB::table('users')->where('role', 'job_seeker')->pluck('id')->toArray();
        foreach ($jobSeekerIds as $userId) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                DB::table('job_suggestions')->insert([
                    'user_id' => $userId,
                    'job_id' => $faker->randomElement($jobIds),
                    'score' => $faker->randomFloat(2, 0, 100),
                ]);
            }
        }
    }
}