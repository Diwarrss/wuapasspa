<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Empresa
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa query()
 * @mixin \Eloquent
 * @property int $idempresa
 * @property string $nombre_empresa
 * @property int $estado_empresa
 * @property string|null $nit_empresa
 * @property string|null $direccion_empresa
 * @property string|null $correo_empresa
 * @property string|null $urlweb_empresa
 * @property string|null $celular_empresa
 * @property string|null $telefono_empresa
 * @property string|null $logo_empresa
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereCelularEmpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereCorreoEmpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereDireccionEmpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereEstadoEmpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereIdempresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereLogoEmpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereNitEmpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereNombreEmpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereTelefonoEmpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Empresa whereUrlwebEmpresa($value)
 */
class Empresa extends Model
{
    //creamos las constantes de los usuarios del sistema
    const ACTIVO = 1;
    const DESACTIVADO = 2;

    protected $fillable = [
        'nombre_empresa',
        'estado_empresa',
        'nit_empresa',
        'direccion_empresa',
        'correo_empresa',
        'urlweb_empresa',
        'celular_empresa',
        'telefono_empresa',
        'logo_empresa'
    ];

    //para las relaciones Eloquent
    public function user(){
        return $this->hasMany('App\User');//una empresa tiene varios Usuarios
    }

    public function imagenes(){
        return $this->hasMany('App\Imagene');//una empresa tiene varios Imagenes
    }

    public function servicio(){
        return $this->hasMany('App\Servicio');//una empresa tiene varios Servicios
    }
}
