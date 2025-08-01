<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password')->default(bcrypt('password'));
            $table->string('name', 100)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->enum('role', ['job_seeker', 'employer', 'admin']);
            $table->enum('status', ['active', 'inactive', 'banned'])->default('inactive');
            $table->boolean('is_blocked')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('referral_code', 20)->nullable();
            $table->string('referred_by', 20)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
