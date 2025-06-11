<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employer_package_usages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->constrained()->onDelete('cascade');
        $table->foreignId('employer_package_id')->constrained('employer_packages')->onDelete('cascade');
        $table->integer('post_limit')->default(0);       // Số lượt đăng tối đa (theo gói)
        $table->integer('posts_used')->default(0);       // Số lượt đã sử dụng
        $table->dateTime('start_date');
        $table->dateTime('end_date')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_package_usages');
    }
};
