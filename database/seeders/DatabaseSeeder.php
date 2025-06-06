<?php

namespace Database\Seeders;

use Database\Seeders\AdminLogsSeeder;
use Database\Seeders\BannersSeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\CompaniesSeeder;
use Database\Seeders\CompanyReviewsSeeder;
use Database\Seeders\EducationsSeeder;
use Database\Seeders\EmployerPackagesSeeder;
use Database\Seeders\ExperiencesSeeder;
use Database\Seeders\FavoritesSeeder;
use Database\Seeders\JobSkillSeeder;
use Database\Seeders\JobsSeeder;
use Database\Seeders\LocationsSeeder;
use Database\Seeders\NotificationsSeeder;
use Database\Seeders\PaymentsSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\SalariesSeeder;
use Database\Seeders\SeekerProfilesSeeder;
use Database\Seeders\SkillsSeeder;
use Database\Seeders\UserRolesSeeder;
use Database\Seeders\UsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            CategoriesSeeder::class,
            SkillsSeeder::class,
            LocationsSeeder::class,
            SalariesSeeder::class,
            CompaniesSeeder::class,  // CompaniesSeeder trước
            JobsSeeder::class,       // JobsSeeder sau
            JobSkillSeeder::class,
            SeekerProfilesSeeder::class,
            CompanyReviewsSeeder::class,
            NotificationsSeeder::class,
            FavoritesSeeder::class,
            EmployerPackagesSeeder::class,
            PaymentsSeeder::class,
            AdminLogsSeeder::class,
            BannersSeeder::class,
            EducationsSeeder::class,
            ExperiencesSeeder::class,
            UserRolesSeeder::class,  // Gọi đúng tên seeder
        ]);
    }
}
