<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Solicitude
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Solicitude newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Solicitude newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Solicitude query()
 * @mixin \Eloquent
 * @property int $idsolicitud
 * @property int $users_iduser
 * @property string $fechaprobable
 * @property string|null $comentario
 * @property string $estado_solicitud
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Solicitude whereComentario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Solicitude whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Solicitude whereEstadoSolicitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Solicitude whereFechaprobable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Solicitude whereIdsolicitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Solicitude whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Solicitude whereUsersIduser($value)
 */
class Solicitude extends Model
{
    const PENDIENTE = 1;
    const AGENDADA = 2;
    const CANCELO = 3;
    const PORCONFIRMAR = 4;
    const ATENDIDA = 5;
    const NOASISTIO = 6;

    protected $fillable = [
        'users_users_id',
        'fechaprobable',
        'comentario',
        'estado_solicitud'
    ];

    public function user(){
        return $this->belongsTo('App\User');//una solicitud la puede hacer un Usuario
    }

    public function servicio(){
        return $this->belongsToMany('App\Servicio');//una solicitud puede tener varios servicios relacion Muchos a Muchos
    }

    public function reservacion(){
        return $this->hasOne('App\Reservacione');//una solicitud se agenda luego como una reserva
    }
}
