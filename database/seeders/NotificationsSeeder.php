<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsSeeder extends Seeder
{
    public function run()
    {
        // Lấy user ngẫu nhiên có role là job_seeker
        $userId = DB::table('users')
            ->where('role', 'job_seeker')
            ->inRandomOrder()
            ->value('id');

        if (!$userId) {
            throw new \Exception('Không tìm thấy user nào có role là "job_seeker".');
        }

        DB::table('notifications')->insert([
            [
                'user_id' => $userId,
                'type' => 'new_job',
                'message' => 'Có công việc mới phù hợp với bạn.',
                'link_url' => '/jobs/1',
                'is_read' => false,
                'is_sent' => false,
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
