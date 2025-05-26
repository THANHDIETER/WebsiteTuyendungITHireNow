<?php
// File: database/seeders/JobStatisticsSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobStatisticsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $jobIds = DB::table('job_posts')->pluck('id')->toArray();
        foreach ($jobIds as $jobId) {
            DB::table('job_statistics')->insert([
                'job_id' => $jobId,
                'views_count' => $faker->numberBetween(0, 1000),
                'application_count' => $faker->numberBetween(0, 100),
                'last_updated' => now(),
            ]);
        }
    }
}