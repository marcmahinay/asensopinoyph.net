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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barangay_id')->constrained('barangays');
            $table->string('asenso_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('sex')->nullable();
            $table->foreignId('civil_status_id')->nullable()->constrained('civil_statuses');
            $table->string('blood_type')->nullable();
            $table->string('position')->nullable();
            $table->string('profession')->nullable();
            $table->string('present_address')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_address')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
