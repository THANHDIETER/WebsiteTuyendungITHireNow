<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeekerProfilesSeeder extends Seeder
{
    public function run()
    {
        // Lấy user có role = job_seeker ngẫu nhiên
        $userId = DB::table('users')
            ->where('role', 'job_seeker')
            ->inRandomOrder()
            ->value('id');

        if (!$userId) {
            throw new \Exception('Không tìm thấy user nào có role là "job_seeker".');
        }

        DB::table('seeker_profiles')->insert([
            [
                'user_id' => $userId,
                'headline' => 'Backend developer with 3 years experience',
                'summary' => 'Experienced in PHP and Laravel development.',
                'cv_url' => 'https://example.com/cv.pdf',
                'linkedin_url' => 'https://linkedin.com/in/seeker',
                'github_url' => 'https://github.com/seeker',
                'portfolio_url' => 'https://portfolio.com/seeker',
                'location' => 'Hà Nội',
                'salary_expectation' => 15000000,
                'years_of_experience' => 3,
                'job_types' => 'full-time,remote',
                'language_skills' => 'English, Vietnamese',
                'education' => 'Bachelor of Computer Science',
                'work_experience' => 'Company ABC 2019-2022',
                'is_visible' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
