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
        $nd = collect([
            // Tiêu đề chính
            '<h3>' . $faker->sentence . '</h3>',

            // 2 đoạn văn mô tả chung
            '<p>' . $faker->paragraph(5, true) . '</p>',
            '<p>' . $faker->paragraph(4, true) . '</p>',

            // Mục tiêu công việc
            '<h4>' . $faker->sentence(4) . '</h4>',
            '<ul>' . collect(range(1, 4))
                ->map(fn() => '<li>' . $faker->sentence(10) . '</li>')
                ->implode('') . '</ul>',

            // Trách nhiệm chính
            '<h4>Trách nhiệm</h4>',
            '<ol>' . collect(range(1, 5))
                ->map(fn() => '<li>' . $faker->sentence(12) . '</li>')
                ->implode('') . '</ol>',

            // Kỹ năng cần thiết
            '<h4>Kỹ năng cần có</h4>',
            '<ul>' . collect(range(1, 3))
                ->map(fn() => '<li>' . $faker->sentence(8) . '</li>')
                ->implode('') . '</ul>',

            // Ghi chú cuối
            '<p><strong>Ghi chú:</strong> ' . $faker->sentence(15) . '</p>',
        ])->implode("\n");

        // Lấy danh sách company_id có sẵn
        $companyIds = DB::table('companies')->pluck('id');
        $categoryIds = DB::table('categories')->pluck('id');

        

        for ($i = 1; $i <= 10; $i++) {
            $title = $faker->jobTitle;
            $slug = Str::slug($title) . '-' . $i;

            DB::table('jobs')->insert([
                'company_id' => $faker->randomElement($companyIds),
                'title' => $title,
                'slug' => $slug,
                'description' => $nd,
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
                'status' => 'pending',
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