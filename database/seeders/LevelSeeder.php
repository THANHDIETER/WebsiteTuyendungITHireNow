<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run()
    {
        DB::table('levels')->insert([
            ['name' => 'Intern'],
            ['name' => 'Junior'],
            ['name' => 'Middle'],
            ['name' => 'Senior'],
            ['name' => 'Lead'],
            ['name' => 'Manager'],
        ]);
    }
}
