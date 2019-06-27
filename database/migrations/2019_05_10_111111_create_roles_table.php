<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_rol', 20)->comment('nombre del rol del User');
            $table->string('descripcion_rol', 255)->nullable();
            $table->timestamps();
        });

        $now = new \DateTime();

        //inserto a la tabla datos registros
        DB::table('roles')->insert(array('id'=>'1','nombre_rol'=>'Administrador','descripcion_rol'=>'Usuario que se encarga del control total de su sitio web, agendar y administrar.', 'created_at'=>$now));
        DB::table('roles')->insert(array('id'=>'2','nombre_rol'=>'Empleado','descripcion_rol'=>'Usuario con la capacidad de verificar al cliente atentido.', 'created_at'=>$now));
        DB::table('roles')->insert(array('id'=>'3','nombre_rol'=>'Cliente','descripcion_rol'=>'Usuario que solicitara la cita desde la pagina web.', 'created_at'=>$now));
        DB::table('roles')->insert(array('id'=>'4','nombre_rol'=>'Agendador','descripcion_rol'=>'Usuario encargado de agendar y facturar los servicios.', 'created_at'=>$now));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
