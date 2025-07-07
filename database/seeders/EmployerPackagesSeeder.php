<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployerPackage;

class EmployerPackagesSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            [
                'name' => 'Gói Cơ Bản',
                'description' => 'Gói đăng tuyển cơ bản, phù hợp với doanh nghiệp nhỏ.',
                'price' => 1000000,
                'duration_days' => 30,
                'post_limit' => 5,
                'highlight_days' => 0,
                'cv_view_limit' => 10,
                'support_level' => 'basic',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Gói Nâng Cao',
                'description' => 'Gói đăng tuyển nâng cao, dành cho doanh nghiệp đang phát triển.',
                'price' => 3000000,
                'duration_days' => 60,
                'post_limit' => 15,
                'highlight_days' => 5,
                'cv_view_limit' => 50,
                'support_level' => 'standard',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Gói Chuyên Nghiệp',
                'description' => 'Gói cao cấp dành cho doanh nghiệp có nhu cầu tuyển dụng lớn.',
                'price' => 7000000,
                'duration_days' => 90,
                'post_limit' => 50,
                'highlight_days' => 15,
                'cv_view_limit' => 200,
                'support_level' => 'premium',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            EmployerPackage::create($package);
        }
    }
}
