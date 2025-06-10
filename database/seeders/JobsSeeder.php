<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class JobsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');

        // Lấy danh sách company_id có sẵn
        $companyIds = DB::table('companies')->pluck('id');
        $categoryIds = DB::table('categories')->pluck('id');

        if ($companyIds->isEmpty()) {
            throw new \Exception('Không có công ty nào để gán job.');
        }

        for ($i = 1; $i <= 10; $i++) {
            $title = $faker->jobTitle;
            $slug = Str::slug($title) . '-' . $i;

            DB::table('jobs')->insert([
                'company_id' => $faker->randomElement($companyIds),
                'title' => $title,
                'slug' => $slug,
                'description' => $faker->paragraph,
                'requirements' => $faker->sentence(10),
                'benefits' => json_encode([$faker->catchPhrase, $faker->bs]),
                'job_type' => $faker->randomElement(['full-time', 'part-time', 'remote']),
                'salary_min' => $faker->numberBetween(8000000, 15000000),
                'salary_max' => $faker->numberBetween(15000000, 30000000),
                'currency' => 'VND',
                'location' => $faker->city,
                'address' => $faker->address,
                'level' => $faker->randomElement(['Junior', 'Mid', 'Senior']),
                'experience' => $faker->randomElement(['1+ years', '3+ years', '5+ years']),
                'category_id' => $faker->randomElement($categoryIds->toArray() ?: [1]),
                'deadline' => Carbon::now()->addDays(rand(15, 60)),
                'status' => 'published',
                'views' => rand(0, 200),
                'is_featured' => $faker->boolean(30),
                'remote_policy' => $faker->randomElement(['on-site', 'hybrid', 'remote']),
                'language' => $faker->randomElement(['Vietnamese', 'English']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}