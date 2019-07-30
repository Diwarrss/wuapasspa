<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('caja_origen');
            $table->foreign('caja_origen')->references('id')->on('cajas');
            $table->unsignedInteger('caja_destino');
            $table->foreign('caja_destino')->references('id')->on('cajas');
            $table->decimal('valor', 12, 2);
            $table->string('notas', 250);
            $table->unsignedInteger('anulado_por')->nullable();
            $table->foreign('anulado_por')->references('id')->on('users');
            $table->string('motivo_anulacion', 255)->nullable();
            $table->enum('estado_transferencia', [\App\Transferencia::PENDIENTE, \App\Transferencia::RECIBIDA, \App\Transferencia::ANULADA])->default(\App\Transferencia::PENDIENTE); //con enum obligamos a que solo permita esos valores y dejamos por defecto Activo
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
        Schema::dropIfExists('transferencias');
    }
}
