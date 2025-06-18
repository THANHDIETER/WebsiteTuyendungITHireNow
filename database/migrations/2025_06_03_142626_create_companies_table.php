<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo_url')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->string('website')->nullable();
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('company_size')->nullable();
            $table->integer('founded_year')->nullable();
            $table->string('industry')->nullable();
            $table->text('description')->nullable();
            $table->text('benefits')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->enum('status', ['active', 'inactive', 'banned'])->default('inactive');
            
            // Các trường liên quan đến quota miễn phí
            $table->unsignedTinyInteger('free_post_quota')->default(3)->comment('Số lượt đăng tin miễn phí ban đầu');
            $table->unsignedTinyInteger('free_post_quota_used')->default(0)->comment('Số lượt đã dùng');
            $table->timestamp('free_post_quota_expired_at')->nullable()->comment('Hạn sử dụng quota miễn phí (7 ngày)');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
