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

        // Admin cố định
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'password' => Hash::make('password'),
                'name' => 'Super Admin',
                'phone_number' => '0900000000',
                'role' => 'admin',
                'status' => 'active',
                'is_blocked' => false,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'referral_code' => strtoupper(Str::random(6)),
                'referred_by' => null,
                'ip_address' => '127.0.0.1',
            ]
        );

        // Employer cố định
        User::updateOrCreate(
            ['email' => 'employer@example.com'],
            [
                'password' => Hash::make('password'),
                'name' => 'Default Employer',
                'phone_number' => '0911111111',
                'role' => 'employer',
                'status' => 'active',
                'is_blocked' => false,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'referral_code' => strtoupper(Str::random(6)),
                'referred_by' => null,
                'ip_address' => '127.0.0.1',
            ]
        );

        User::updateOrCreate(
            ['email' => 'employerPackage@example.com'],
            [
                'password' => Hash::make('password'),
                'name' => 'Default Employer Package',
                'phone_number' => '0911222233',
                'role' => 'employer',
                'status' => 'active',
                'is_blocked' => false,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'referral_code' => strtoupper(Str::random(6)),
                'referred_by' => null,
                'ip_address' => '127.0.0.1',
            ]
        );

        // Job seeker cố định
        User::updateOrCreate(
            ['email' => 'jobseeker@example.com'],
            [
                'password' => Hash::make('password'),
                'name' => 'Default Job Seeker',
                'phone_number' => '0922222222',
                'role' => 'job_seeker',
                'status' => 'active',
                'is_blocked' => false,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'referral_code' => strtoupper(Str::random(6)),
                'referred_by' => null,
                'ip_address' => '127.0.0.1',
            ]
        );
    }
}
