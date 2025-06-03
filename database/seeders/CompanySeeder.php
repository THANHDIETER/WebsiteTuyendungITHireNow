<?php
// File: database/seeders/CompanySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $employerIds = DB::table('users')->where('role', 'employer')->pluck('id')->toArray();
        foreach ($employerIds as $userId) {
            DB::table('companies')->insert([
                'user_id' => $userId,
                'name' => $faker->company,
                'location' => $faker->city,
                'industry' => $faker->randomElement(['Technology', 'Finance', 'Healthcare', 'Education']),
                'logo_url' => $faker->imageUrl(),
            ]);
        }
    }
}