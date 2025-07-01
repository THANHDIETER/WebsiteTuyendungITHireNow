<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Backend Developer', 'description' => 'Lập trình viên Backend'],
            ['name' => 'Frontend Developer', 'description' => 'Lập trình viên Frontend'],
            ['name' => 'Fullstack Developer', 'description' => 'Lập trình viên Fullstack'],
            ['name' => 'Mobile Developer', 'description' => 'Lập trình ứng dụng di động'],
            ['name' => 'DevOps Engineer', 'description' => 'Kỹ sư DevOps'],
            ['name' => 'UI/UX Designer', 'description' => 'Thiết kế giao diện và trải nghiệm người dùng'],
            ['name' => 'Project Manager', 'description' => 'Quản lý dự án phần mềm'],
            ['name' => 'Business Analyst', 'description' => 'Phân tích nghiệp vụ'],
            ['name' => 'Data Engineer', 'description' => 'Kỹ sư dữ liệu'],
            ['name' => 'Data Scientist', 'description' => 'Nhà khoa học dữ liệu'],
            ['name' => 'QA/QC Tester', 'description' => 'Kiểm thử phần mềm'],
            ['name' => 'AI/ML Engineer', 'description' => 'Kỹ sư trí tuệ nhân tạo / máy học'],
            ['name' => 'Security Engineer', 'description' => 'Kỹ sư bảo mật'],
            ['name' => 'Game Developer', 'description' => 'Lập trình game'],
            ['name' => 'System Administrator', 'description' => 'Quản trị hệ thống'],
            ['name' => 'Network Engineer', 'description' => 'Kỹ sư mạng'],
            ['name' => 'Scrum Master', 'description' => 'Điều phối Scrum'],
            ['name' => 'Technical Leader', 'description' => 'Trưởng nhóm kỹ thuật'],
        ];

        foreach ($categories as $index => $category) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'icon_url' => null,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
