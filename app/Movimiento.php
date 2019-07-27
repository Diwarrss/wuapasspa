<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    //tipo_movimiento
    const INGRESO = 1;
    const EGRESO = 2;
    //estado
    const ACTIVO = 1;
    const CANCELADO = 2;

    protected $fillable = [
        'factura_id',
        'caja_id',
        'valor_movimiento',
        'valor_pendiente',
        'tipo_movimiento',
        'estado'
    ];
}
