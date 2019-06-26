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
            $table->integer('estado_empresa')->default(\App\Empresa::ACTIVO);//colocamos el estado por defecto de la varible cons del modelo empresa
            $table->string('nit_empresa', 12)->nullable();
            $table->string('direccion_empresa', 100)->nullable();
            $table->string('correo_empresa', 100)->nullable();
            $table->string('urlweb_empresa', 200)->nullable();
            $table->string('facebook_empresa', 500)->nullable();
            $table->string('instagram_empresa', 500)->nullable();
            $table->string('celular_empresa', 45)->nullable();
            $table->string('telefono_empresa', 45)->nullable();
            $table->string('logo_empresa', 150)->nullable();
            $table->timestamps();
        });

        $now = new \DateTime();

        //inserto a la tabla datos registros
        DB::table('empresas')->insert(array('id'=>'1','nombre_empresa'=>'Mayra Peluqueria','estado_empresa'=>'1', 'nit_empresa'=>'0000', 'direccion_empresa'=>'San Gil',
            'correo_empresa'=>'mayrapelu@gmail.com', 'urlweb_empresa'=>'https://mayrapeluqueria.gridsoft.co/', 'facebook_empresa'=>'https://mayrapeluqueria.gridsoft.co/',
            'instagram_empresa'=>'https://mayrapeluqueria.gridsoft.co/', 'celular_empresa'=>'3002154784', 'telefono_empresa'=>'0377244001', 'logo_empresa'=>'avatar.png', 'created_at'=>$now));
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
