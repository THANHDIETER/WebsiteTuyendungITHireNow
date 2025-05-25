<?php
// File: database/seeders/LanguageSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $resumeIds = DB::table('resumes')->pluck('id')->toArray();
        foreach ($resumeIds as $resumeId) {
            for ($i = 0; $i < rand(1, 2); $i++) {
                DB::table('languages')->insert([
                    'resume_id' => $resumeId,
                    'language_name' => $faker->randomElement(['English', 'Japanese', 'Spanish', 'French']),
                    'proficiency' => $faker->randomElement(['beginner', 'intermediate', 'advanced', 'native']),
                ]);
            }
        }
    }
}