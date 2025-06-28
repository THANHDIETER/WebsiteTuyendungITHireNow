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

            $table->string('trans_id');
            $table->decimal('amount', 15, 2)->nullable();
            $table->timestamp('trans_time')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_used')->default(false);
            $table->foreignId('matched_payment_id')
                ->nullable()
                ->constrained('payments')
                ->nullOnDelete();

            $table->timestamps();

            // === Indexes & Unique Constraints ===

            // Tránh log trùng trong cùng một tài khoản ngân hàng
            $table->unique(['bank_account_id', 'trans_id']);

            // Truy vấn nhiều theo trans_id
            $table->index('trans_id');

            // Truy vấn theo amount + is_used (xử lý matching)
            $table->index(['amount', 'is_used']);

            // Truy vấn lọc theo trans_time (khoảng thời gian)
            $table->index('trans_time');

            // Truy vấn matched_payment_id nếu dùng join audit
            $table->index('matched_payment_id');
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
