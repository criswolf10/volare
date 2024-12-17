<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
public function up()
{
    Schema::create('passengers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('lastname');
        $table->string('email');
        $table->string('phone');
        $table->string('dni');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('passengers');
}

};
