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
        $table->string('name')->nullable(); // tên mô tả logo
        $table->string('type')->default('site'); // loại logo: site, company, footer...
        $table->string('image_path'); // đường dẫn logo
        $table->boolean('is_active')->default(true); // logo đang được dùng?
        $table->timestamps();
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
