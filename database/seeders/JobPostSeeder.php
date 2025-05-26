<?php
// File: database/seeders/JobSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobPostSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $companyIds = DB::table('companies')->pluck('id')->toArray();
        for ($i = 0; $i < 30; $i++) {
            DB::table('job_posts')->insert([
                'company_id' => $faker->randomElement($companyIds),
                'title' => $faker->jobTitle,
                'description' => $faker->paragraph,
                'requirements' => $faker->paragraph,
                'location' => $faker->city,
                'salary_max' => $faker->randomFloat(2, 1000, 10000),
                'job_type' => $faker->randomElement(['full-time', 'part-time', 'contract', 'remote']),
                'created_at' => now(),
                'expires_at' => $faker->dateTimeBetween('now', '+1 year'),
            ]);
        }
    }
}