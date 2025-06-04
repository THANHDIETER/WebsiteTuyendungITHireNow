<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritesSeeder extends Seeder
{
    public function run()
    {
        // Lấy user_id dựa trên email (hoặc thông tin khác)
        $userId = DB::table('users')->where('email', 'seeker@example.com')->value('id');

        if (!$userId) {
            throw new \Exception('User seeker@example.com chưa tồn tại trong bảng users.');
        }

        // Lấy job_id dựa theo slug hoặc title, tránh hardcode id không tồn tại
        $jobId = DB::table('jobs')->where('slug', 'senior-backend-developer')->value('id');

        if (!$jobId) {
            throw new \Exception('Job senior-backend-developer chưa tồn tại trong bảng jobs.');
        }

        DB::table('favorites')->insert([
            [
                'user_id' => $userId,
                'job_id' => $jobId,
                'note' => 'Yêu thích vị trí này',
                'created_at' => now(),
            ],
        ]);
    }
}
