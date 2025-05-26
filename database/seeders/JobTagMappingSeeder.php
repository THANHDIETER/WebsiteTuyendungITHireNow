<?php
// File: database/seeders/JobTagMappingSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobTagMappingSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $jobIds = DB::table('job_posts')->pluck('id')->toArray();
        $tagIds = DB::table('job_tags')->pluck('id')->toArray();

        foreach ($jobIds as $jobId) {
            // Chọn ngẫu nhiên 1-3 tag_id không trùng lặp
            $selectedTagIds = $faker->randomElements($tagIds, rand(1, min(3, count($tagIds))));
            foreach ($selectedTagIds as $tagId) {
                // Kiểm tra xem cặp job_id, tag_id đã tồn tại chưa
                if (!DB::table('job_tag_mappings')->where('job_id', $jobId)->where('tag_id', $tagId)->exists()) {
                    DB::table('job_tag_mappings')->insert([
                        'job_id' => $jobId,
                        'tag_id' => $tagId,
                    ]);
                }
            }
        }
    }
}