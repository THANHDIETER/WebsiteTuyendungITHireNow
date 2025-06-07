<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExperiencesSeeder extends Seeder
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

        DB::table('experiences')->insert([
            [
                'user_id' => $userId,
                'company_name' => 'Công ty ABC',
                'position' => 'Backend Developer',
                'start_date' => '2019-06-01',
                'end_date' => '2022-05-31',
                'description' => 'Phát triển hệ thống backend.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
