<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefijo', 5)->nullable();
            $table->integer('numero_factura');
            $table->enum('tipo_comprobante', [\App\Factura::FACTURA, \App\Factura::NOMINA,
                                            \App\Factura::GASTOS, \App\Factura::INGRESOS])
                    ->default(\App\Factura::FACTURA);
            $table->unsignedInteger('creado_por');
            $table->foreign('creado_por')->references('id')->on('users');
            $table->enum('estado_factura', [\App\Factura::PAGADA, \App\Factura::ABONADA,
                                \App\Factura::PENDIENTE, \App\Factura::ANULADA])
                    ->default(\App\Factura::PAGADA);
            $table->enum('tipo_pago', [\App\Factura::EFECTIVO, \App\Factura::TARJETA])
                    ->default(\App\Factura::EFECTIVO)->nullable();
            $table->decimal('valor_descuento', 12, 2)->default(0);
            $table->decimal('valor_total', 12, 2);
            $table->string('nota_factura', 250)->nullable();
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
        Schema::dropIfExists('facturas');
    }
}
