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
        Schema::create('logos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Tên mô tả logo
            $table->enum('type', ['header', 'footer', 'client', 'admin'])->default('header'); // Phân loại logo
            $table->string('image_path'); // Đường dẫn logo (trong storage/public)
            $table->boolean('is_active')->default(true); // Có đang được sử dụng không
            $table->timestamps();

            $table->index(['type', 'is_active']); // Index giúp truy vấn nhanh hơn
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logos');
    }
};
