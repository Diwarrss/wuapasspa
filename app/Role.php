<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Role
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @mixin \Eloquent
 * @property int $idrol
 * @property string $nombre_rol nombre del rol del User
 * @property string $descripcion_rol
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDescripcionRol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereIdrol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereNombreRol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 */
class Role extends Model
{
    //creamos las constantes de los usuarios del sistema
    const Administrador = 1;
    const Empleado = 2;
    const Cliente = 3;

    protected $fillable = [
        'nombre_rol',
        'descripcion_rol'
    ];

    //para las relaciones Eloquent
    public function user(){
        return $this->hasMany('App\User');//un rol puede pertenecer a varios usuarios
    }
}
