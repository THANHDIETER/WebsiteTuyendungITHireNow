<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JobsSeeder extends Seeder
{
    public function run()
    {
        // Lấy lại company_id đã tạo từ CompaniesSeeder, hoặc fallback
        $companyId = \Database\Seeders\CompaniesSeeder::$companyId;
        if (!$companyId) {
            $companyId = DB::table('companies')->where('slug', 'cong-ty-abc')->value('id');
        }

        if (!$companyId) {
            throw new \Exception('Không tìm thấy công ty để gán cho job.');
        }

        // Dùng updateOrInsert để tránh lỗi duplicate
        DB::table('jobs')->updateOrInsert(
            ['slug' => 'senior-backend-developer'],
            [
                'company_id' => $companyId,
                'title' => 'Senior Backend Developer',
                'description' => 'Phát triển API và backend hệ thống',
                'requirements' => 'Kinh nghiệm 3+ năm PHP, Laravel',
                'benefits' => json_encode(['Lương cao', 'Thưởng KPI']),
                'job_type' => 'full-time',
                'salary_min' => 15000000,
                'salary_max' => 25000000,
                'currency' => 'VND',
                'location' => 'Hà Nội',
                'address' => 'Tầng 10, Tòa nhà XYZ',
                'level' => 'Senior',
                'experience' => '3+ years',
                'category_id' => 1,
                'deadline' => Carbon::now()->addMonth(),
                'status' => 'published',
                'views' => 0,
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
