<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitudes_solicitudes_id')->nullable();
            $table->foreign('solicitudes_solicitudes_id')->references('id')->on('solicitudes');
            $table->unsignedInteger('users_users_id')->comment('Es el ID del empleado');
            $table->foreign('users_users_id')->references('id')->on('users');
            $table->timestamp('fechaHoraInicio_reserva')->default('0000-00-00 00:00:00');
            $table->timestamp('fechaHoraFinal_reserva')->default('0000-00-00 00:00:00');
            $table->integer('asignadopor');
            $table->enum('estado_reservacion', [
                \App\Reservacione::PENDIENTE, \App\Reservacione::ATENTIDO,
                \App\Reservacione::NOASISTIO, \App\Reservacione::ENESPERA, \App\Reservacione::CANCELO
            ])
                ->default(\App\Reservacione::PENDIENTE);
            /* $table->unsignedInteger('facturas_id')->nullable();
            $table->foreign('facturas_id')->references('id')->on('facturas'); */
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
        Schema::dropIfExists('reservaciones');
    }
}
