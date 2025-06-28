<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employer_package_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('employer_package_orders')->onDelete('cascade');
            $table->foreignId('job_id')->nullable()->constrained('jobs')->onDelete('cascade');
            $table->timestamp('used_at')->useCurrent();
            $table->string('action')->default('post_job'); // Các action: post_job, highlight, cv_view...
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_package_logs');
    }
};
