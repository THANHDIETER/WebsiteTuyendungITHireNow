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
        Schema::create('employer_package_orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
        $table->foreignId('employer_package_id')->constrained('employer_packages')->onDelete('cascade');
        $table->unsignedInteger('post_limit');
        $table->unsignedInteger('post_used')->default(0);
        $table->timestamp('start_date')->nullable();
        $table->timestamp('end_date')->nullable();
        $table->enum('status', ['active', 'expired', 'pending'])->default('pending');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations 2.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_package_orders');
    }
};
