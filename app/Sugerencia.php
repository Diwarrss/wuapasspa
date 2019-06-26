<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sugerencia extends Model
{
    protected $fillable = [
        'empresas_empresas_id',
        'descripcion'
    ];
}
