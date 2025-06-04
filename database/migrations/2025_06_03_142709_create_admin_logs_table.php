<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLogsTable extends Migration
{
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->string('action', 100);
            $table->string('target_type', 50)->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('browser_info')->nullable();
            $table->json('user_before')->nullable();
            $table->json('user_after')->nullable();
            $table->json('entity_changes')->nullable();
            $table->string('log_level', 20)->default('info');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_logs');
    }
}