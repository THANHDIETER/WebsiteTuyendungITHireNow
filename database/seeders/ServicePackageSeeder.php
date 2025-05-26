<?php
// File: database/seeders/ServicePackageSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicePackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            ['name' => 'Basic', 'duration_days' => 30, 'price' => 10.00, 'features' => 'Basic job posting'],
            ['name' => 'Premium', 'duration_days' => 90, 'price' => 50.00, 'features' => 'Premium job posting, analytics'],
            ['name' => 'Enterprise', 'duration_days' => 180, 'price' => 100.00, 'features' => 'Full features, priority support'],
        ];
        DB::table('service_packages')->insert($packages);
    }
}