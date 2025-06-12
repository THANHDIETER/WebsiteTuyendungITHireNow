<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsSeeder extends Seeder
{
    public function run()
    {
       DB::table('skills')->updateOrInsert(
            ['slug' => 'php'],
            [
                'name' => 'PHP',
                'description' => 'Ngôn ngữ lập trình PHP',
                'category_id' => 1,
                'is_active' => true,
                'proficiency_level' => 'advanced',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('skills')->updateOrInsert(
            ['slug' => 'laravel'],
            [
                'name' => 'Laravel',
                'description' => 'Framework PHP Laravel',
                'category_id' => 1,
                'is_active' => true,
                'proficiency_level' => 'advanced',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
