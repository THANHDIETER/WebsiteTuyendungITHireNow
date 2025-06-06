<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique(); // Tên vai trò
            $table->string('display_name', 100); // Tên hiển thị
            $table->text('description')->nullable(); // Mô tả vai trò
            $table->string('guard_name', 50)->default('web'); // Guard name
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
