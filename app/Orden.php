<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    //estado_factura
    const FACTURADA = 1;
    const PENDIENTE = 2;
    const ANULADA = 3;

    protected $fillable = [
        'prefijo',
        'numero_orden',
        'creado_por',
        'estado_orden',
        'valor_descuento',
        'valor_total',
        'nota_orden'
    ];
}
