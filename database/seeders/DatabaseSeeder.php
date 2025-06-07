<?php

use Illuminate\Database\Seeder;
use Database\Seeders\JobsSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\SkillsSeeder;
use Database\Seeders\BannersSeeder;
use Database\Seeders\ReportsSeeder;
use Database\Seeders\JobSkillSeeder;
use Database\Seeders\PaymentsSeeder;
use Database\Seeders\SalariesSeeder;
use Database\Seeders\AdminLogsSeeder;
use Database\Seeders\CompaniesSeeder;
use Database\Seeders\FavoritesSeeder;
use Database\Seeders\LocationsSeeder;
use Database\Seeders\UserRolesSeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\EducationsSeeder;
use Database\Seeders\ExperiencesSeeder;
use Database\Seeders\ApplicationsSeeder;
use Database\Seeders\NotificationsSeeder;
use Database\Seeders\CompanyReviewsSeeder;
use Database\Seeders\SeekerProfilesSeeder;
use Database\Seeders\EmployerPackagesSeeder;

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
            ReportsSeeder::class,
            ApplicationsSeeder::class,
        ]);
    }
}
