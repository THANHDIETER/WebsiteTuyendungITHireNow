<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminLogsSeeder extends Seeder
{
    public function run()
    {
        // Lấy admin user id hợp lệ
        $adminId = DB::table('users')->where('role', 'admin')->value('id');
        if (!$adminId) {
            throw new \Exception('Không tìm thấy user admin trong bảng users.');
        }

        DB::table('admin_logs')->insert([
            [
                'admin_id' => $adminId,
                'action' => 'update_job',
                'target_type' => 'job',
                'target_id' => 1,
                'description' => 'Cập nhật thông tin công việc',
                'entity_changes' => json_encode([
                    'title' => [
                        'old' => 'Junior Dev',
                        'new' => 'Senior Dev',
                    ],
                ]),
                'ip_address' => '127.0.0.1',
                'browser_info' => 'Chrome',
                'log_level' => 'info',
                'user_before' => json_encode([]),
                'user_after' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
