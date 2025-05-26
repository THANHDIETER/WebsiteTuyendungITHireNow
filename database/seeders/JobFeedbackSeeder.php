<?php
// File: database/seeders/JobFeedbackSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobFeedbackSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $applicationIds = DB::table('job_applications')->pluck('id')->toArray();
        foreach ($applicationIds as $applicationId) {
            $application = DB::table('job_applications')->find($applicationId);
            DB::table('job_feedback')->insert([
                'application_id' => $applicationId,
                'from_user_id' => $faker->randomElement([DB::table('users')->where('role', 'employer')->first()->id]),
                'to_user_id' => $application->user_id,
                'rating' => $faker->numberBetween(1, 5),
                'comment' => $faker->paragraph,
                'created_at' => now(),
            ]);
        }
    }
}