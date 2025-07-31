<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chat_limit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id',64)->unique();
            $table->timestamp('limited_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_limit_logs');
    }
};
