<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalariesSeeder extends Seeder
{
    public function run()
    {
        DB::table('salaries')->insert([
            [
                'range_label' => '$500 - $1000',
                'min_salary' => 500,
                'max_salary' => 1000,
                'currency' => 'USD',
                'is_custom' => false,
                'display_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'range_label' => 'Negotiable',
                'min_salary' => 0,
                'max_salary' => 0,
                'currency' => 'USD',
                'is_custom' => true,
                'display_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
