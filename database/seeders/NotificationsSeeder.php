<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationsSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy user employer đầu tiên
        $user = DB::table('users')->where('role', 'employer')->inRandomOrder()->first();

        if (!$user) {
            throw new \Exception('Không tìm thấy user có role employer.');
        }

        DB::table('notifications')->insert([
            [
                'id' => (string) Str::uuid(),
                'type' => 'App\\Notifications\\Employer\\JobApprovedNotification',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id' => $user->id,
                'data' => json_encode([
                    'message' => "Tin tuyển dụng đã được duyệt.",
                    'link_url' => '/employer/jobs/1',
                ]),
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
