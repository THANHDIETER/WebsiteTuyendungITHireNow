<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Job;
use App\Models\User;

class ApplicationsSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = Job::inRandomOrder()->take(5)->pluck('id')->toArray();
        $seekers = User::where('role', 'job_seeker')->inRandomOrder()->take(5)->pluck('id')->toArray();

        if (empty($jobs) || empty($seekers)) {
            $this->command->warn('Không có đủ job hoặc seeker để seed ứng tuyển.');
            return;
        }

        $now = now();

        for ($i = 0; $i < 30; $i++) {
            DB::table('applications')->insert([
                'job_id' => $jobs[array_rand($jobs)],
                'user_id' => $seekers[array_rand($seekers)],
                'cv_url' => 'https://example.com/cv_' . Str::random(5) . '.pdf',
                'cover_letter' => 'Tôi rất quan tâm đến vị trí này.',
                'status' => ['pending', 'approved', 'rejected'][rand(0, 2)],
                'applied_at' => $now->copy()->subDays(rand(0, 60)),
                'is_shortlisted' => rand(0, 1),
                'source' => ['web', 'referral', 'mobile'][rand(0, 2)],
                'note' => rand(0, 1) ? 'Ứng viên tiềm năng.' : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
