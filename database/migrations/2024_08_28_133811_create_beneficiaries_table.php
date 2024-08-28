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
            $table->string('middle_name');
            $table->string('sex');
            $table->string('civil_status');
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
