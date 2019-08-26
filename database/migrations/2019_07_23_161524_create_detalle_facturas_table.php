<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('facturas_id');
            $table->foreign('facturas_id')->references('id')->on('facturas');
            $table->unsignedInteger('servicios_servicios_id');
            $table->foreign('servicios_servicios_id')->references('id')->on('servicios');
            $table->unsignedInteger('empleado_id')->nullable()->comment('Persona q hace el servicio');
            $table->foreign('empleado_id')->references('id')->on('users');
            $table->integer('cantidad_facturada');
            $table->decimal('valor_servicio', 12, 2);
            $table->decimal('valor_descuento', 12, 2)->default(0);
            $table->unsignedInteger('nomina_id')->nullable()->comment('Saber si se ha pagado el servicio al Empleado, asocia el id de la Nomina realizada o pago');
            $table->foreign('nomina_id')->references('id')->on('nominas');
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
        Schema::dropIfExists('detalle_facturas');
    }
}
