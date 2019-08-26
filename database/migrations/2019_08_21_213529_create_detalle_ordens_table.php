<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ordens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ordens_id');
            $table->foreign('ordens_id')->references('id')->on('ordens');
            $table->unsignedInteger('servicios_servicios_id');
            $table->foreign('servicios_servicios_id')->references('id')->on('servicios');
            $table->unsignedInteger('empleado_id')->nullable()->comment('Persona q hace el servicio');
            $table->foreign('empleado_id')->references('id')->on('users');
            $table->integer('cantidad');
            $table->decimal('valor_descuento', 12, 2)->default(0);
            $table->decimal('valor_servicio', 12, 2)->default(0);
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
        Schema::dropIfExists('detalle_ordens');
    }
}
