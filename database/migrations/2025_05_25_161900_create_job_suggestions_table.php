<?php
// File: database/migrations/2025_05_25_161900_create_job_suggestions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained('job_posts')->onDelete('cascade');
            $table->decimal('score', 5, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_suggestions');
    }
};