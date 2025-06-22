<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'name' => 'Thuế VAT (%)',
                'key' => 'vat_rate',
                'value' => '10',
            ],
            [
                'name' => 'Loại Nội dung chuyển khoản',
                'key' => 'random_mode',
                'value' => 'alphanum',
            ],
            [
                'name' => 'Độ dài nội dung chuyển khoản',
                'key' => 'random_length',
                'value' => '12',
            ],
            [
                'name' => 'Tiền tố nội dung chuyển khoản',
                'key' => 'random_prefix',
                'value' => 'NAP-',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['name' => $setting['name'], 'value' => $setting['value']]
            );
        }
    }
}
