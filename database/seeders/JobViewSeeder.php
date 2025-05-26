<?php
// File: database/seeders/JobViewSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobViewSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $jobIds = DB::table('job_posts')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();
        for ($i = 0; $i < 100; $i++) {
            DB::table('job_views')->insert([
                'job_id' => $faker->randomElement($jobIds),
                'user_id' => $faker->randomElement([null, ...$userIds]),
                'viewed_at' => now(),
            ]);
        }
    }
}