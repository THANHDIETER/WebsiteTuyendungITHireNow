<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Tạo danh sách referral codes trước để có thể sử dụng cho referred_by
        $referralCodes = [];

        for ($i = 1; $i <= 10; $i++) {
            $referral_code = strtoupper(Str::random(6));
            $referralCodes[] = $referral_code;

            User::create([
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'), // Mặc định mật khẩu là "password"
                'name' => $faker->name(),
                'phone_number' => $faker->phoneNumber(),
                'role' => $faker->randomElement(['admin', 'employer', 'job_seeker']),
                'status' => $faker->randomElement(['active', 'inactive', 'banned']),
                'is_blocked' => $faker->boolean(20), // 20% bị block
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'referral_code' => $referral_code,
                'referred_by' => $faker->optional()->randomElement($referralCodes),
                'ip_address' => $faker->ipv4(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }   
}
