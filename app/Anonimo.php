<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anonimo extends Model
{
    protected $fillable = [
        'reservaciones_id',
        'nombre_anonimo',
        'celular_anonimo',
        'notas_anonimo'
    ];
}
