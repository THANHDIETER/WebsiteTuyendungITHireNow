<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobExperienceSeeder extends Seeder
{
    public function run()
    {
        DB::table('job_experiences')->insert([
            ['name' => 'Không yêu cầu', 'is_active' => true],
            ['name' => 'Dưới 1 năm', 'is_active' => true],
            ['name' => '1 năm', 'is_active' => true],
            ['name' => '2 năm', 'is_active' => true],
            ['name' => '3 năm', 'is_active' => true],
            ['name' => '5 năm+', 'is_active' => true],
        ]);
    }
}
