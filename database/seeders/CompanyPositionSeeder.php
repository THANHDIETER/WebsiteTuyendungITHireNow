<?php
// File: database/seeders/CompanyPositionSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CompanyPositionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $companyIds = DB::table('companies')->pluck('id')->toArray();
        foreach ($companyIds as $companyId) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                DB::table('company_positions')->insert([
                    'company_id' => $companyId,
                    'position_name' => $faker->jobTitle,
                    'description' => $faker->paragraph,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}