<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //creamos las constantes de los servicios estado
    const ACTIVO = 1;
    const DESACTIVADO = 2;

    protected $fillable = [
        'nombre_categoria',
        'estado_categoria',
        'url_video',
        'imagenes_imagenes_id'
    ];
}
