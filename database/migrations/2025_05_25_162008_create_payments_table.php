<?php
// Migration: create_payments_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained('service_packages')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['VNPAY', 'Momo', 'bank_card']);
            $table->enum('status', ['pending', 'completed', 'failed']);
            $table->timestamp('paid_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};