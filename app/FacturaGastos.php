<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaGastos extends Model
{
    //estado
    const ACTIVA = 1;
    const ANULADA = 2;

    protected $fillable = [
        'creado_por',
        'prefijo',
        'numero_factura',
        'creado_por',
        'valor_neto',
        'descripcion',
        'estado_fact',
        'anulado_por',
        'motivo_anulacion'
    ];
}
