<?php
// Migration: create_cv_templates_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cv_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_url');
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_templates');
    }
};