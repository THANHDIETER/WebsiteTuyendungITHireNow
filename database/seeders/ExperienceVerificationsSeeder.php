<?php
// File: database/seeders/ExperienceVerificationsSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ExperienceVerificationsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $experienceIds = DB::table('experiences')->pluck('id')->toArray();
        $verifierIds = DB::table('users')->whereIn('role', ['admin', 'employer'])->pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            DB::table('experience_verifications')->insert([
                'experience_id' => $faker->randomElement($experienceIds),
                'verifier_id' => $faker->randomElement($verifierIds),
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'comment' => $faker->sentence,
                'verified_at' => $faker->optional(0.7)->dateTimeBetween('-15 days', 'now'),
            ]);
        }
    }
}