<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng interview_responses để lưu phản hồi của ứng viên
     */
    public function up(): void
    {
        Schema::create('interview_responses', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại liên kết đến bảng interviews
            $table->foreignId('interview_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Khóa ngoại liên kết đến người dùng là ứng viên
            $table->foreignId('jobseeker_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Trạng thái phản hồi: chấp nhận hoặc từ chối
            $table->enum('response', ['accepted', 'declined']);

            // Ghi chú bổ sung của ứng viên (tuỳ chọn)
            $table->text('note')->nullable();

            // Thời gian tạo/cập nhật
            $table->timestamps();
        });
    }

    /**
     * Xoá bảng interview_responses khi rollback migration
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_responses');
    }
};
