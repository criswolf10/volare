<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Relación con usuarios (opcional)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            // Relación con vuelos
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade');

            // Relación con asientos del avión
            $table->foreignId('aircraft_seat_id')->constrained('aircraft_seats')->onDelete('cascade');

            // Relación con pasajeros
            $table->foreignId('passenger_id')->constrained('passengers')->onDelete('cascade');

            // Información del ticket
            $table->string('booking_code')->unique();
            $table->integer('quantity');
            $table->dateTime('purchase_date');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
