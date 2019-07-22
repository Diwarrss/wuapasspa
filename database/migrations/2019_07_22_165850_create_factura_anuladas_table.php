<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaAnuladasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_anuladas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('facturas_id');
            $table->foreign('facturas_id')->references('id')->on('facturas');
            $table->unsignedInteger('anulado_por');
            $table->foreign('anulado_por')->references('id')->on('users');
            $table->string('descripcion', '350');
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
        Schema::dropIfExists('factura_anuladas');
    }
}
