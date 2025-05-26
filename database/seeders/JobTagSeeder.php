<?php
// File: database/seeders/JobTagSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'ReactJS'],
            ['name' => 'Backend'],
            ['name' => 'Remote'],
            ['name' => 'Full-time'],
            ['name' => 'Python'],
        ];
        DB::table('job_tags')->insert($tags);
    }
}