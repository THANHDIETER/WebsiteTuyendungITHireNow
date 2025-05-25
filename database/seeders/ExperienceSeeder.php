<?php
// File: database/seeders/ExperienceSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $resumeIds = DB::table('resumes')->pluck('id')->toArray();
        foreach ($resumeIds as $resumeId) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                DB::table('experiences')->insert([
                    'resume_id' => $resumeId,
                    'company' => $faker->company,
                    'position' => $faker->jobTitle,
                    'start_date' => $faker->date('Y-m-d', '-5 years'),
                    'end_date' => $faker->date('Y-m-d', 'now'),
                    'description' => $faker->paragraph,
                ]);
            }
        }
    }
}