<?php
// Migration: create_educations_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained()->onDelete('cascade');
            $table->string('school');
            $table->string('major')->nullable();
            $table->year('start_year')->nullable();
            $table->year('end_year')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};