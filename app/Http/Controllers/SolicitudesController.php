<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitude;//se importa el modelo de las solicitudes
use App\Servicios_solicitudes;//se importa el modelo de los servicios
use Illuminate\Support\Facades\Auth; // para obtener el id del cliente que hace la solicitud
use Illuminate\Support\Facades\DB;// para hacer transacciones seguras a la db
use App\Reservacione;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax
        //SET GLOBAL lc_time_names = 'es_ES' agregar esa linea en la base de datos para las fechas en español
       DB::statement("SET lc_time_names = 'es_ES'");//transfort all sentense beloww to spanihs
        $solicitudes =  DB::table('solicitudes')
                        ->join('servicios_solicitudes', 'solicitudes.id', '=', 'servicios_solicitudes.solicitudes_solicitudes_id')
                        ->join('servicios', 'servicios_solicitudes.servicios_servicios_id', '=', 'servicios.id')
                        ->select('solicitudes.id','solicitudes.comentario','solicitudes.estado_solicitud',
                        DB::raw("DATE_FORMAT(solicitudes.created_at, '%d/%m/%Y %h:%i %p') as created_at"),
                        DB::raw("DATE_FORMAT(solicitudes.fechaprobable, '%d/%m/%Y %h:%i %p') as fechaprobable"),
                        DB::raw("(CASE solicitudes.estado_solicitud
                                       WHEN 1 THEN 'Pendiente'
                                       WHEN 2 THEN 'Agendada'
                                       WHEN 3 THEN 'Cancelada'
                                       WHEN 4 THEN 'Aceptar Cita'
                                       WHEN 5 THEN 'Atendida'
                                       ELSE 'No Asistió' END) AS estado_solicitud_nombre,
                        (GROUP_CONCAT(servicios.nombre_servicio SEPARATOR ', ')) as nombre_servicio"))
                        ->where('solicitudes.users_users_id', Auth::user()->id)
                        ->groupBy('solicitudes.id','solicitudes.comentario','solicitudes.estado_solicitud',
                        'solicitudes.created_at','solicitudes.fechaprobable');

        $reservacionSolicitud = DB::table('reservaciones')
                                ->rightJoinSub($solicitudes, 'solicitudesQB', function ($join) {
                                    $join->on('reservaciones.solicitudes_solicitudes_id', '=', 'solicitudesQB.id');
                                })
                                ->leftJoin('users', 'reservaciones.users_users_id', '=', 'users.id')
                                ->select('solicitudesQB.id',DB::raw("MAX(reservaciones.id) as reservacionId"),'solicitudesQB.comentario',
                              'solicitudesQB.estado_solicitud_nombre','reservaciones.estado_reservacion','solicitudesQB.nombre_servicio',
                               DB::raw("CONCAT('Atendido Por: ',users.nombre_usuario,'  ',users.apellido_usuario) as Empleado"),
                               DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%W %d de %M %Y, A las %h:%i %p'),' a ',
                                                DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva"),
                               'solicitudesQB.created_at', 'solicitudesQB.fechaprobable')
                               ->groupBy('solicitudesQB.id')
                               ->orderBy('solicitudesQB.id', 'desc')
                               ->get();

        return datatables($reservacionSolicitud)->toJson();
        //->where([['solicitudes.users_users_id', Auth::user()->id]])
        // return $reservacionSolicitud;
    }

    public function showSolicitudesPendientes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        $showSolicitudesPendientes = DB::table('solicitudes')
                            ->join('users', 'solicitudes.users_users_id', '=', 'users.id')
                            ->join('servicios_solicitudes', 'solicitudes.id', '=', 'servicios_solicitudes.solicitudes_solicitudes_id' )
                            ->join('servicios', 'servicios.id', '=', 'servicios_solicitudes.servicios_servicios_id')
                            ->select('solicitudes.id', 'users.id as user_id', 'solicitudes.comentario', 'solicitudes.estado_solicitud', 'users.celular',
                                    DB::raw("DATE_FORMAT(solicitudes.created_at, '%d/%m/%Y %h:%i %p') as created_at"),
                                    DB::raw("DATE_FORMAT(solicitudes.fechaprobable, '%d/%m/%Y %h:%i %p') as fechaprobable"),
                                    DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo"),
                                    DB::raw("(CASE solicitudes.estado_solicitud
                                    WHEN 1 THEN 'Pendiente'
                                    WHEN 2 THEN 'Agendada'
                                    WHEN 3 THEN 'Cancelada'
                                    ELSE 'Por Confirmar' END) AS estado_solicitud_nombre,
                                    (GROUP_CONCAT(servicios.nombre_servicio SEPARATOR ', ')) as nombre_servicio"))
                            ->where('solicitudes.estado_solicitud', 1)
                            ->groupBy('solicitudes.id', 'users.id', 'solicitudes.comentario', 'solicitudes.estado_solicitud', 'users.celular',
                            'solicitudes.created_at','solicitudes.fechaprobable','users.nombre_usuario',
                            'users.apellido_usuario','solicitudes.estado_solicitud')
                            ->orderByDesc('solicitudes.id')
                            ->get();

        return datatables($showSolicitudesPendientes)->toJson();
    }

    public function contarSolicitudes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax
        $countSolicitud = DB::table('solicitudes')
                        ->where('estado_solicitud', 1)
                        ->count();
        return ['cantidad' => $countSolicitud];
        //con este codigo retornamos el valor que queramos a una vista de Blade y alla se imprime
        //return view('admin.navegacion.admin',['cantidad' => $countSolicitud]);
    }
    //para guardar la solicitud por cliente
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        //para validar
        $request->validate([
            
            'servicios' => 'required',
            'fecha_probable' => 'required',
            'comentario' => 'required'
        ]);

        //para generear la transacccion
        return DB::transaction(function () use ($request) {

            //insertar la solicitud
            $solicitudes = new Solicitude();
            $solicitudes->users_users_id = Auth::user()->id;
            $solicitudes->fechaprobable = $request->fecha_probable;
            $solicitudes->comentario = $request->comentario;
            $solicitudes->estado_solicitud = '1';
            $solicitudes->save();

            //relacionar la solicitud con los servicios
            foreach ($request->servicios as $servicio) {
                $Servicios = new Servicios_solicitudes();
                $Servicios->servicios_servicios_id = $servicio;
                $Servicios->solicitudes_solicitudes_id = $solicitudes->id;//esta vuelta muestra el id automaticamente despues del save()
                $Servicios->save();
            }

        });
    }
    //para cancelar solicitud agendada
    public function cancelarAgendada(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        //CANCELO = 3;
        $solicitudes = Solicitude::findOrFail($request->id);
        $solicitudes->estado_solicitud = '3';
        $solicitudes->save();

        $reservaciones = Reservacione::findOrFail($request->reservacionId);
        $reservaciones->estado_reservacion = '5';
        $reservaciones->save();
    }
    //para cancelar solicitud agendada
    public function confirmarAgendada(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        //CANCELO = 3;
        $solicitudes = Solicitude::findOrFail($request->id);
        $solicitudes->estado_solicitud = '2';
        $solicitudes->save();

        $reservaciones = Reservacione::findOrFail($request->reservacionId);
        $reservaciones->estado_reservacion = '4';
        $reservaciones->save();
    }
    //para cancelar solo solicitud sin agendar
    public function cancelarSolicitud(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        //CANCELO = 3;
        $solicitudes = Solicitude::findOrFail($request->id);
        $solicitudes->estado_solicitud = '3';
        $solicitudes->save();
    }

    public function componente(){
        $logoEmpresa = DB::table('empresas')
                        ->select('logo_empresa')
                        ->get();

        return view('/cliente/misCitas', ['logoEmpresa' => $logoEmpresa]);
    }
}
