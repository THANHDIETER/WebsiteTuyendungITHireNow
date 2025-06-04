<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsSeeder extends Seeder
{
    public function run()
    {
        // Lấy user_id dựa trên email
        $userId = DB::table('users')->where('email', 'seeker@example.com')->value('id');

        if (!$userId) {
            throw new \Exception('User seeker@example.com chưa tồn tại trong bảng users.');
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
            ],
        ]);
    }
}
