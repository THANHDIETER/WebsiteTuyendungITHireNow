<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained('employer_packages')->onDelete('cascade');
            $table->integer('amount');
            $table->string('currency', 10);
            $table->decimal('vat_percent', 5, 2)->default(0);
            $table->string('invoice_number', 100)->nullable();
            $table->string('payment_method', 50);
            $table->string('payment_gateway', 50)->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->string('status', 50);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}