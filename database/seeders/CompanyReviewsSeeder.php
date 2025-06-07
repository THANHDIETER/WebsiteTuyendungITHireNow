<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyReviewsSeeder extends Seeder
{
    public function run()
    {
        // Lấy company_id ngẫu nhiên từ bảng companies
        $companyId = DB::table('companies')
            ->inRandomOrder()
            ->value('id');

        if (!$companyId) {
            throw new \Exception('Không tìm thấy công ty nào trong bảng companies.');
        }

        // Lấy user_id có role là job_seeker ngẫu nhiên
        $userId = DB::table('users')
            ->where('role', 'job_seeker')
            ->inRandomOrder()
            ->value('id');

        if (!$userId) {
            throw new \Exception('Không tìm thấy user nào có role là "job_seeker".');
        }

        DB::table('company_reviews')->insert([
            [
                'company_id' => $companyId,
                'user_id' => $userId,
                'rating' => 5,
                'title' => 'Great working environment',
                'content' => 'I enjoyed working at this company for 3 years.',
                'pros' => 'Friendly colleagues, flexible hours',
                'cons' => 'Occasional overtime',
                'position' => 'Backend Developer',
                'employment_type' => 'full-time',
                'worked_year' => '2019-2022',
                'is_anonymous' => false,
                'is_approved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
