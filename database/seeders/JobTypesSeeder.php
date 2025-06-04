<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('job_types')->insert([
            ['name' => 'Full-time', 'slug' => 'full-time', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Part-time', 'slug' => 'part-time', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Internship', 'slug' => 'internship', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Remote', 'slug' => 'remote', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
