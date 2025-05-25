<?php
// File: database/seeders/UserLoginHistorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserLoginHistorySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        for ($i = 0; $i < 100; $i++) {
            DB::table('user_login_histories')->insert([
                'user_id' => $faker->randomElement($userIds),
                'login_time' => now(),
                'ip_address' => $faker->ipv4,
                'device_info' => $faker->userAgent,
            ]);
        }
    }
}