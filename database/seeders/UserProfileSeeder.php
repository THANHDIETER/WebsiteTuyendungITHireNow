<?php
// File: database/seeders/UserProfileSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserProfileSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        foreach ($userIds as $userId) {
            DB::table('user_profiles')->insert([
                'user_id' => $userId,
                'full_name' => $faker->name,
                'birthday' => $faker->date('Y-m-d', '2000-01-01'),
                'address' => $faker->address,
                'professional_title' => $faker->jobTitle,
                'updated_at' => now(),
            ]);
        }
    }
}