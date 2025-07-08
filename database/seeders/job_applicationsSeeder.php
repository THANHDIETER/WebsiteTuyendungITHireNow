<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class job_applicationsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');

        // Lấy danh sách job_id, user_id và company_id có sẵn
        $jobIds = DB::table('jobs')->pluck('id');
        $userIds = DB::table('users')->pluck('id');
        $companyIds = DB::table('companies')->pluck('id');

        if ($jobIds->isEmpty() || $userIds->isEmpty() || $companyIds->isEmpty()) {
            throw new \Exception('Không đủ dữ liệu để tạo đơn ứng tuyển. Vui lòng chạy các seeder khác trước.');
        }

        // Tạo 20 đơn ứng tuyển mẫu
        for ($i = 1; $i <= 20; $i++) {
            $jobId = $faker->randomElement($jobIds);
            $userId = $faker->randomElement($userIds);
            $job = DB::table('jobs')->where('id', $jobId)->first();
            $companyId = $job->company_id;

            $status = $faker->randomElement(['pending']);
            $isShortlisted = $faker->boolean(30); // 30% cơ hội được shortlist
            $appliedAt = Carbon::now()->subDays($faker->numberBetween(1, 30));

            DB::table('job_applications')->insert([
                'job_id' => $jobId,
                'user_id' => $userId,
                'company_id' => $companyId,

                // BỔ SUNG TRƯỜNG THIẾT YẾU
                'full_name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),

                'image' => 'https://dvpro.vn/uploads/23-09-2024/298949d1-5fcc-4c70-a679-b9984f7666b6.gif',
                'cover_letter' => $faker->paragraph(3),
                'applied_at' => $appliedAt,
                'status' => $status,
                'is_shortlisted' => $isShortlisted,
                'source' => $faker->randomElement(['website', 'linkedin', 'indeed', 'email']),
                'interview_date' => $status === 'approved' ? Carbon::now()->addDays($faker->numberBetween(1, 14)) : null,
                'note' => $faker->optional(0.7)->paragraph(2),
                'created_at' => $appliedAt,
                'updated_at' => $appliedAt,
            ]);
        }
    }
}
