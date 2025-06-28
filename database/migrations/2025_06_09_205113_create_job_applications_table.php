<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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

            // Thêm thông tin ứng viên
            $table->string('full_name', 255);
            $table->string('email', 255);
            $table->string('phone', 20);

            $table->text('image')->nullable();
            $table->text('cover_letter')->nullable();
            $table->timestamp('applied_at')->useCurrent();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_shortlisted')->default(false);

            $table->string('source', 100)->default('website');
            $table->string('application_stage', 50)->nullable();
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
