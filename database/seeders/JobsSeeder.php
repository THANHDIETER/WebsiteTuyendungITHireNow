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
            '<h3>' . $faker->sentence . '</h3>',
            '<p>' . $faker->paragraph(5, true) . '</p>',
            '<p>' . $faker->paragraph(4, true) . '</p>',
            '<h4>' . $faker->sentence(4) . '</h4>',
            '<ul>' . collect(range(1, 4))->map(fn () => '<li>' . $faker->sentence(10) . '</li>')->implode('') . '</ul>',
            '<h4>Trách nhiệm</h4>',
            '<ol>' . collect(range(1, 5))->map(fn () => '<li>' . $faker->sentence(12) . '</li>')->implode('') . '</ol>',
            '<h4>Kỹ năng cần có</h4>',
            '<ul>' . collect(range(1, 3))->map(fn () => '<li>' . $faker->sentence(8) . '</li>')->implode('') . '</ul>',
            '<p><strong>Ghi chú:</strong> ' . $faker->sentence(15) . '</p>',
        ])->implode("\n");

        $companyIds = DB::table('companies')->pluck('id');
        $categoryIds = DB::table('categories')->pluck('id');
        $skillIds = DB::table('skills')->pluck('id');

        for ($i = 1; $i <= 10; $i++) {
            $title = $faker->jobTitle;
            $slug = Str::slug($title) . '-' . $i;

            $jobId = DB::table('jobs')->insertGetId([
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
                'is_paid' => $faker->boolean(50),
                'remote_policy' => $faker->randomElement(['on-site', 'hybrid', 'remote']),
                'language' => $faker->randomElement(['Vietnamese', 'English']),
                'meta_title' => $title,
                'meta_description' => $faker->paragraph(2),
                'search_index' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert vào bảng phụ job_skill nếu có dữ liệu kỹ năng
            if ($skillIds->count() > 0) {
                $maxSkills = min($skillIds->count(), rand(2, 4));

                DB::table('job_skill')->insert(
                    $skillIds->random($maxSkills)->map(function ($skillId) use ($jobId) {
                        return [
                            'job_id' => $jobId,
                            'skill_id' => $skillId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    })->toArray()
                );
            }
        }
    }
}
