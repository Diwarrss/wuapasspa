<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_empresa', 200);
            $table->string('nombre_corto', 100)->nullable();
            $table->integer('estado_empresa')->default(\App\Empresa::ACTIVO);//colocamos el estado por defecto de la varible cons del modelo empresa
            $table->string('nit_empresa', 12)->nullable();
            $table->string('direccion_empresa', 100)->nullable();
            $table->string('correo_empresa', 100)->nullable();
            $table->string('urlweb_empresa', 200)->nullable();
            $table->string('facebook_empresa', 500)->nullable();
            $table->string('instagram_empresa', 500)->nullable();
            $table->string('celular_empresa', 45)->nullable();
            $table->string('telefono_empresa', 45)->nullable();
            $table->string('horario_empresa', 200)->nullable();
            $table->string('logo_empresa', 150)->nullable();
            $table->timestamps();
        });

        $now = new \DateTime();

        //inserto a la tabla datos registros
        DB::table('empresas')->insert(array('id'=>'1','nombre_empresa'=>"Wuapa's Spa",'nombre_corto'=>'Spa','estado_empresa'=>'1', 'nit_empresa'=>'0', 'direccion_empresa'=>'San Gil',
            'correo_empresa'=>'wuapasspa@gmail.com', 'urlweb_empresa'=>'https://wuapasspa.gridsoft.co/', 'facebook_empresa'=>'https://www.facebook.com/wuapasSpa/',
            'instagram_empresa'=>'https://www.instagram.com/wuapas_spa/', 'celular_empresa'=>'3174588999', 'telefono_empresa'=>'0', 'horario_empresa'=>'7:00 am a 8:00 pm','logo_empresa'=>'logotipo.png', 'created_at'=>$now));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
