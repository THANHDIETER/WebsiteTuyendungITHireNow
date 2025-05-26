<?php
// Migration: create_user_profiles_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->primary();
            $table->string('full_name')->nullable();
            $table->date('birthday')->nullable();
            $table->text('address')->nullable();
            $table->string('professional_title')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};