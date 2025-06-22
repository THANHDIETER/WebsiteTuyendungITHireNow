<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationsSeeder extends Seeder
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

        DB::table('educations')->insert([
            [
                'user_id' => $userId,
                'school_name' => 'Đại học Bách Khoa',
                'major' => 'Công nghệ thông tin',
                'degree' => 'Cử nhân',
                'start_date' => '2020-09-01',
                'end_date' => '2024-06-30',
                'details' => 'Học chuyên ngành phát triển phần mềm, tham gia nhiều dự án thực tế.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
