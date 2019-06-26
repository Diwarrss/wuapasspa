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
            $table->unsignedInteger('roles_roles_id')->default(\App\Role::Cliente);//creamos la llave primaria por defecto con roles
            $table->foreign('roles_roles_id')->references('id')->on('roles');//hace referencia a nuestra tabla roles el id
            $table->unsignedInteger('empresas_empresas_id')->nullable();//creamos la llave primaria para empresas
            $table->foreign('empresas_empresas_id')->references('id')->on('empresas');//hace referencia a nuestra tabla roles el id
            $table->string('nombre_usuario', 100)->nullable();
            $table->string('apellido_usuario', 100)->nullable();
            $table->string('usuario', 45)->nullable();
            $table->string('password', 255)->nullable()->comment('Se deja nulo para el logueo con redes sociales');
            $table->string('email', 100)->unique();
            $table->string('celular', 20)->nullable();
            $table->date('fecha_cumple', 45)->nullable();
            $table->string('imagen', 255)->nullable()->default('avatar.png');
            $table->enum('estado_usuario', [\App\User::ACTIVO, \App\User::DESACTIVADO])->default(\App\User::ACTIVO);//con enum obligamos a que solo permita esos valores y dejamos por defecto Activo
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        /*DB::statement("
        aqui va SQL puro
        ");*/
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
