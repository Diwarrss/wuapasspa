<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('users_users_id');
            $table->foreign('users_users_id')->references('id')->on('users');
            $table->dateTime('fechaprobable');
            $table->string('comentario', 255)->nullable();
            $table->enum('estado_solicitud', [\App\Solicitude::PENDIENTE, \App\Solicitude::AGENDADA, \App\Solicitude::CANCELO, \App\Solicitude::PORCONFIRMAR, \App\Solicitude::ATENDIDA, \App\Solicitude::NOASISTIO])->default(\App\Solicitude::PENDIENTE);
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
        Schema::dropIfExists('solicitudes');
    }
}
