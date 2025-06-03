<?php
// File: database/seeders/ProjectSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $resumeIds = DB::table('resumes')->pluck('id')->toArray();
        foreach ($resumeIds as $resumeId) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                DB::table('projects')->insert([
                    'resume_id' => $resumeId,
                    'name' => $faker->sentence(3),
                    'description' => $faker->paragraph,
                    'start_date' => $faker->date('Y-m-d', '-3 years'),
                    'end_date' => $faker->date('Y-m-d', 'now'),
                ]);
            }
        }
    }
}