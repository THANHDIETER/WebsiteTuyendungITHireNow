<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_languages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // VD: 'Tiếng Việt', 'English', 'Song ngữ'
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_languages');
    }
};
