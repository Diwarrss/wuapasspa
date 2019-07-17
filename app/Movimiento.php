<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = [
        'factura_id',
        'caja_id',
        'valor_recibido',
        'valor_pendiente',
        'valor_egreso'
    ];
}
