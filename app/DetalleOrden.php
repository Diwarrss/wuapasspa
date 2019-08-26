<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    protected $fillable = [
        'ordens_id',
        'servicios_servicios_id',
        'empleado_id',
        'cantidad',
        'valor_descuento',
        'valor_servicio'
    ];
}
