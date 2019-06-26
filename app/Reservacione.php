<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reservacione
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione query()
 * @mixin \Eloquent
 * @property int $idreservacion
 * @property int $solicitudes_idsolicitud
 * @property int $users_iduser
 * @property string $fechaHoraInicio_reserva
 * @property string $fechaHoraFinal_reserva
 * @property int $asignadopor
 * @property string $estado_reservacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione whereAsignadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione whereEstadoReservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione whereFechaHoraFinalReserva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione whereFechaHoraInicioReserva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione whereIdreservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione whereSolicitudesIdsolicitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reservacione whereUsersIduser($value)
 */
class Reservacione extends Model
{
    //creamos las constantes de las reservaciones
    const PENDIENTE = 1;
    const ATENTIDO = 2;
    const NOASISTIO = 3;
    const ENESPERA = 4;
    const CANCELO = 5;

    protected $fillable = [
        'solicitudes_solicitudes_id',
        'users_users_id',
        'fechaHoraInicio_reserva',
        'fechaHoraFinal_reserva',
        'asignadopor',
        'estado_reservacion'
    ];

    //para las relaciones Eloquent
    public function user(){
        return $this->belongsTo('App\User');//una reserva la hace un Usuario
    }

    public function solicitud(){
        return $this->belongsTo('App\Solicitude');//una reserva pertenece a una solicitud
    }
}
