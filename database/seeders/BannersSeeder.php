<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannersSeeder extends Seeder
{
    public function run()
    {
        DB::table('banners')->insert([
            [
                'title' => 'Banner quảng cáo 1',
                'image_url' => 'https://example.com/banner1.jpg',
                'link_url' => 'https://example.com',
                'position' => 'homepage_top',
                'display_order' => 1,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonth()->toDateString(),
                'click_count' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
