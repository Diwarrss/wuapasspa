<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Imagene
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Imagene newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Imagene newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Imagene query()
 * @mixin \Eloquent
 * @property int $idimagenes
 * @property int $empresas_idempresa
 * @property string $nombre_imagen
 * @property string $url_imagen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Imagene whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Imagene whereEmpresasIdempresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Imagene whereIdimagenes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Imagene whereNombreImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Imagene whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Imagene whereUrlImagen($value)
 */
class Imagene extends Model
{
    protected $fillable = [
        'empresas_empresas_id',
        'nombre_imagen',
        'url_imagen'
    ];

    //para las relaciones Eloquent
    public function empresa(){
        return $this->belongsTo('App\Empresa');//una imagen tiene una empresa
    }
}
