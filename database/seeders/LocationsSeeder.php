<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationsSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            ['name' => 'Hà Nội', 'region' => 'Bắc', 'lat' => 21.028511, 'lng' => 105.804817],
            ['name' => 'Hồ Chí Minh', 'region' => 'Nam', 'lat' => 10.762622, 'lng' => 106.660172],
            ['name' => 'Đà Nẵng', 'region' => 'Trung', 'lat' => 16.047079, 'lng' => 108.206230],
            ['name' => 'Hải Phòng', 'region' => 'Bắc', 'lat' => 20.844911, 'lng' => 106.688084],
            ['name' => 'Cần Thơ', 'region' => 'Nam', 'lat' => 10.045162, 'lng' => 105.746857],
            ['name' => 'An Giang', 'region' => 'Nam', 'lat' => 10.521583, 'lng' => 105.125895],
            ['name' => 'Bà Rịa - Vũng Tàu', 'region' => 'Nam', 'lat' => 10.541739, 'lng' => 107.242997],
            ['name' => 'Bắc Giang', 'region' => 'Bắc', 'lat' => 21.281992, 'lng' => 106.197476],
            ['name' => 'Bắc Kạn', 'region' => 'Bắc', 'lat' => 22.147016, 'lng' => 105.834817],
            ['name' => 'Bạc Liêu', 'region' => 'Nam', 'lat' => 9.294002, 'lng' => 105.727760],
            ['name' => 'Bắc Ninh', 'region' => 'Bắc', 'lat' => 21.186895, 'lng' => 106.076312],
            ['name' => 'Bến Tre', 'region' => 'Nam', 'lat' => 10.241471, 'lng' => 106.375542],
            ['name' => 'Bình Định', 'region' => 'Trung', 'lat' => 13.782020, 'lng' => 109.219663],
            ['name' => 'Bình Dương', 'region' => 'Nam', 'lat' => 10.980524, 'lng' => 106.651082],
            ['name' => 'Bình Phước', 'region' => 'Nam', 'lat' => 11.751189, 'lng' => 106.723463],
            ['name' => 'Bình Thuận', 'region' => 'Trung', 'lat' => 11.090370, 'lng' => 108.072078],
            ['name' => 'Cà Mau', 'region' => 'Nam', 'lat' => 9.176755, 'lng' => 105.150711],
            ['name' => 'Cao Bằng', 'region' => 'Bắc', 'lat' => 22.665684, 'lng' => 106.257015],
            ['name' => 'Đắk Lắk', 'region' => 'Trung', 'lat' => 12.710011, 'lng' => 108.237751],
            ['name' => 'Đắk Nông', 'region' => 'Trung', 'lat' => 12.264647, 'lng' => 107.609806],
            ['name' => 'Điện Biên', 'region' => 'Bắc', 'lat' => 21.392222, 'lng' => 103.023013],
            ['name' => 'Đồng Nai', 'region' => 'Nam', 'lat' => 11.028363, 'lng' => 107.025718],
            ['name' => 'Đồng Tháp', 'region' => 'Nam', 'lat' => 10.493798, 'lng' => 105.688178],
            ['name' => 'Gia Lai', 'region' => 'Trung', 'lat' => 13.807894, 'lng' => 108.109375],
            ['name' => 'Hà Giang', 'region' => 'Bắc', 'lat' => 22.823333, 'lng' => 104.983056],
            ['name' => 'Hà Nam', 'region' => 'Bắc', 'lat' => 20.541112, 'lng' => 105.922990],
            ['name' => 'Hà Tĩnh', 'region' => 'Trung', 'lat' => 18.342825, 'lng' => 105.905693],
            ['name' => 'Hậu Giang', 'region' => 'Nam', 'lat' => 9.757898, 'lng' => 105.641252],
            ['name' => 'Hòa Bình', 'region' => 'Bắc', 'lat' => 20.852571, 'lng' => 105.337593],
            ['name' => 'Hưng Yên', 'region' => 'Bắc', 'lat' => 20.646204, 'lng' => 106.051072],
            ['name' => 'Khánh Hòa', 'region' => 'Trung', 'lat' => 12.258509, 'lng' => 109.052607],
            ['name' => 'Kiên Giang', 'region' => 'Nam', 'lat' => 10.012384, 'lng' => 105.080933],
            ['name' => 'Kon Tum', 'region' => 'Trung', 'lat' => 14.354523, 'lng' => 108.007591],
            ['name' => 'Lai Châu', 'region' => 'Bắc', 'lat' => 22.396428, 'lng' => 103.458745],
            ['name' => 'Lâm Đồng', 'region' => 'Trung', 'lat' => 11.575279, 'lng' => 108.142866],
            ['name' => 'Lạng Sơn', 'region' => 'Bắc', 'lat' => 21.845729, 'lng' => 106.761519],
            ['name' => 'Lào Cai', 'region' => 'Bắc', 'lat' => 22.480943, 'lng' => 103.979007],
            ['name' => 'Long An', 'region' => 'Nam', 'lat' => 10.535351, 'lng' => 106.413664],
            ['name' => 'Nam Định', 'region' => 'Bắc', 'lat' => 20.438822, 'lng' => 106.162105],
            ['name' => 'Nghệ An', 'region' => 'Trung', 'lat' => 19.234249, 'lng' => 104.920037],
            ['name' => 'Ninh Bình', 'region' => 'Bắc', 'lat' => 20.250614, 'lng' => 105.974453],
            ['name' => 'Ninh Thuận', 'region' => 'Trung', 'lat' => 11.673419, 'lng' => 108.990435],
            ['name' => 'Phú Thọ', 'region' => 'Bắc', 'lat' => 21.268443, 'lng' => 105.204557],
            ['name' => 'Phú Yên', 'region' => 'Trung', 'lat' => 13.088186, 'lng' => 109.092876],
            ['name' => 'Quảng Bình', 'region' => 'Trung', 'lat' => 17.610271, 'lng' => 106.348747],
            ['name' => 'Quảng Nam', 'region' => 'Trung', 'lat' => 15.539353, 'lng' => 108.019093],
            ['name' => 'Quảng Ngãi', 'region' => 'Trung', 'lat' => 15.121387, 'lng' => 108.804414],
            ['name' => 'Quảng Ninh', 'region' => 'Bắc', 'lat' => 21.006382, 'lng' => 107.292514],
            ['name' => 'Quảng Trị', 'region' => 'Trung', 'lat' => 16.816827, 'lng' => 107.101194],
            ['name' => 'Sóc Trăng', 'region' => 'Nam', 'lat' => 9.602521, 'lng' => 105.973904],
            ['name' => 'Sơn La', 'region' => 'Bắc', 'lat' => 21.325518, 'lng' => 103.918217],
            ['name' => 'Tây Ninh', 'region' => 'Nam', 'lat' => 11.356609, 'lng' => 106.098902],
            ['name' => 'Thái Bình', 'region' => 'Bắc', 'lat' => 20.446347, 'lng' => 106.336065],
            ['name' => 'Thái Nguyên', 'region' => 'Bắc', 'lat' => 21.592771, 'lng' => 105.844160],
            ['name' => 'Thanh Hóa', 'region' => 'Trung', 'lat' => 19.806692, 'lng' => 105.785181],
            ['name' => 'Thừa Thiên Huế', 'region' => 'Trung', 'lat' => 16.463713, 'lng' => 107.590866],
            ['name' => 'Tiền Giang', 'region' => 'Nam', 'lat' => 10.449332, 'lng' => 106.342051],
            ['name' => 'Trà Vinh', 'region' => 'Nam', 'lat' => 9.812741, 'lng' => 106.345902],
            ['name' => 'Tuyên Quang', 'region' => 'Bắc', 'lat' => 21.823460, 'lng' => 105.218023],
            ['name' => 'Vĩnh Long', 'region' => 'Nam', 'lat' => 10.253784, 'lng' => 105.972047],
            ['name' => 'Vĩnh Phúc', 'region' => 'Bắc', 'lat' => 21.308760, 'lng' => 105.604921],
            ['name' => 'Yên Bái', 'region' => 'Bắc', 'lat' => 21.705942, 'lng' => 104.888077],
        ];

        foreach ($locations as $loc) {
            DB::table('locations')->updateOrInsert(
                ['slug' => Str::slug($loc['name'])],
                [
                    'name' => $loc['name'],
                    'region' => $loc['region'],
                    'country_code' => 'VN',
                    'latitude' => $loc['lat'],
                    'longitude' => $loc['lng'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
