<?php
// File: database/seeders/NotificationSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        for ($i = 0; $i < 50; $i++) {
            DB::table('notifications')->insert([
                'user_id' => $faker->randomElement($userIds),
                'message' => $faker->sentence,
                'is_read' => $faker->boolean,
                'created_at' => now(),
            ]);
        }
    }
}