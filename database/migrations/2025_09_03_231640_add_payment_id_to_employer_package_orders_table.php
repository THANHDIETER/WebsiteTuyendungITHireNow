<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employer_package_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_id')->nullable()->after('id');

            // Nếu muốn ràng buộc khóa ngoại:
            $table->foreign('payment_id')
                  ->references('id')
                  ->on('payments')
                  ->onDelete('set null'); 
        });
    }

    public function down(): void
    {
        Schema::table('employer_package_orders', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropColumn('payment_id');
        });
    }
};
