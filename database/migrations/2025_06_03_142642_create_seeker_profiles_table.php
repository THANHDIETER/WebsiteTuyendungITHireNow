<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeekerProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('seeker_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->string('headline', 150)->nullable();
            $table->text('summary')->nullable();
            $table->text('cv_url')->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('github_url', 255)->nullable();
            $table->string('portfolio_url', 255)->nullable();
            $table->string('location', 100)->nullable();
            $table->integer('salary_expectation')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('job_types', 100)->nullable();
            $table->text('education')->nullable();
            $table->text('work_experience')->nullable();
            $table->text('language_skills')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seeker_profiles');
    }
}