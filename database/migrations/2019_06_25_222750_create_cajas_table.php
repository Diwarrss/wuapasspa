<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empleado_id');
            $table->foreign('empleado_id')->references('id')->on('users');
            $table->string('nombre_caja', 150);
            $table->decimal('valor_inicial', 12, 2);
            $table->decimal('valor_producido', 12, 2);
            $table->decimal('valor_gastos', 12, 2)->default(0);
            $table->enum('estado_caja', [\App\User::ACTIVO, \App\User::DESACTIVADO])->default(\App\User::ACTIVO); //con enum obligamos a que solo permita esos valores y dejamos por defecto Activo
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
        Schema::dropIfExists('cajas');
    }
}
