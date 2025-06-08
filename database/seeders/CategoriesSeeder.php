<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->updateOrInsert(
    ['slug' => Str::slug('Backend Developer')],
    [
        'name' => 'Backend Developer',
        'description' => 'Lập trình viên Backend',
        'icon_url' => null,
        'is_active' => true,
        'sort_order' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]
);

DB::table('categories')->updateOrInsert(
    ['slug' => Str::slug('Frontend Developer')],
    [
        'name' => 'Frontend Developer',
        'description' => 'Lập trình viên Frontend',
        'icon_url' => null,
        'is_active' => true,
        'sort_order' => 2,
        'created_at' => now(),
        'updated_at' => now(),
    ]
);

    }
}
