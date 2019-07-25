<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('factura_id')->nullable();
            $table->foreign('factura_id')->references('id')->on('facturas');
            $table->unsignedInteger('caja_id');
            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->decimal('valor_movimiento', 12, 2)->default(0);
            $table->decimal('valor_pendiente', 12, 2)->default(0);
            $table->enum('tipo_movimiento', [
                \App\Movimiento::INGRESO, \App\Movimiento::EGRESO
            ])
                ->default(\App\Movimiento::INGRESO);
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
        Schema::dropIfExists('movimientos');
    }
}
