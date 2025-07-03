<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('job_types')->insert([
    [
        'name' => 'Full-time',
        'slug' => 'full-time',
        'icon_class' => 'fa-solid fa-briefcase',
        'description' => 'Làm việc toàn thời gian 8h/ngày',
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Part-time',
        'slug' => 'part-time',
        'icon_class' => 'fa-solid fa-clock',
        'description' => 'Làm việc bán thời gian theo ca',
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Internship',
        'slug' => 'internship',
        'icon_class' => 'fa-solid fa-graduation-cap',
        'description' => 'Thực tập có thể có hỗ trợ',
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Remote',
        'slug' => 'remote',
        'icon_class' => 'fa-solid fa-house-laptop',
        'description' => 'Làm việc từ xa (remote)',
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

    }
}
