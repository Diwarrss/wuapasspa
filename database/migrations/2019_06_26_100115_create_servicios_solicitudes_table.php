<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios_solicitudes', function (Blueprint $table) {
            $table->unsignedInteger('servicios_servicios_id');
            $table->foreign('servicios_servicios_id')->references('id')->on('servicios');
            $table->unsignedInteger('solicitudes_solicitudes_id')->nullable();
            $table->foreign('solicitudes_solicitudes_id')->references('id')->on('solicitudes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios_solicitudes');
    }
}
