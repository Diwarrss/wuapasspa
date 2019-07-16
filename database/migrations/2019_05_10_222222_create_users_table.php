<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('roles_roles_id')->default(\App\Role::Cliente); //creamos la llave primaria por defecto con roles
            $table->foreign('roles_roles_id')->references('id')->on('roles'); //hace referencia a nuestra tabla roles el id
            $table->unsignedInteger('empresas_empresas_id')->nullable(); //creamos la llave primaria para empresas
            $table->foreign('empresas_empresas_id')->references('id')->on('empresas'); //hace referencia a nuestra tabla roles el id
            $table->string('nombre_usuario', 100)->nullable();
            $table->string('apellido_usuario', 100)->nullable();
            $table->string('usuario', 45)->nullable();
            $table->string('password', 255)->nullable()->comment('Se deja nulo para el logueo con redes sociales');
            $table->string('email', 100)->unique();
            $table->string('celular', 20)->nullable();
            $table->date('fecha_cumple', 45)->nullable();
            $table->string('imagen', 255)->nullable()->default('avatar.png');
            $table->enum('estado_usuario', [\App\User::ACTIVO, \App\User::DESACTIVADO])->default(\App\User::ACTIVO); //con enum obligamos a que solo permita esos valores y dejamos por defecto Activo
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        /*DB::statement("
        aqui va SQL puro
        ");*/

        $now = new \DateTime();
        $password = Hash::make('123456');

        //inserto a la tabla datos registros
        DB::table('users')->insert(array(
            'id' => '1', 'roles_roles_id' => 1, 'empresas_empresas_id' => 1, 'nombre_usuario' => 'Diego Admin', 'apellido_usuario' => 'Admin2',
            'usuario' => '', 'password' => $password, 'email' => 'dialvaro30@gmail.com', 'celular' => '3132458975', 'fecha_cumple' => '1995/12/30', 'imagen' => 'avatar.png',
            'estado_usuario' => '1', 'email_verified_at' => null, 'remember_token' => null, 'created_at' => $now
        ));
        DB::table('users')->insert(array(
            'id' => '2', 'roles_roles_id' => 2, 'empresas_empresas_id' => 1, 'nombre_usuario' => 'Empleado 1', 'apellido_usuario' => 'emple',
            'usuario' => '', 'password' => $password, 'email' => 'dialvaro31@gmail.com', 'celular' => '3132458975', 'fecha_cumple' => '1995/12/30', 'imagen' => 'avatar.png',
            'estado_usuario' => '1', 'email_verified_at' => null, 'remember_token' => null, 'created_at' => $now
        ));
        DB::table('users')->insert(array(
            'id' => '3', 'roles_roles_id' => 2, 'empresas_empresas_id' => 1, 'nombre_usuario' => 'Empleado 2', 'apellido_usuario' => 'emple',
            'usuario' => '', 'password' => $password, 'email' => 'dialvaro32@gmail.com', 'celular' => '3132458975', 'fecha_cumple' => '1995/12/30', 'imagen' => 'avatar.png',
            'estado_usuario' => '1', 'email_verified_at' => null, 'remember_token' => null, 'created_at' => $now
        ));
        DB::table('users')->insert(array(
            'id' => '4', 'roles_roles_id' => 3, 'empresas_empresas_id' => 1, 'nombre_usuario' => 'Diego Cliente', 'apellido_usuario' => 'Cliente',
            'usuario' => '', 'password' => $password, 'email' => 'dialvaro33@gmail.com', 'celular' => '3132458975', 'fecha_cumple' => '1995/12/30', 'imagen' => 'avatar.png',
            'estado_usuario' => '1', 'email_verified_at' => null, 'remember_token' => null, 'created_at' => $now
        ));
        DB::table('users')->insert(array(
            'id' => '5', 'roles_roles_id' => 4, 'empresas_empresas_id' => 1, 'nombre_usuario' => 'Agendador 1', 'apellido_usuario' => 'agendar',
            'usuario' => '', 'password' => $password, 'email' => 'dialvaro34@gmail.com', 'celular' => '3132458975', 'fecha_cumple' => '1995/12/30', 'imagen' => 'avatar.png',
            'estado_usuario' => '1', 'email_verified_at' => null, 'remember_token' => null, 'created_at' => $now
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
