<?php
// Migration: create_companies_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('location')->nullable();
            $table->string('industry')->nullable();
            $table->string('logo_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};