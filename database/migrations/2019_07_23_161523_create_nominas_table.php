<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('realizado_por');
            $table->foreign('realizado_por')->references('id')->on('users');
            $table->unsignedInteger('pagado_a');
            $table->foreign('pagado_a')->references('id')->on('users');
            $table->unsignedInteger('movimientos_id');
            $table->foreign('movimientos_id')->references('id')->on('movimientos');
            $table->decimal('porcentaje_pagado', 12, 2);
            $table->decimal('valor_pagado', 12, 2);
            $table->decimal('valor_total', 12, 2);
            $table->enum('estado_nomina', [\App\Nomina::PAGADA, \App\Nomina::ANULADA])->default(\App\Nomina::PAGADA);
            $table->integer('anulado_por')->nullable();
            $table->string('motivo_anulacion', 255)->nullable();
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
        Schema::dropIfExists('nominas');
    }
}
