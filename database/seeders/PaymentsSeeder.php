<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentsSeeder extends Seeder
{
    public function run()
    {
        // Lấy danh sách employer_id và package_id hợp lệ
        $employers = DB::table('users')->where('role', 'employer')->pluck('id')->toArray();
        $packages = DB::table('employer_packages')->pluck('id')->toArray();

        if (empty($employers)) {
            throw new \Exception('Không tìm thấy user employer trong bảng users.');
        }

        if (empty($packages)) {
            throw new \Exception('Bảng employer_packages chưa có dữ liệu.');
        }

        $methods = ['VNPAY', 'MOMO', 'BANK', 'CREDIT_CARD'];
        $statuses = ['paid', 'pending', 'failed'];

        $payments = [];

        for ($i = 1; $i <= 10; $i++) {
            $payments[] = [
                'user_id' => $employers[array_rand($employers)],
                'package_id' => $packages[array_rand($packages)],
                'amount' => rand(500000, 5000000),
                'currency' => 'VND',
                'invoice_number' => 'INV' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'payment_method' => $methods[array_rand($methods)],
                'payment_gateway' => $methods[array_rand($methods)],
                'transaction_id' => 'TXN' . strtoupper(Str::random(6)),
                'status' => $statuses[array_rand($statuses)],
                'vat_percent' => rand(5, 10),
                'paid_at' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('payments')->insert($payments);
    }
}
