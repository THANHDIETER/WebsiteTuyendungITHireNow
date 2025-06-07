<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    public function run()
    {
        // Lấy user ngẫu nhiên theo role
        $adminUserId = DB::table('users')->where('role', 'admin')->inRandomOrder()->value('id');
        $employerUserId = DB::table('users')->where('role', 'employer')->inRandomOrder()->value('id');
        $seekerUserId = DB::table('users')->where('role', 'job_seeker')->inRandomOrder()->value('id');

        // Lấy role_id theo name
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        $employerRoleId = DB::table('roles')->where('name', 'employer')->value('id');
        $seekerRoleId = DB::table('roles')->where('name', 'job_seeker')->value('id');

        // Kiểm tra tồn tại
        if (!$adminUserId || !$employerUserId || !$seekerUserId) {
            throw new \Exception('Không tìm thấy user_id cho một hoặc nhiều user (theo role).');
        }
        if (!$adminRoleId || !$employerRoleId || !$seekerRoleId) {
            throw new \Exception('Không tìm thấy role_id cho một hoặc nhiều role.');
        }

        // Gán vai trò cho user
        DB::table('user_roles')->insert([
            [
                'user_id' => $adminUserId,
                'role_id' => $adminRoleId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $employerUserId,
                'role_id' => $employerRoleId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $seekerUserId,
                'role_id' => $seekerRoleId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
