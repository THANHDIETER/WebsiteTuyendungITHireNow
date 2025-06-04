<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    public function run()
    {
        DB::table('locations')->insert([
            [
                'name' => 'Hà Nội',
                'slug' => 'ha-noi',
                'region' => 'Bắc',
                'country_code' => 'VN',
                'latitude' => 21.028511,
                'longitude' => 105.804817,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hồ Chí Minh',
                'slug' => 'ho-chi-minh',
                'region' => 'Nam',
                'country_code' => 'VN',
                'latitude' => 10.762622,
                'longitude' => 106.660172,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
