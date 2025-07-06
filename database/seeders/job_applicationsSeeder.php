<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobApplication;
use App\Models\Job;
use App\Models\User;
use App\Models\Company;
use Faker\Factory as Faker;
use Carbon\Carbon;

class job_applicationsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');

       

        $jobIds = Job::pluck('id');
        $userIds = User::pluck('id');

        if ($jobIds->isEmpty() || $userIds->isEmpty()) {
            throw new \Exception('Cần seed bảng jobs và users trước khi seed job_applications.');
        }

        for ($i = 1; $i <= 20; $i++) {
            $job = Job::inRandomOrder()->first();
            $user = User::inRandomOrder()->first();

            $status = $faker->randomElement(['pending']);
            $isShortlisted = $faker->boolean(30);
            $appliedAt = Carbon::now()->subDays(rand(1, 30));

            JobApplication::create([
                'job_id' => $job->id,
                'user_id' => $user->id,
                'company_id' => $job->company_id,

                'full_name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),

                'image' => 'https://dvpro.vn/uploads/23-09-2024/298949d1-5fcc-4c70-a679-b9984f7666b6.gif',
                'cover_letter' => $faker->paragraph(3),
                'applied_at' => $appliedAt,
                'status' => $status,
                'is_shortlisted' => $isShortlisted,
                'source' => $faker->randomElement(['website', 'linkedin', 'email', 'referral']),
                'interview_date' => $status === 'approved' ? Carbon::now()->addDays(rand(1, 14)) : null,
                'note' => $faker->optional()->paragraph(),

                'created_at' => $appliedAt,
                'updated_at' => $appliedAt,
            ]);
        }
    }
}
