<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->foreignId('trip_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('passenger_id')
                ->nullable()
                ->constrained('passengers')
                ->cascadeOnDelete();

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('drivers')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->dropForeign(['trip_id']);
            $table->dropForeign(['passenger_id']);
            $table->dropForeign(['driver_id']);

            $table->dropColumn([
                'trip_id',
                'passenger_id',
                'driver_id',
                'created_at',
                'updated_at'
            ]);
        });
    }
};
