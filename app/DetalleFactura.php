<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $fillable = [
        'facturas_id',
        'servicios_servicios_id',
        'empleado_id',
        'cantidad_facturada',
        'valor_servicio'
    ];
}
