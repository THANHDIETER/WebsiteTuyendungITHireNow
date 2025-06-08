<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ServicePackagesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('service_packages')->insert([
            [
                'name' => 'Gói Cơ Bản',
                'description' => 'Gói đăng tuyển cơ bản với giới hạn vừa đủ.',
                'price' => 490000,
                'duration_days' => 15,
                'post_limit' => 3,
                'highlight_days' => 3,
                'cv_view_limit' => 30,
                'support_level' => 'basic',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gói Nâng Cao',
                'description' => 'Gói nâng cao dành cho nhà tuyển dụng cần nhiều lượt hiển thị.',
                'price' => 990000,
                'duration_days' => 30,
                'post_limit' => 10,
                'highlight_days' => 7,
                'cv_view_limit' => 100,
                'support_level' => 'priority',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gói Doanh Nghiệp',
                'description' => 'Gói dành riêng cho khách hàng doanh nghiệp lớn.',
                'price' => 1990000,
                'duration_days' => 60,
                'post_limit' => 25,
                'highlight_days' => 15,
                'cv_view_limit' => 500,
                'support_level' => 'premium',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
