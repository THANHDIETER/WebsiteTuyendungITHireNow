<?php
// File: database/migrations/2025_05_25_161908_create_job_favorites_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained('job_posts')->onDelete('cascade');
            $table->timestamp('favorited_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_favorites');
    }
};