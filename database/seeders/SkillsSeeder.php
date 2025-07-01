<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SkillsSeeder extends Seeder
{
    public function run()
    {
        $userId = 1; // Hoặc gán từ logic phù hợp

        DB::table('skills')->updateOrInsert(
            [
                'user_id' => $userId,
                'skill_name' => 'PHP',
            ],
            [
                'group_name' => 'hard_skills',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('skills')->updateOrInsert(
            [
                'user_id' => $userId,
                'skill_name' => 'Laravel',
            ],
            [
                'group_name' => 'hard_skills',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}