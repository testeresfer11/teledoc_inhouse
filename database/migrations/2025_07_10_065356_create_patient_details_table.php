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
        Schema::create('patient_details', function (Blueprint $table) {
            $table->id(); // idPrimary
            $table->unsignedInteger('user_id')->index();
            $table->text('country_code')->nullable();
            $table->text('mobile_no')->nullable();
            $table->tinyInteger('gender')->nullable()->comment('1=male, 2=female, 3=other');
            $table->date('birth_date')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('image')->nullable();
            $table->text('id_proof')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->string('pat_lat', 255)->nullable();
            $table->string('pat_long', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_details');
    }
};
