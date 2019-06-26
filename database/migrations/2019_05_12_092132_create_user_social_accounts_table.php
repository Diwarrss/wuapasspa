<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_social_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('users_users_id');//creamos la llave primaria por defecto con usuarios
            $table->foreign('users_users_id')->references('id')->on('users');//hace referencia a nuestra tabla roles el id
            $table->string('provider')->comment('la red social que elije');//sera la red social facebook, google etc
            $table->string('provider_uid')->comment('id del usuario de la red social');//sera el id del user en esa red social
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
        Schema::dropIfExists('user_social_accounts');
    }
}
