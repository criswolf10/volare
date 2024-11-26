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
            $table->string('code')->primary();
            $table->string('aircraft');
            $table->string('origin');
            $table->string('destination');
            $table->time('duration');
            $table->date('departure_date');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->Integer('seats_quantity');
            $table->enum('seats_class', ['1º clase','2º clase', 'turista']);
            $table->string('seats_code');
            $table->enum('status', ['borrador','en espera','en trayecto', 'completo', 'cancelado']);
            $table->timestamps();
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
