<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
{
    public function run()
    {
        // Lấy user_id hợp lệ (ví dụ: người dùng employer)
        $userId = DB::table('users')->where('role', 'employer')->value('id');
        if (!$userId) {
            throw new \Exception('Không tìm thấy user employer trong bảng users.');
        }

        // Lấy package_id hợp lệ
        $packageId = DB::table('employer_packages')->value('id');
        if (!$packageId) {
            throw new \Exception('Bảng employer_packages chưa có dữ liệu.');
        }

        DB::table('payments')->insert([
            [
                'user_id' => $userId,
                'package_id' => $packageId,
                'amount' => 1000000,
                'currency' => 'VND',
                'invoice_number' => 'INV0001',
                'payment_method' => 'VNPAY',
                'payment_gateway' => 'VNPAY',
                'transaction_id' => 'TXN0001',
                'status' => 'paid',
                'vat_percent' => 10,
                'paid_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

