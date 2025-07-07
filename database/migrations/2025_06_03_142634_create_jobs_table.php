<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            // Liên kết công ty
            $table->foreignId('company_id')->constrained()->onDelete('cascade');

            $table->string('title');
            $table->string('slug')->unique();

            // Ảnh thumbnail
            $table->string('thumbnail')->nullable();

            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();

            // Loại công việc
            $table->foreignId('job_type_id')->nullable()->constrained('job_types')->nullOnDelete();


            // Mức lương
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
            $table->string('currency', 10)->default('VND');
            $table->boolean('salary_negotiable')->default(false);

            // Vị trí làm việc
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->string('address')->nullable();

            // Các khóa ngoại mới
            $table->foreignId('level_id')->nullable()->constrained('levels')->nullOnDelete();
            $table->foreignId('experience_id')->nullable()->constrained('job_experiences')->nullOnDelete();
            $table->foreignId('language_id')->nullable()->constrained('job_languages')->nullOnDelete();
            $table->foreignId('remote_policy_id')->nullable()->constrained('remote_policies')->nullOnDelete();

            $table->string('salary_display')->nullable();

            $table->date('deadline')->nullable();

            // Trạng thái & hiển thị
            $table->enum('status', ['draft', 'published', 'closed', 'pending', 'rejected'])->default('pending');
            $table->integer('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_paid')->default(false);

<<<<<<< HEAD
            // Trường bổ sung
            $table->string('apply_url')->nullable();
            $table->string('remote_policy', 100)->nullable();
            $table->string('language', 50)->nullable();

=======
>>>>>>> e40cc0bc24c6a785a04dee9082e12ea467e2fbbd
            // SEO
            $table->string('meta_title', 150)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('keyword')->nullable();
<<<<<<< HEAD

            $table->boolean('search_index')->default(true);

            $table->timestamps();
            $table->softDeletes(); // deleted_at
=======
            $table->boolean('search_index')->default(true);

            $table->timestamps();
            $table->softDeletes();
>>>>>>> e40cc0bc24c6a785a04dee9082e12ea467e2fbbd
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
