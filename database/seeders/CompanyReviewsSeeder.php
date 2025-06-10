<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CompanyReviewsSeeder extends Seeder
{
    public function run()
    {
        $companies = DB::table('companies')->pluck('id');
        $users = DB::table('users')->where('role', 'job_seeker')->pluck('id');

        if ($companies->isEmpty() || $users->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 10; $i++) {
            DB::table('company_reviews')->insert([
                'company_id' => $companies->random(),
                'user_id' => $users->random(),
                'rating' => rand(3, 5),
                'title' => 'Review tiêu đề ' . $i,
                'content' => 'Nội dung đánh giá công ty mẫu ' . $i,
                'pros' => 'Ưu điểm: môi trường tốt, đồng nghiệp thân thiện.',
                'cons' => 'Nhược điểm: áp lực deadline.',
                'position' => 'Developer',
                'employment_type' => 'Full-time',
                'worked_year' => rand(2018, 2024),
                'is_anonymous' => rand(0, 1),
                'is_approved' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
