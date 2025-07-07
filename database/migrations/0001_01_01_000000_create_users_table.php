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
        Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('role_id');
        $table->string('name');
        $table->string('email')->unique(); // 'emailIndex' in DB
        $table->string('password');
        $table->string('country')->nullable();
        $table->string('country_code')->nullable();
        $table->string('mobile_no')->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->timestamp('mobile_verify')->nullable();
        $table->string('chat_token')->nullable();
        $table->string('stripe_cust_id')->nullable();
        $table->tinyInteger('admin_approve')->default(0);
        $table->boolean('is_notification')->default(1);
        $table->string('current_language')->default('english');
        $table->string('timezone')->default('UTC');
        $table->string('reject_reason')->nullable();
        $table->boolean('is_insurance')->default(0);
        $table->tinyInteger('notification_sound')->nullable();
        $table->string('android_version', 10)->nullable();
        $table->string('ios_version', 10)->nullable();
        $table->unsignedBigInteger('created_by')->default(0);
        $table->rememberToken();
        $table->timestamps(); // includes created_at and updated_at
    });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
