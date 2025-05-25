<?php
// Migration: create_user_login_histories_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_login_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('login_time')->useCurrent();
            $table->string('ip_address', 45)->nullable();
            $table->text('device_info')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_login_histories');
    }
};