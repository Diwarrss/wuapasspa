<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $fillable = [
        'empleado_id',
        'nombre_caja',
        'valor_inicial',
        'valor_producido'
    ];
}
