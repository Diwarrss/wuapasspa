<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_servicio', 150);
            $table->string('descripcion_servicio', 255)->nullable();
            $table->enum('estado_servicio', [App\Servicio::ACTIVO, App\Servicio::DESACTIVADO])->default(\App\Servicio::ACTIVO);
            $table->enum('tipo', [App\Servicio::SERVICIO, App\Servicio::PRODUCTO]);
            $table->integer('stock')->nullable();
            $table->string('url_video', 500)->nullable();
            $table->decimal('valor_servicio', 12, 2);
            $table->unsignedInteger('empresas_empresas_id');
            $table->foreign('empresas_empresas_id')->references('id')->on('empresas');
            $table->unsignedInteger('imagenes_imagenes_id')->nullable();
            $table->foreign('imagenes_imagenes_id')->references('id')->on('imagenes');
            $table->unsignedInteger('categorias_categorias_id');
            $table->foreign('categorias_categorias_id')->references('id')->on('categorias');
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
        Schema::dropIfExists('servicios');
    }
}
