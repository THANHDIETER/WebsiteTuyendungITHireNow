<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompaniesSeeder extends Seeder
{
    public static $companyId;

    public function run()
    {
        // Lấy user_id đúng từ bảng users dựa vào email (hoặc điều kiện phù hợp)
        $userId = DB::table('users')->where('email', 'employer@example.com')->value('id');

        if (!$userId) {
            throw new \Exception('User employer@example.com chưa tồn tại trong bảng users.');
        }

        $companyId = (string) Str::uuid();

        DB::table('companies')->insert([
            [
                'id' => $companyId,
                'user_id' => $userId,          // Dùng đúng user_id
                'name' => 'Công ty ABC',
                'slug' => 'cong-ty-abc',
                'email' => 'contact@abc.com',
                'logo_url' => 'https://example.com/logo.png',
                'cover_image_url' => 'https://example.com/cover.jpg',
                'website' => 'https://abc.com',
                'phone' => '0123456789',
                'address' => '123 Đường ABC, Quận 1, HCM',
                'city' => 'Hồ Chí Minh',
                'company_size' => '11-50',
                'founded_year' => 2010,
                'industry' => 'IT',
                'description' => 'Công ty chuyên về công nghệ thông tin.',
                'benefits' => json_encode(['Bảo hiểm', 'Thưởng cuối năm']),
                'is_verified' => true,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        self::$companyId = $companyId;
    }
}
