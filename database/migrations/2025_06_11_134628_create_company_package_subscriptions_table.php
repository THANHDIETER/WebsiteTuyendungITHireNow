<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_package_subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('employer_package_id')->constrained()->onDelete('cascade');
            $table->foreignId('purchased_by_user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->date('start_date')->default(now());
            $table->date('end_date');

            $table->integer('post_limit')->default(0);
            $table->integer('remaining_posts')->default(0);
            
            $table->integer('highlight_days')->default(0);
            $table->integer('highlight_used')->default(0);

            $table->integer('cv_view_limit')->default(0);
            $table->integer('cv_views_used')->default(0);

            $table->string('support_level')->nullable(); // basic / premium / vip

            $table->decimal('price', 12, 2)->default(0.00);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');

            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_package_subscriptions');
    }
};
