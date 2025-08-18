<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('seeker_cvs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('seeker_profile_id');
        $table->string('file_path');   // đường dẫn PDF
        $table->string('title')->nullable(); // tên hiển thị (VD: CV tiếng Việt, CV tiếng Anh)
        $table->timestamps();

        $table->foreign('seeker_profile_id')->references('id')->on('seeker_profiles')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('seeker_cvs');
}

};
