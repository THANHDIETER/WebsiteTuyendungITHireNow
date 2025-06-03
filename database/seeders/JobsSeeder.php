<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobsSeeder extends Seeder
{
    public function run()
    {
        // Lấy company_id đúng (ví dụ như lưu static trong CompaniesSeeder)
        $companyId = \Database\Seeders\CompaniesSeeder::$companyId;

        if (!$companyId) {
            $companyId = DB::table('companies')->value('id');
        }

        DB::table('jobs')->insert([
            [
                'id' => Str::uuid(),
                'company_id' => $companyId,
                'title' => 'Senior Backend Developer',
                'slug' => 'senior-backend-developer',
                'description' => 'Phát triển API và backend hệ thống',  // Cần thêm dòng này
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
                'deadline' => now()->addMonth(),
                'status' => 'published',
                'views' => 0,
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
