<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');

            // Applicant information
            $table->string('full_name', 255);
            $table->string('email', 255);
            $table->string('phone', 20);
            $table->text('image')->nullable();
            $table->text('cover_letter')->nullable();
            $table->timestamp('applied_at')->useCurrent();

            // Application status
            $$table->enum('status', [
                'pending',             // 1 - Chờ xử lý
                'viewed',              // 2 - Đã xem
                'under_review',        // 3 - Đang đánh giá
                'rejected',            // 4 - Đã loại
                'contacting',          // 5 - Đang liên hệ
                'interview_scheduled', // 6 - Đã mời phỏng vấn
                'interviewed',         // 7 - Đã phỏng vấn
                'offered',             // 8 - Trúng tuyển
                'hired',               // 9 - Đã nhận việc
                'candidate_declined',  // 10 - Ứng viên từ chối
                'no_response',         // 11 - Không phản hồi
                'saved',               // 12 - Đã lưu hồ sơ
            ])->default('pending');


            $table->boolean('is_shortlisted')->default(false);
            $table->string('source', 100)->default('website');
            $table->timestamp('interview_date')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
