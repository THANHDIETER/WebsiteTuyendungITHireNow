<?php
// File: database/seeders/JobApplicationSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $jobIds = DB::table('job_posts')->pluck('id')->toArray();
        $jobSeekerIds = DB::table('users')->where('role', 'job_seeker')->pluck('id')->toArray();
        $resumeIds = DB::table('resumes')->pluck('id')->toArray();
        for ($i = 0; $i < 50; $i++) {
            $userId = $faker->randomElement($jobSeekerIds);
            $resumeId = $faker->randomElement($resumeIds);
            DB::table('job_applications')->insert([
                'job_id' => $faker->randomElement($jobIds),
                'user_id' => $userId,
                'resume_id' => $resumeId,
                'cover_letter' => $faker->paragraph,
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'applied_at' => now(),
            ]);
        }
    }
}