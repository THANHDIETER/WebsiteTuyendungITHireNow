<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('job_languages')->insert([
            ['name' => 'Tiếng Việt'],
            ['name' => 'Tiếng Anh'],
            ['name' => 'Song ngữ'],
            ['name' => 'Khác'],
        ]);

    }
}
