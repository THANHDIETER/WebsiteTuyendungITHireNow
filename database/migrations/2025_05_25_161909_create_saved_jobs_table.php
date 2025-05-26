<?php
// File: database/migrations/2025_05_25_162036_create_saved_jobs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained('job_posts')->onDelete('cascade');
            $table->timestamp('saved_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_jobs');
    }
};