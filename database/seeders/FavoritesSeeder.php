<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritesSeeder extends Seeder
{
    public function run()
    {
        // Lấy user_id ngẫu nhiên có role là job_seeker
        $userId = DB::table('users')
            ->where('role', 'job_seeker')
            ->inRandomOrder()
            ->value('id');

        if (!$userId) {
            throw new \Exception('Không tìm thấy user nào có role là "job_seeker".');
        }

        // Lấy job_id ngẫu nhiên
        $jobId = DB::table('jobs')
            ->inRandomOrder()
            ->value('id');

        if (!$jobId) {
            throw new \Exception('Không tìm thấy job nào trong bảng jobs.');
        }

        // Insert dữ liệu yêu thích
        DB::table('favorites')->insert([
            [
                'user_id' => $userId,
                'job_id' => $jobId,
                'note' => 'Yêu thích vị trí này',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

