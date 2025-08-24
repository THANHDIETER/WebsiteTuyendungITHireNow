<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Xóa cột city cũ (string)
            $table->dropColumn('city');

            // Thêm cột city_id mới (quan hệ với bảng locations)
            $table->unsignedBigInteger('city_id')->nullable()->after('address');
            $table->foreign('city_id')->references('id')->on('locations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
            $table->string('city')->nullable(); // rollback về varchar
        });
    }
};
