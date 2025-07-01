<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class JobsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');

        $nd = collect([
            '<h3>' . $faker->sentence . '</h3>',
            '<p>' . $faker->paragraph(5, true) . '</p>',
            '<p>' . $faker->paragraph(4, true) . '</p>',
            '<h4>' . $faker->sentence(4) . '</h4>',
            '<ul>' . collect(range(1, 4))->map(fn () => '<li>' . $faker->sentence(10) . '</li>')->implode('') . '</ul>',
            '<h4>Trách nhiệm</h4>',
            '<ol>' . collect(range(1, 5))->map(fn () => '<li>' . $faker->sentence(12) . '</li>')->implode('') . '</ol>',
            '<h4>Kỹ năng cần có</h4>',
            '<ul>' . collect(range(1, 3))->map(fn () => '<li>' . $faker->sentence(8) . '</li>')->implode('') . '</ul>',
            '<p><strong>Ghi chú:</strong> ' . $faker->sentence(15) . '</p>',
        ])->implode("\n");
        $companyIds       = DB::table('companies')->pluck('id');
        $categoryIds      = DB::table('categories')->pluck('id');
        $skillIds         = DB::table('skills')->pluck('id');
        $levelIds         = DB::table('levels')->pluck('id');
        $experienceIds    = DB::table('job_experiences')->pluck('id');
        $languageIds      = DB::table('job_languages')->pluck('id');
        $remotePolicyIds  = DB::table('remote_policies')->pluck('id');
        $locationIds      = DB::table('locations')->pluck('id');
        $jobTypeIds       = DB::table('job_types')->pluck('id');
        for ($i = 1; $i <= 20; $i++) {
            $title = $faker->jobTitle;
            $slug = Str::slug($title) . '-' . $i;

            // Mức lương và hiển thị
            $salaryMin = $faker->numberBetween(8000000, 15000000);
            $salaryMax = $faker->numberBetween(15000000, 30000000);
            $isNegotiable = $faker->boolean(20);

            if ($isNegotiable) {
                $salaryDisplay = 'Lương thương lượng';
            } elseif ($salaryMin && $salaryMax) {
                $salaryDisplay = number_format($salaryMin) . ' - ' . number_format($salaryMax) . ' VND';
            } elseif ($salaryMin) {
                $salaryDisplay = 'Từ ' . number_format($salaryMin) . ' VND';
            } elseif ($salaryMax) {
                $salaryDisplay = 'Up to ' . number_format($salaryMax) . ' VND';
            } else {
                $salaryDisplay = 'Thoả thuận';
            }

            $jobId = DB::table('jobs')->insertGetId([
                'company_id'         => $faker->randomElement($companyIds),
                'title'              => $title,
                'slug'               => $slug,
                'description'        => $nd,
                'requirements'       => $faker->sentence(10),
                'benefits'           => json_encode([$faker->catchPhrase, $faker->bs]),
                'job_type_id'        => $jobTypeIds->isNotEmpty() ? $jobTypeIds->random() : null,
                'salary_min'         => $salaryMin,
                'salary_max'         => $salaryMax,
                'currency'           => 'VND',
                'salary_negotiable'  => $isNegotiable,
                'salary_display'     => $salaryDisplay,
                'location_id'        => $locationIds->isNotEmpty() ? $locationIds->random() : null,
                'address'            => $faker->address,
                'level_id'           => $levelIds->isNotEmpty() ? $levelIds->random() : null,
                'experience_id'      => $experienceIds->isNotEmpty() ? $experienceIds->random() : null,
                'language_id'        => $languageIds->isNotEmpty() ? $languageIds->random() : null,
                'remote_policy_id'   => $remotePolicyIds->isNotEmpty() ? $remotePolicyIds->random() : null,
                'deadline'           => Carbon::now()->addDays(rand(15, 60)),
                'status'             => 'pending',
                'views'              => rand(0, 200),
                'is_featured'        => $faker->boolean(30),
                'is_paid'            => $faker->boolean(50),
                'meta_title'         => $title,
                'meta_description'   => $faker->paragraph(2),
                'keyword'            => implode(', ', $faker->words(5)),
                'search_index'       => true,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // Gắn kỹ năng nếu có
            if ($skillIds->count() > 0) {
                $maxSkills = min($skillIds->count(), rand(2, 4));
                DB::table('job_skill')->insert(
                    $skillIds->random($maxSkills)->map(function ($skillId) use ($jobId) {
                        return [
                            'job_id'     => $jobId,
                            'skill_id'   => $skillId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    })->toArray()
                );
            }
        }
    }
}
