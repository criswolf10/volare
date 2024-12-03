
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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aircraft_id')->constrained('aircrafts')->cascadeOnDelete(); // Relación con aviones
            $table->string('code')->unique(); // Código único del vuelo
            $table->string('origin'); // Origen
            $table->string('destination'); // Destino
            $table->time('duration'); // Duración del vuelo
            $table->date('departure_date'); // Fecha de salida
            $table->time('departure_time'); // Hora de salida
            $table->time('arrival_time'); // Hora de llegada
            $table->enum('status', ['borrador', 'en espera', 'en trayecto', 'completo', 'cancelado']);
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
