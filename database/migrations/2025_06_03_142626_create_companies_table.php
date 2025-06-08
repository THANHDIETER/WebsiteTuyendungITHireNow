<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo_url')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->string('website')->nullable();
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('company_size')->nullable();
            $table->integer('founded_year')->nullable();
            $table->string('industry')->nullable();
            $table->text('description')->nullable();
            $table->text('benefits')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->enum('status', ['active', 'inactive', 'banned'])->default('inactive');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
}