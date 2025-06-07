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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // Đối tượng bị báo cáo (đa hình)
            $table->string('target_type', 50);
            $table->unsignedBigInteger('target_id');
            $table->index(['target_type', 'target_id']);

            // Người báo cáo
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');

            // Nội dung báo cáo
            $table->string('reason_code', 50);
            $table->text('message')->nullable();

            // Trạng thái xử lý
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('admin_note')->nullable();
            $table->timestamp('seen_at')->nullable();

            // Thông tin kỹ thuật
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
