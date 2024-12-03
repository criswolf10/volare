


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
        Schema::create('aircrafts', function (Blueprint $table) {
            $table->id();
            $table->enum('name',['Boing', 'Airbus', 'Apache', 'T-rex', 'Falcon', 'Halcon', 'Condor', 'Eagle', 'Hawk', 'Sparrow']); // Nombre del avión
            $table->string('code')->unique()->regex('/^\d{3}[A-Z]$/') ;// Código único del avión
            $table->integer('capacity'); // Capacidad total de asientos
            $table->json('seat_classes'); // Campo enum
            $table->json('seat_codes'); // Códigos de asientos
            $table->timestamps(); // created_at y updated_at
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

