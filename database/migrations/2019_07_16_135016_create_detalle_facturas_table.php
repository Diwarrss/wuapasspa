<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->unsignedInteger('empleado_id');
            $table->foreign('empleado_id')->references('id')->on('users');
            $table->integer('cantidad_facturada');
            $table->decimal('valor_servicio', 12, 2);
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
