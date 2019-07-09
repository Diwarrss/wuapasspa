<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions; //import the trait

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 * @property int $iduser
 * @property int $roles_idrol
 * @property int $empresas_idempresa
 * @property string $nombre_usuario
 * @property string $apellido_usuario
 * @property string $usuario
 * @property string $password
 * @property string $email
 * @property string $celular
 * @property string $fecha_cumple
 * @property string|null $imagen
 * @property string $estado_usuario
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereApellidoUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCelular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmpresasIdempresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEstadoUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFechaCumple($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIduser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNombreUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRolesIdrol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsuario($value)
 */
class User extends Authenticatable
{
    //creamos las constantes de los usuarios del sistema
    const ACTIVO = 1;
    const DESACTIVADO = 2;

    use Notifiable;

    use HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'roles_roles_id',
        'empresas_empresas_id',
        'nombre_usuario',
        'apellido_usuario',
        'usuario',
        'password',
        'email',
        'celular',
        'fecha_cumple',
        'imagen',
        'estado_usuario',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //para las relaciones Eloquent
    public function rol(){
        return $this->belongsTo('App\Role');//un usuario pertenece a/tiene un Rol
    }

    public function empresa(){
        return $this->belongsTo('App\Empresa');//un usuario pertenece a una empresa
    }

    public function reservaciones(){
        return $this->hasMany('App\Reservacione');//un usuario ADMIN va hacer varias reservaciones
    }

    //para las relaciones Eloquent
    public function solicitudes(){
        return $this->hasMany('App\Solicitude');//un usuario CLIENTE puede hacer varias solicitudes
    }

    public function socialAccount(){
        return $this->hasOne('App\UserSocialAccount');//un usuario tiene una red Social
    }
}
