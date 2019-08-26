<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefijo', 5)->nullable();
            $table->integer('numero_orden');
            $table->unsignedInteger('cliente')->nullable()->comment('Cliente dueño de la orden');
            $table->foreign('cliente')->references('id')->on('users');
            $table->unsignedInteger('creado_por');
            $table->foreign('creado_por')->references('id')->on('users');
            $table->enum('estado_orden', [
                \App\Orden::FACTURADA, \App\Orden::PENDIENTE,
                \App\Orden::ANULADA
            ])->default(\App\Orden::PENDIENTE);
            $table->decimal('valor_descuento', 12, 2)->default(0);
            $table->decimal('valor_total', 12, 2)->default(0);
            $table->string('nota_orden', 250)->nullable();
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
        Schema::dropIfExists('ordens');
    }
}
