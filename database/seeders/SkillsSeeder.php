<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SkillsSeeder extends Seeder
{
    public function run()
    {
        // Lấy ID từ slug
        $categories = DB::table('categories')->pluck('id', 'slug');

        $skills = [
            [
                'slug' => 'php',
                'name' => 'PHP',
                'description' => 'Ngôn ngữ lập trình PHP',
                'category_slug' => 'backend-developer',
            ],
            [
                'slug' => 'laravel',
                'name' => 'Laravel',
                'description' => 'Framework PHP Laravel',
                'category_slug' => 'backend-developer',
            ],
            [
                'slug' => 'mysql',
                'name' => 'MySQL',
                'description' => 'Hệ quản trị CSDL MySQL',
                'category_slug' => 'backend-developer',
            ],
        ];

        foreach ($skills as $skill) {
            $categoryId = $categories[$skill['category_slug']] ?? null;

            if (!$categoryId) {
                echo "⚠️ Không tìm thấy category slug: {$skill['category_slug']}, bỏ qua...\n";
                continue;
            }

            DB::table('skills')->updateOrInsert(
                ['slug' => $skill['slug']],
                [
                    'name' => $skill['name'],
                    'description' => $skill['description'],
                    'category_id' => $categoryId,
                    'is_active' => true,
                    'proficiency_level' => 'advanced',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
