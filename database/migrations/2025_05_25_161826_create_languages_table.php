<?php
// Migration: create_languages_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained()->onDelete('cascade');
            $table->string('language_name');
            $table->enum('proficiency', ['beginner', 'intermediate', 'advanced', 'native']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};