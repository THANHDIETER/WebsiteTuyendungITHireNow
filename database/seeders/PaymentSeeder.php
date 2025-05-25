<?php
// File: database/seeders/PaymentSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $packageIds = DB::table('service_packages')->pluck('id')->toArray();
        for ($i = 0; $i < 20; $i++) {
            DB::table('payments')->insert([
                'user_id' => $faker->randomElement($userIds),
                'package_id' => $faker->randomElement($packageIds),
                'amount' => $faker->randomFloat(2, 10, 100),
                'payment_method' => $faker->randomElement(['VNPAY', 'Momo', 'bank_card']),
                'status' => $faker->randomElement(['pending', 'completed', 'failed']),
                'paid_at' => now(),
            ]);
        }
    }
}