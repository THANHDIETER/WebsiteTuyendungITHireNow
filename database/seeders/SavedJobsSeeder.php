<?php
// File: database/seeders/SavedJobsSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SavedJobsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->where('role', 'job_seeker')->pluck('id')->toArray();
        $jobIds = DB::table('job_posts')->pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            DB::table('saved_jobs')->insert([
                'user_id' => $faker->randomElement($userIds),
                'job_id' => $faker->randomElement($jobIds),
                'saved_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }
    }
}