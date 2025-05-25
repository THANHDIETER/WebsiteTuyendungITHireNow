<?php
// File: database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UserProfileSeeder::class,
            CompanySeeder::class,
            ServicePackageSeeder::class,
            CvTemplateSeeder::class,
            JobTagSeeder::class,
            JobSeeder::class,
            ResumeSeeder::class,
            ExperienceSeeder::class,
            EducationSeeder::class,
            ProjectSeeder::class,
            LanguageSeeder::class,
            JobApplicationSeeder::class,
            JobTagMappingSeeder::class,
            JobViewSeeder::class,
            JobSuggestionSeeder::class,
            JobFavoriteSeeder::class,
            ChatThreadSeeder::class,
            ChatMessageSeeder::class,
            JobFeedbackSeeder::class,
            ExperienceRatingSeeder::class,
            NotificationSeeder::class,
            UserActivityLogSeeder::class,
            UserLoginHistorySeeder::class,
            PaymentSeeder::class,
            JobStatisticsSeeder::class,
            EmployerReviewSeeder::class,
            CompanyPositionSeeder::class,
        ]);
    }
}