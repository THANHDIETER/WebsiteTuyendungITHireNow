<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSkillSeeder extends Seeder
{
    public function run()
    {
        // Lấy job id đầu tiên trong bảng jobs
        $jobId = DB::table('jobs')->value('id');

        // Lấy skill ids bạn muốn dùng (ví dụ skill 1, skill 2)
        $skillIds = DB::table('skills')->pluck('id')->toArray();

        if (!$jobId || count($skillIds) < 2) {
            throw new \Exception('Dữ liệu job hoặc skills chưa đủ để seed job_skill.');
        }

        DB::table('job_skill')->insert([
            [
                'job_id' => $jobId,
                'skill_id' => $skillIds[0],
                'priority_level' => 1,
                'required' => true,
                'created_at' => now(),
            ],
            [
                'job_id' => $jobId,
                'skill_id' => $skillIds[1],
                'priority_level' => 2,
                'required' => true,
                'created_at' => now(),
            ],
        ]);
    }
}
