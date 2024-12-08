


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
        Schema::create('aircrafts', function (Blueprint $table) {
            $table->id(); // ID único como clave primaria
            $table->string('name'); // Nombre del avión con el código de la serie (ejemplo: Airbus-747)
            $table->integer('capacity'); // Capacidad total de asientos del avión
            $table->json('seats'); // Distribución de los asientos en JSON
            $table->enum('status', ['borrador', 'en espera', 'completo', 'en trayecto']); // Estado del avión
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircrafts');
    }
};

