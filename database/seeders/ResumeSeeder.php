<?php
// File: database/seeders/ResumeSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ResumeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $jobSeekerIds = DB::table('users')->where('role', 'job_seeker')->pluck('id')->toArray();
        foreach ($jobSeekerIds as $userId) {
            DB::table('resumes')->insert([
                'user_id' => $userId,
                'title' => $faker->sentence(3),
                'file_url' => $faker->url,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}