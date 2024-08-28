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
        Schema::create('assistance_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistance_type_id')->constrained('assistance_types');
            $table->string('event_name');
            $table->date('event_date')->nullable();
            $table->string('venue');
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistance_events');
    }
};
