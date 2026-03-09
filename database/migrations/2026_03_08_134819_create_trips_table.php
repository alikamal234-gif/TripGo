<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passenger_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('departure_address_id')->constrained('addresses')->cascadeOnDelete();
            $table->foreignId('destination_address_id')->constrained('addresses')->cascadeOnDelete();
            $table->dateTime('departure_time');
            $table->integer('available_seats');
            $table->decimal('price',8,2);
            $table->enum('status', ['pending', 'accepted', 'refused']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
