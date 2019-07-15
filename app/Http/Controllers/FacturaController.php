<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Reservacione;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    public function listarFacturacion(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $listarFacturar = DB::table('reservaciones')
            ->leftJoin('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->leftJoin('users', 'solicitudes.users_users_id', '=', 'users.id')
            ->leftJoin('anonimos', 'anonimos.reservaciones_id', '=', 'reservaciones.id')
            ->leftJoin('servicios_solicitudes', 'solicitudes.id', '=', 'servicios_solicitudes.solicitudes_solicitudes_id')
            ->leftJoin('servicios', 'servicios.id', '=', 'servicios_solicitudes.servicios_servicios_id')
            ->select(
                'solicitudes.id as id_solicitud',
                'reservaciones.id as id_reserva',
                'solicitudes.estado_solicitud',
                'reservaciones.estado_reservacion',
                'anonimos.nombre_anonimo',
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_cliente,
                                    (GROUP_CONCAT(servicios.nombre_servicio SEPARATOR ', ')) as nombre_servicio,
                                    SUM(servicios.valor_servicio) as valor_total")
            )
            ->where('reservaciones.estado_reservacion', 2)
            ->groupBy('reservaciones.id')
            ->orderByDesc('solicitudes.id')
            ->get();

        return datatables($listarFacturar)->toJson();
    }

    public function mostrarInfoFacturar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $id_reserva = $request->id_reserva;

        $listarDetFacturar = Reservacione::leftJoin('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->leftJoin('users', 'solicitudes.users_users_id', '=', 'users.id')
            ->leftJoin('anonimos', 'anonimos.reservaciones_id', '=', 'reservaciones.id')
            ->leftJoin('servicios_solicitudes', 'solicitudes.id', '=', 'servicios_solicitudes.solicitudes_solicitudes_id')
            ->leftJoin('servicios', 'servicios.id', '=', 'servicios_solicitudes.servicios_servicios_id')
            ->select(
                DB::raw("DATE_FORMAT(NOW(), '%d/%m/%Y') as fecha_actual"),
                'solicitudes.id as id_solicitud',
                'reservaciones.id as id_reserva',
                'reservaciones.users_users_id as id_atendido_por',
                'anonimos.nombre_anonimo',
                'servicios.id as id_servicio',
                'servicios.nombre_servicio',
                'servicios.valor_servicio',
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_cliente"),
                DB::raw("'1' as cantidad")
            )
            ->where('reservaciones.id', '=', $id_reserva)
            ->get();
        //devuelvo un json que se llamara lista
        return $listarDetFacturar;
    }
}
