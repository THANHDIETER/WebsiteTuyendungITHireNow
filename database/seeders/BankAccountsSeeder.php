<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankAccount;

class BankAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BankAccount::create([
            'bank' => 'Momo',
            'branch' => 'Lạng sơn',
            'account_number' => '0971810376',
            'account_name' => 'NGUYEN THANH TU',
            'token' => 'acp',
            'password' => '',
            'is_active' => false,
            'image' => '',
        ]);

        BankAccount::create([
            'bank' => 'MBbank',
            'branch' => 'Lạng sơn',
            'account_number' => '0971810376',
            'account_name' => 'NGUYEN THANH TU',
            'token' => 'acp',
            'password' => '',
            'is_active' => false,
            'image' => '',
        ]);

        BankAccount::create([
            'bank' => 'ACB',
            'branch' => 'Lạng sơn',
            'account_number' => '4729781',
            'account_name' => 'NGUYEN THANH TU',
            'token' => 'acp',
            'password' => '',
            'is_active' => false,
            'image' => '',
        ]);
    }
}
