<?php
// File: database/migrations/2025_05_25_161844_create_job_tag_mappings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_tag_mappings', function (Blueprint $table) {
            $table->foreignId('job_id')->constrained('job_posts')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('job_tags')->onDelete('cascade');
            $table->primary(['job_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_tag_mappings');
    }
};