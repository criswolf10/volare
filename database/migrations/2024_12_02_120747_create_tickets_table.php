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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // ID único como clave primaria
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relación con usuarios
            $table->foreignId('flight_id')->constrained('flights')->cascadeOnDelete(); // Relación con vuelos
            $table->string('booking_code')->unique(); // Código de reserva
            $table->string('seat'); // Columna para el asiento asignado
            $table->decimal('price', 10, 2); // Precio total de los tickets comprados
            $table->integer('quantity'); // Cantidad de tickets comprados
            $table->date('purchase_date'); // Fecha de compra
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

