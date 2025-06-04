<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'Quản trị viên', 'description' => 'Quản lý toàn bộ hệ thống'],
            ['name' => 'employer', 'display_name' => 'Nhà tuyển dụng', 'description' => 'Người đăng tuyển công việc'],
            ['name' => 'job_seeker', 'display_name' => 'Ứng viên', 'description' => 'Người tìm việc'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                [
                    'display_name' => $role['display_name'],
                    'description' => $role['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
