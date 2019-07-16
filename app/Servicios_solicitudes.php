<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicios_solicitudes extends Model
{
    public $timestamps = false; //quitar las fechas culeras automaticas
    protected $fillable = [
        'servicios_servicios_id',
        'solicitudes_solicitudes_id',
        'facturas_id',
        'empleado_id',
        'reservaciones_id',
        'cantidad_facturada'
    ];
}
