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
            $table->foreignId('flight_id')->constrained('flights')->cascadeOnDelete();
            $table->decimal('price', 10, 2); // Precio con dos decimales
            $table->date('purchase_date'); // Fecha de compra
            $table->unsignedInteger('quantity'); // Número de boletos comprados
            $table->timestamps();
            // Clave foránea para relacionar con la tabla flights

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

