<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployerPackagesSeeder extends Seeder
{
    public function run()
    {
        DB::table('employer_packages')->insert([
            [
                'name' => 'Gói cơ bản',
                'description' => 'Gói đăng tuyển cơ bản',
                'price' => 1000000,
                'duration_days' => 30,
                'post_limit' => 5,
                'highlight_days' => 0,
                'cv_view_limit' => 10,
                'support_level' => 'basic',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
