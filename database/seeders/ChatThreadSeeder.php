<?php
// File: database/seeders/ChatThreadSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ChatThreadSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $jobIds = DB::table('job_posts')->pluck('id')->toArray();
        $employerIds = DB::table('users')->where('role', 'employer')->pluck('id')->toArray();
        $jobSeekerIds = DB::table('users')->where('role', 'job_seeker')->pluck('id')->toArray();
        for ($i = 0; $i < 20; $i++) {
            DB::table('chat_threads')->insert([
                'job_id' => $faker->randomElement([null, ...$jobIds]),
                'employer_id' => $faker->randomElement($employerIds),
                'job_seeker_id' => $faker->randomElement($jobSeekerIds),
            ]);
        }
    }
}