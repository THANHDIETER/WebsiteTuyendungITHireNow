<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTypesTable extends Migration
{
    public function up()
    {
        Schema::create('job_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('icon_class')->nullable();       // Thêm cột icon_class
            $table->text('description')->nullable();         // Thêm cột description
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_types');
    }
}
