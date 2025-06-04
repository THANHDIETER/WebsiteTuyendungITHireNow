<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyReviewsSeeder extends Seeder
{
    public function run()
    {
        // Lấy company_id dựa theo slug hoặc tên công ty
        $companyId = DB::table('companies')->where('slug', 'cong-ty-abc')->value('id');

        if (!$companyId) {
            throw new \Exception('Công ty ABC chưa tồn tại trong bảng companies.');
        }

        // Lấy user_id dựa theo email
        $userId = DB::table('users')->where('email', 'seeker@example.com')->value('id');

        if (!$userId) {
            throw new \Exception('User seeker@example.com chưa tồn tại trong bảng users.');
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
