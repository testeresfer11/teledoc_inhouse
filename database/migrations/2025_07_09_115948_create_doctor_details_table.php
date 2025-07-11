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
        Schema::create('doctor_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->text('ic_no')->nullable();
            $table->text('registeration_no')->nullable();
            $table->text('current_wokplace')->nullable();
            $table->text('profile_pic')->nullable();
            $table->text('ic_pic')->nullable();
            $table->text('education')->nullable();
            $table->date('birth_date')->nullable();
            $table->unsignedSmallInteger('doctor_designation_id')->nullable();
            $table->text('education_qualification')->nullable();
            $table->text('about')->nullable();
            $table->text('clinic_interest')->nullable();
            $table->tinyInteger('is_chat')->default(0);
            $table->tinyInteger('is_video')->default(0);
            $table->tinyInteger('is_home')->default(0);
            $table->tinyInteger('is_clinic')->default(0);
            $table->decimal('clinic_fee', 10, 2)->nullable();
            $table->decimal('clinic_follow_up', 10, 2)->nullable();
            $table->decimal('home_fee', 10, 2)->nullable();
            $table->decimal('home_follow_up', 10, 2)->nullable();
            $table->decimal('home_km_fee', 10, 2)->nullable();
            $table->decimal('chat_first_time', 10, 2)->nullable();
            $table->decimal('chat_follow_up', 10, 2)->nullable();
            $table->decimal('video_first_time', 10, 2)->nullable();
            $table->decimal('video_follow_up', 10, 2)->nullable();
            $table->decimal('clinic_commission', 10, 2)->nullable();
            $table->decimal('home_commission', 10, 2)->nullable();
            $table->text('signature')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedtinyInteger('is_active')->default(1);
            $table->tinyInteger('is_medical_team')->default(0);
            $table->tinyInteger('doctor_login')->default(1);
            $table->text('appointment_description')->nullable();
            $table->string('rcc_no')->nullable();
            $table->string('timezone')->default('Asia/Kolkata');
            $table->text('medical_license')->nullable();
            $table->string('medical_certificate')->nullable();
            $table->text('profile_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_details');
    }
};
