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
        Schema::create('bank_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_account_id')->constrained()->onDelete('cascade');
            $table->string('trans_id')->index();
            $table->decimal('amount', 15, 2)->nullable();
            $table->timestamp('trans_time')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['bank_account_id', 'trans_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_logs');
    }
};
