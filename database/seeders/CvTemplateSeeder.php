<?php
// File: database/seeders/CvTemplateSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CvTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            ['template_url' => '/templates/basic.pdf', 'name' => 'Basic CV'],
            ['template_url' => '/templates/modern.pdf', 'name' => 'Modern CV'],
            ['template_url' => '/templates/professional.pdf', 'name' => 'Professional CV'],
        ];
        DB::table('cv_templates')->insert($templates);
    }
}