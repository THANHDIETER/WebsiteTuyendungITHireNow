<?php
// File: database/seeders/EducationSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $resumeIds = DB::table('resumes')->pluck('id')->toArray();
        foreach ($resumeIds as $resumeId) {
            for ($i = 0; $i < rand(1, 2); $i++) {
                DB::table('educations')->insert([
                    'resume_id' => $resumeId,
                    'school' => $faker->company,
                    'major' => $faker->word,
                    'start_year' => $faker->year('-10 years'),
                    'end_year' => $faker->year('-5 years'),
                ]);
            }
        }
    }
}