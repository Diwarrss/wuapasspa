<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Servicio
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Servicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Servicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Servicio query()
 * @mixin \Eloquent
 * @property int $idservicio
 * @property int $empresas_idempresa
 * @property string $nombre_servicio
 * @property string|null $descripcion_servicio
 * @property string $estado_servicio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Servicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Servicio whereDescripcionServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Servicio whereEmpresasIdempresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Servicio whereEstadoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Servicio whereIdservicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Servicio whereNombreServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Servicio whereUpdatedAt($value)
 */
class Servicio extends Model
{
    //creamos las constantes de los servicios estado
    const ACTIVO = 1;
    const DESACTIVADO = 2;

    //creamos TIPOS
    const SERVICIO = 1;
    const PRODUCTO = 2;

    protected $fillable = [
        'nombre_servicio',
        'descripcion_servicio',
        'estado_servicio',
        'tipo',
        'stock',
        'url_video',
        'valor_servicio',
        'empresas_empresas_id',
        'imagenes_imagenes_id',
        'categorias_categorias_id',
    ];

    //para las relaciones Eloquent
    public function empresa()
    {
        return $this->belongsTo('App\Role'); //un servicio pertenece a/tiene una Empresa
    }

    public function solicitud()
    {
        return $this->belongsToMany('App\Solicitude'); //un servicio va a tener varias solicitudes relacion Muchos a Muchos
    }
}
