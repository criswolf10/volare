<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('aircraft');
            $table->string('origin');
            $table->string('destination');
            $table->string('duration');
            $table->decimal('price', 10, 2);
            $table->string('seats' );
            $table->date('date');
            $table->enum('status', ['borrador', 'en espera', 'completo', 'en trayecto']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('flights');
    }
};
