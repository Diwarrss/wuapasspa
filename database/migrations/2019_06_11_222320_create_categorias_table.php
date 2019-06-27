<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_categoria', 150);
            $table->enum('estado_categoria', [App\Categoria::ACTIVO, App\Categoria::DESACTIVADO])->default(\App\Categoria::ACTIVO);
            $table->string('url_video',500)->nullable();
            $table->unsignedInteger('imagenes_imagenes_id')->nullable();
            $table->foreign('imagenes_imagenes_id')->references('id')->on('imagenes');
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
        Schema::dropIfExists('categorias');
    }
}
