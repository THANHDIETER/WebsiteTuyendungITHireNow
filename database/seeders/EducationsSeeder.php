<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationsSeeder extends Seeder
{
    public function run()
    {
        // Lấy user_id dựa vào email hoặc role
        $userId = DB::table('users')->where('email', 'seeker@example.com')->value('id');
        if (!$userId) {
            throw new \Exception('User seeker@example.com chưa tồn tại trong bảng users.');
        }

        DB::table('educations')->insert([
            [
                'user_id' => $userId,
                'school_name' => 'Đại học Bách Khoa',
                'major' => 'Công nghệ thông tin',
                'degree' => 'Cử nhân',
                'start_year' => 2015,
                'end_year' => 2019,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
