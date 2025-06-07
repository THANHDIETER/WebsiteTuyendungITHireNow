<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kiểm tra xem có user và job nào không
        $reporterId = DB::table('users')->where('role', 'job_seeker')->inRandomOrder()->value('id');
        $job = DB::table('jobs')->inRandomOrder()->first();

       if (!$reporterId || !$job) {

            throw new \Exception('Không tìm thấy dữ liệu user hoặc job để tạo báo cáo.');
        }

        // Tạo danh sách báo cáo mẫu
        $reasons = ['spam', 'scam', 'abuse', 'duplicate'];
        $now = now();

        foreach ($reasons as $reason) {
            DB::table('reports')->insert([
                'target_type' => 'App\\Models\\Job',
                'target_id' => $job->id,
                'reporter_id' => $reporterId,
                'reason_code' => $reason,
                'message' => 'Báo cáo tự động: ' . ucfirst($reason),
                'status' => 'pending',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'SeederBot/1.0',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
