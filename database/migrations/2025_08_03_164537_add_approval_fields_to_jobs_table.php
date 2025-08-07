<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by')->nullable()->after('status');
            $table->timestamp('ai_processed_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn(['ai_processed_at']);
            $table->dropColumn(['approved_by']);
        });
    }

};
