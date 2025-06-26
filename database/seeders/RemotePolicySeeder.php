<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemotePolicySeeder extends Seeder
{
    public function run()
    {
        DB::table('remote_policies')->insert([
            ['name' => 'Onsite'],
            ['name' => 'Remote'],
            ['name' => 'Hybrid'],
        ]);
    }
}
