<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('company_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->unsignedTinyInteger('rating'); // Dùng tinyint để giới hạn từ 1-5
            $table->string('title', 150);
            $table->text('content');
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();

            $table->string('position', 100)->nullable();
            $table->string('employment_type', 50)->nullable(); // e.g. full-time, part-time
            $table->string('worked_year', 20)->nullable();     // e.g. 2018-2020

            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_approved')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_reviews');
    }
}
