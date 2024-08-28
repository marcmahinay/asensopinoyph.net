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
        Schema::create('assistance_received', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistance_event_id')->constrained()->onDelete('cascade');
            $table->foreignId('beneficiary_id')->constrained()->onDelete('cascade');
            $table->decimal('amount_received', 10, 2)->nullable();
            $table->text('items_received')->nullable();
            $table->dateTime('received_at');
            $table->string('status')->default('received');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['assistance_event_id', 'beneficiary_id'], 'unique_assistance_received');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistance_received');
    }
};
