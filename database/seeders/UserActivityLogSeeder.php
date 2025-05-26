<?php
// File: database/seeders/UserActivityLogSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        for ($i = 0; $i < 100; $i++) {
            DB::table('user_activity_logs')->insert([
                'user_id' => $faker->randomElement($userIds),
                'action' => $faker->randomElement(['login', 'apply_job', 'edit_resume']),
                'description' => $faker->sentence,
                'action_time' => now(),
            ]);
        }
    }
}