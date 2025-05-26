<?php
// File: database/seeders/ChatMessageSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ChatMessageSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $threadIds = DB::table('chat_threads')->pluck('id')->toArray();
        foreach ($threadIds as $threadId) {
            $thread = DB::table('chat_threads')->find($threadId);
            for ($i = 0; $i < rand(2, 10); $i++) {
                DB::table('chat_messages')->insert([
                    'thread_id' => $threadId,
                    'sender_id' => $faker->randomElement([$thread->employer_id, $thread->job_seeker_id]),
                    'receiver_id' => $faker->randomElement([$thread->employer_id, $thread->job_seeker_id]),
                    'message' => $faker->sentence,
                    'sent_at' => now(),
                ]);
            }
        }
    }
}
