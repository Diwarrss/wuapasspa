<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnonimosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anonimos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reservaciones_id');
            $table->foreign('reservaciones_id')->references('id')->on('reservaciones');
            $table->string('nombre_anonimo', 255);
            $table->string('celular_anonimo', 20)->nullable();
            $table->string('notas_anonimo', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anonimos');
    }
}
