<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            /**
             * Các trạng thái thanh toán có thể có:
             * - pending: Chờ thanh toán
             * - paid: Đã thanh toán thành công
             * - failed: Thanh toán thất bại
             * - expired: Hết thời gian thanh toán
             * - canceled: Đã hủy
             */
            $table->string('status', 50)->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Khôi phục lại cấu hình ban đầu nếu cần rollback
            $table->string('status', 50)->change();
        });
    }
};
