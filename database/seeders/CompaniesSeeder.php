<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CompaniesSeeder extends Seeder
{
    public static $companyId;

    public function run()
    {
        $faker = Faker::create('vi_VN');

        // Lấy user có role employer ngẫu nhiên
        $userId = DB::table('users')
            ->where('role', 'employer')
            ->inRandomOrder()
            ->value('id');

        if (!$userId) {
            throw new \Exception('Không tìm thấy người dùng nào có vai trò "employer".');
        }

        $companyName = $faker->company;

        $companyId = DB::table('companies')->insertGetId([
            'user_id'          => $userId,
            'name'             => $companyName,
            'slug'             => Str::slug($companyName) . '-' . Str::random(5), // đảm bảo slug không trùng
            'email'            => $faker->companyEmail,
            'logo_url'         => $faker->imageUrl(200, 200, 'business'),
            'cover_image_url'  => $faker->imageUrl(1200, 300, 'city'),
            'website'          => $faker->url,
            'phone'            => $faker->phoneNumber,
            'address'          => $faker->address,
            'city'             => $faker->city,
            'company_size'     => $faker->randomElement(['1-10', '11-50', '51-200', '201-500']),
            'founded_year'     => $faker->year,
            'industry'         => $faker->randomElement(['IT', 'Finance', 'Education', 'Retail']),
            'description'      => $faker->paragraph,
            'benefits'         => json_encode($faker->randomElements(['Bảo hiểm', 'Du lịch', 'Thưởng quý', 'Đào tạo'], 2)),
            'is_verified'      => true,
            'status'           => 'active',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        self::$companyId = $companyId;
    }
}
