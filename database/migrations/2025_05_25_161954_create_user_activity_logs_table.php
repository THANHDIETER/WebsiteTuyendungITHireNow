<?php
// Migration: create_user_activity_logs_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action');
            $table->text('description')->nullable();
            $table->timestamp('action_time')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_activity_logs');
    }
};