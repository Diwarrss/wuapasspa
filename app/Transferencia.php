<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    //creamos las constantes de los usuarios del sistema
    const PENDIENTE = 1;
    const RECIBIDA = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'caja_origen',
        'caja_destino',
        'valor',
        'notas',
        'estado_transferencia'
    ];
}
