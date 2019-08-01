<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_gastos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefijo', 5)->nullable();
            $table->integer('numero_factura');
            $table->unsignedInteger('creado_por');
            $table->foreign('creado_por')->references('id')->on('users');
            $table->unsignedInteger('movimiento_id');
            $table->foreign('movimiento_id')->references('id')->on('movimientos');
            $table->decimal('valor_neto', 12, 2);
            $table->string('descripcion', 350);
            $table->enum('estado_fact', [\App\FacturaGastos::ACTIVA, \App\FacturaGastos::ANULADA])->default(\App\FacturaGastos::ACTIVA);
            $table->unsignedInteger('anulado_por')->nullable();
            $table->foreign('anulado_por')->references('id')->on('users');
            $table->string('motivo_anulacion', 350)->nullable();
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
        Schema::dropIfExists('factura_gastos');
    }
}
