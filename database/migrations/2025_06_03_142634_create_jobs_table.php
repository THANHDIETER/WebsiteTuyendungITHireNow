<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
 public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->enum('job_type', ['full-time', 'part-time', 'internship', 'remote']);
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
            $table->string('currency', 10)->default('VND');
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->string('level')->nullable();
            $table->string('experience')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->date('deadline')->nullable();
            $table->enum('status', ['draft', 'published', 'closed', 'pending'])->default('pending');
            $table->integer('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_paid')->default(false);

            // 🔽 Các trường mới bổ sung từ ảnh
            $table->string('apply_url')->nullable();
            $table->string('remote_policy', 100)->nullable();
            $table->string('language', 50)->nullable();
            $table->string('meta_title', 150)->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('search_index')->default(true);

            $table->timestamps();
            $table->softDeletes(); // tương đương với `deleted_at` DATETIME
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}