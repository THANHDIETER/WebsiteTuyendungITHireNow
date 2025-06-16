<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank');
            $table->string('branch')->nullable();          // Chi nhánh
            $table->string('account_number')->nullable();
            $table->text('token');
            $table->text('password')->nullable();
            $table->boolean('is_active')->default(true);   // Trạng thái hoạt động
            $table->string('image')->nullable();           // Ảnh
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
