<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CompaniesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $employerIds = DB::table('users')->where('role', 'employer')->pluck('id');

        foreach ($employerIds as $userId) {
            DB::table('companies')->insert([
                'user_id' => $userId,
                'name' => $faker->company,
                'slug' => Str::slug($faker->company . '-' . $faker->unique()->randomNumber()),
                'logo_url' => $faker->imageUrl(200, 200, 'business', true),
                'cover_image_url' => $faker->imageUrl(800, 200, 'business', true),
                'website' => $faker->url,
                'email' => $faker->companyEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'city' => $faker->city,
                'company_size' => $faker->randomElement(['1-10', '11-50', '51-200', '201-500']),
                'founded_year' => $faker->year,
                'industry' => $faker->word,
                'description' => $faker->paragraph,
                'benefits' => json_encode(['Bảo hiểm', 'Nghỉ phép', 'Lương tháng 13']),
                'is_verified' => $faker->boolean(70),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

