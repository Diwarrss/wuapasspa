<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaAnulada extends Model
{
    //
    protected $fillable = [
        'id',
        'facturas_id',
        'anulado_por',
        'descripcion',
        'nombre_cliente'
    ];
}
