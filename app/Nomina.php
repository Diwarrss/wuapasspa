<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    //estado de la nomina
    const PAGADA = 1;
    const ANULADA = 2;

    protected $fillable = [
        'realizado_por',
        'pagado_a',
        'movimientos_id',
        'porcentaje_pagado',
        'valor_pagado',
        'valor_total',
        'estado_nomina'
    ];
}
