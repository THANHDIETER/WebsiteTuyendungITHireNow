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
            $table->foreignUuid('company_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->string('title', 150);
            $table->text('content');
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();
            $table->string('position', 100)->nullable();
            $table->string('employment_type', 50)->nullable();
            $table->string('worked_year', 20)->nullable();
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