<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reservacione; //se importa el modelo de las reservaciones
use App\Solicitude; //se importa el modelo de las solicitudes
use App\Anonimo;
use Illuminate\Support\Facades\Auth; // para obtener el id del cliente que hace la solicitud
use Illuminate\Support\Facades\DB; // para hacer transacciones seguras a la db

class ReservacionesController extends Controller
{
    //Metodo para guardar la Reservacion y actualizar la solicitud
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //para generear la transacccion
        return DB::transaction(function () use ($request) {

            //insertar la reservacion
            $reservaciones = new Reservacione();
            $reservaciones->solicitudes_solicitudes_id = $request->solicitudes_solicitudes_id;
            $reservaciones->users_users_id = $request->users_users_id;
            $reservaciones->fechaHoraInicio_reserva = $request->fechaHoraInicio_reserva;
            $reservaciones->fechaHoraFinal_reserva = $request->fechaHoraFinal_reserva;
            $reservaciones->asignadopor = Auth::user()->id;
            $reservaciones->estado_reservacion = '1';
            $reservaciones->save();

            //Actualizar estado de la solicitud a agendada
            //PORCONFIRMAR = 4
            $solicitudes = Solicitude::findOrFail($request->solicitudes_solicitudes_id);
            $solicitudes->estado_solicitud = '4';
            $solicitudes->save();
        });
    }

    //guardar anonimo
    public function storeAnonimo(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //para generear la transacccion
        return DB::transaction(function () use ($request) {

            //insertar la reservacion
            $reservaciones = new Reservacione();
            $reservaciones->users_users_id = $request->users_users_id;
            $reservaciones->fechaHoraInicio_reserva = $request->fechaHoraInicio_reserva;
            $reservaciones->fechaHoraFinal_reserva = $request->fechaHoraFinal_reserva;
            $reservaciones->asignadopor = Auth::user()->id;
            $reservaciones->estado_reservacion = '4';
            $reservaciones->save();

            //insertar y asociar anonimno con la reservacion
            $anonimo = new Anonimo();
            $anonimo->reservaciones_id = $reservaciones->id;
            $anonimo->nombre_anonimo = $request->nombre_anonimo;
            $anonimo->celular_anonimo = $request->celular_anonimo;
            $anonimo->notas_anonimo = $request->notas_anonimo;
            $anonimo->save();
        });
    }

    //mostrar Reservacion Agendadas
    public function showReservaAgendada(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $reservaAgendada = DB::table('reservaciones')
            ->join('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->join('users', 'solicitudes.users_users_id', '=', 'users.id')
            ->select(
                'reservaciones.id',
                'reservaciones.solicitudes_solicitudes_id',
                'reservaciones.users_users_id as empleado',
                'solicitudes.users_users_id as cliente',
                'reservaciones.estado_reservacion',
                'users.celular',
                DB::raw("DATE_FORMAT(reservaciones.created_at, '%d/%m/%Y %h:%i %p') as fechaAgendada"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva"),
                DB::raw("CONCAT(users.nombre_usuario,' ',users.apellido_usuario) as nombre_cliente"),
                DB::raw("IF(reservaciones.estado_reservacion = 1, 'Por Confirmar', 'Por Atender') as estado_reservacion_nombre")
            )
            ->orderByDesc('reservaciones.id')
            ->whereIn('reservaciones.estado_reservacion', [1, 4])
            ->get();
        //devolvemos el resultado en formato datatable
        return datatables($reservaAgendada)
            //setrowid elejimos y mostramos el id del atributo
            ->setRowId(function ($reservaAgendada) {
                return $reservaAgendada->id;
            })
            ->toJson();
        //return $reservaAgendada;
    }
    //contador de agendadas
    public function contarAgendadas(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax
        $countAgendadas = DB::table('reservaciones')
            ->whereIn('estado_reservacion', [1, 4])
            ->count();
        return ['cantidad' => $countAgendadas];
    }

    //mostrar Reservacion En Espera Todas
    public function showEnEspera(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $reservaAtendidos =  DB::table('reservaciones')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->join('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->join('users as cliente', 'solicitudes.users_users_id', '=', 'cliente.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("DATE_FORMAT(reservaciones.created_at, '%d/%m/%Y %h:%i %p') as fechaAgendada"),
                DB::raw("CONCAT(cliente.nombre_usuario, ' ',cliente.apellido_usuario) as nombre_cliente"),
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("IF(reservaciones.estado_reservacion = 4, 'Por Atender', '') as estado_reservacion_nombre"),
                DB::raw("IF(reservaciones.solicitudes_solicitudes_id != '', 'Sistema', 'Presencial') as tipo_agenda"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->orderBy('reservaciones.id', 'desc')
            ->where('reservaciones.estado_reservacion', 4);

        $anonimos =  DB::table('anonimos')
            ->join('reservaciones', 'reservaciones.id', '=', 'anonimos.reservaciones_id')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("DATE_FORMAT(reservaciones.created_at, '%d/%m/%Y %h:%i %p') as fechaAgendada"),
                'nombre_anonimo as nombre_cliente',
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("IF(reservaciones.estado_reservacion = 4, 'Por Atender', '') as estado_reservacion_nombre"),
                DB::raw("IF(reservaciones.solicitudes_solicitudes_id != '', 'Sistema', 'Presencial') as tipo_agenda"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->orderBy('reservaciones.id', 'desc')
            ->where('reservaciones.estado_reservacion', 4)
            ->unionAll($reservaAtendidos)
            ->get();

        return datatables($anonimos)->toJson();
    }

    //mostrar Reservacion En Espera por Cliente
    public function showReservaciones(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $showReservaciones =  DB::table('reservaciones')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->join('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->join('users as cliente', 'solicitudes.users_users_id', '=', 'cliente.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("DATE_FORMAT(reservaciones.updated_at, '%d/%m/%Y %h:%i %p') as fechaAtendido"),
                DB::raw("CONCAT(cliente.nombre_usuario, ' ',cliente.apellido_usuario) as nombre_cliente"),
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("IF(reservaciones.estado_reservacion = 2, 'Atendida', 'No Asistió') as estado_reservacion_nombre"),
                DB::raw("IF(reservaciones.solicitudes_solicitudes_id != '', 'Sistema', 'Presencial') as tipo_agenda"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->orderBy('reservaciones.id', 'desc')
            ->whereIn('reservaciones.estado_reservacion', [2, 3])
            ->where('reservaciones.users_users_id', Auth::user()->id);

        $anonimos =  DB::table('anonimos')
            ->join('reservaciones', 'reservaciones.id', '=', 'anonimos.reservaciones_id')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("DATE_FORMAT(reservaciones.updated_at, '%d/%m/%Y %h:%i %p') as fechaAtendido"),
                'nombre_anonimo as nombre_cliente',
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("IF(reservaciones.estado_reservacion = 2, 'Atendida', 'No Asistió') as estado_reservacion_nombre"),
                DB::raw("IF(reservaciones.solicitudes_solicitudes_id != '', 'Sistema', 'Presencial') as tipo_agenda"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->orderBy('reservaciones.id', 'desc')
            ->whereIn('reservaciones.estado_reservacion', [2, 3])
            ->where('reservaciones.users_users_id', Auth::user()->id)
            ->unionAll($showReservaciones)
            ->get();

        return datatables($anonimos)->toJson();
    }
    //mostrar Reservacion sheluder
    public function showReservacionesSheluder(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $reservaciones =  DB::table('reservaciones')->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->join('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->join('users as cliente', 'solicitudes.users_users_id', '=', 'cliente.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("(CASE reservaciones.estado_reservacion
                        WHEN 1 THEN 'Por Confirmar'
                        WHEN 2 THEN 'Atendido'
                        WHEN 3 THEN 'No Asistió'
                        WHEN 4 THEN 'En Espera'
                        ELSE 'CANCELO' END) AS estado_reservaciones_nombre"),
                DB::raw("CONCAT(cliente.nombre_usuario, ' ',cliente.apellido_usuario) as nombre_completo_cliente"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%Y-%m-%d') as date"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%H:%i') as startTime"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%H:%i') as endTime")
            )
            ->whereIn('reservaciones.estado_reservacion', [2, 3, 4])
            ->where('users.id', '=', Auth::user()->id);

        $anonimosyreservaciones =  DB::table('anonimos')->join('reservaciones', 'reservaciones.id', '=', 'anonimos.reservaciones_id')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("(CASE reservaciones.estado_reservacion
                                WHEN 1 THEN 'Por Confirmar'
                                WHEN 2 THEN 'Atendido'
                                WHEN 3 THEN 'No Asistió'
                                WHEN 4 THEN 'En Espera'
                                ELSE 'Cancelo' END) AS estado_reservacion_nombre"),
                'nombre_anonimo as nombre_completo_cliente',
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%Y-%m-%d') as date"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%H:%i') as startTime"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%H:%i') as endTime")
            )
            ->whereIn('reservaciones.estado_reservacion', [2, 3, 4])
            ->where('users.id', '=', Auth::user()->id)
            ->unionAll($reservaciones)
            ->get();

        return $anonimosyreservaciones;
    }

    //mostrar Reservacion Clientes atendidos
    public function showAtendidos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $reservaAtendidos =  DB::table('reservaciones')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->join('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->join('users as cliente', 'solicitudes.users_users_id', '=', 'cliente.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("DATE_FORMAT(reservaciones.created_at, '%d/%m/%Y %h:%i %p') as fechaAgendada"),
                DB::raw("DATE_FORMAT(reservaciones.updated_at, '%d/%m/%Y %h:%i %p') as fechaAtendido"),
                DB::raw("CONCAT(cliente.nombre_usuario, ' ',cliente.apellido_usuario) as nombre_cliente"),
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("IF(reservaciones.estado_reservacion = 2, 'Atendida', '') as estado_reservacion_nombre"),
                DB::raw("IF(reservaciones.solicitudes_solicitudes_id != '', 'Sistema', 'Presencial') as tipo_agenda"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->orderBy('reservaciones.id', 'desc')
            ->where('reservaciones.estado_reservacion', 2);

        $anonimos =  DB::table('anonimos')
            ->join('reservaciones', 'reservaciones.id', '=', 'anonimos.reservaciones_id')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("DATE_FORMAT(reservaciones.created_at, '%d/%m/%Y %h:%i %p') as fechaAgendada"),
                DB::raw("DATE_FORMAT(reservaciones.updated_at, '%d/%m/%Y %h:%i %p') as fechaAtendido"),
                'nombre_anonimo as nombre_cliente',
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("IF(reservaciones.estado_reservacion = 2, 'Atendida', '') as estado_reservacion_nombre"),
                DB::raw("IF(reservaciones.solicitudes_solicitudes_id != '', 'Sistema', 'Presencial') as tipo_agenda"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->orderBy('reservaciones.id', 'desc')
            ->where('reservaciones.estado_reservacion', 2)
            ->unionAll($reservaAtendidos)
            ->get();

        return datatables($anonimos)->toJson();
    }

    //mostrar Reservacion Clientes No Asistieron
    public function showNoAsistio(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $reservaNoAsistio =  DB::table('reservaciones')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->join('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->join('users as cliente', 'solicitudes.users_users_id', '=', 'cliente.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("DATE_FORMAT(reservaciones.created_at, '%d/%m/%Y %h:%i %p') as fechaAgendada"),
                DB::raw("DATE_FORMAT(reservaciones.updated_at, '%d/%m/%Y %h:%i %p') as fechaSinAsistir"),
                DB::raw("CONCAT(cliente.nombre_usuario, ' ',cliente.apellido_usuario) as nombre_cliente"),
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("IF(reservaciones.estado_reservacion = 3, 'No Asistió', '') as estado_reservacion_nombre"),
                DB::raw("IF(reservaciones.solicitudes_solicitudes_id != '', 'Sistema', 'Presencial') as tipo_agenda"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->orderBy('reservaciones.id', 'desc')
            ->where('reservaciones.estado_reservacion', 3);

        $anonimos =  DB::table('anonimos')
            ->join('reservaciones', 'reservaciones.id', '=', 'anonimos.reservaciones_id')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("DATE_FORMAT(reservaciones.created_at, '%d/%m/%Y %h:%i %p') as fechaAgendada"),
                DB::raw("DATE_FORMAT(reservaciones.updated_at, '%d/%m/%Y %h:%i %p') as fechaSinAsistir"),
                'nombre_anonimo as nombre_cliente',
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("IF(reservaciones.estado_reservacion = 3, 'No Asistió', '') as estado_reservacion_nombre"),
                DB::raw("IF(reservaciones.solicitudes_solicitudes_id != '', 'Sistema', 'Presencial') as tipo_agenda"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->orderBy('reservaciones.id', 'desc')
            ->where('reservaciones.estado_reservacion', 3)
            ->unionAll($reservaNoAsistio)
            ->get();

        return datatables($anonimos)->toJson();
    }

    //mostrar Reservaciones Canceladas
    public function showCanceladas(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $reservaCancelada =  DB::table('reservaciones')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->join('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->join('users as cliente', 'solicitudes.users_users_id', '=', 'cliente.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("DATE_FORMAT(reservaciones.created_at, '%d/%m/%Y %h:%i %p') as fechaAgendada"),
                DB::raw("DATE_FORMAT(reservaciones.updated_at, '%d/%m/%Y %h:%i %p') as fechaCancelacion"),
                DB::raw("CONCAT(cliente.nombre_usuario, ' ',cliente.apellido_usuario) as nombre_cliente"),
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("IF(reservaciones.estado_reservacion = 5, 'Cancelada', '') as estado_reservacion_nombre"),
                DB::raw("IF(reservaciones.solicitudes_solicitudes_id != '', 'Sistema', 'Presencial') as tipo_agenda"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->orderBy('reservaciones.id', 'desc')
            ->where('reservaciones.estado_reservacion', 5);

        $anonimos =  DB::table('anonimos')
            ->join('reservaciones', 'reservaciones.id', '=', 'anonimos.reservaciones_id')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("DATE_FORMAT(reservaciones.created_at, '%d/%m/%Y %h:%i %p') as fechaAgendada"),
                DB::raw("DATE_FORMAT(reservaciones.updated_at, '%d/%m/%Y %h:%i %p') as fechaCancelacion"),
                'nombre_anonimo as nombre_cliente',
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("IF(reservaciones.estado_reservacion = 5, 'Cancelada', '') as estado_reservacion_nombre"),
                DB::raw("IF(reservaciones.solicitudes_solicitudes_id != '', 'Sistema', 'Presencial') as tipo_agenda"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->orderBy('reservaciones.id', 'desc')
            ->where('reservaciones.estado_reservacion', 5)
            ->unionAll($reservaCancelada)
            ->get();

        return datatables($anonimos)->toJson();
    }

    //listar sheluders
    public function listar(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax
        //trae las que sean diferentes al estado 5 osea al cancelado
        $reservaciones =  DB::table('reservaciones')->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->join('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->join('users as cliente', 'solicitudes.users_users_id', '=', 'cliente.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("CONCAT(cliente.nombre_usuario, ' ',cliente.apellido_usuario) as nombre_completo_cliente"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%Y-%m-%d') as date"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%H:%i') as startTime"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%H:%i') as endTime"),
                DB::raw("(CASE reservaciones.estado_reservacion
                                                       WHEN 1 THEN 'Por Confirmar'
                                                       WHEN 2 THEN 'Atendido'
                                                       WHEN 3 THEN 'No Asistió'
                                                       WHEN 4 THEN 'En Espera'
                                                       ELSE 'Cancelo' END) AS estado_reservacion_nombre")
            )
            ->where([
                ['reservaciones.estado_reservacion', '<>', '5'],
                ['users.id', '=', $request->empleadoID],
            ]);



        $anonimosyreservaciones =  DB::table('anonimos')->join('reservaciones', 'reservaciones.id', '=', 'anonimos.reservaciones_id')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                'nombre_anonimo as nombre_completo_cliente',
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%Y-%m-%d') as date"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%H:%i') as startTime"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%H:%i') as endTime"),
                DB::raw("(CASE reservaciones.estado_reservacion
                                                        WHEN 1 THEN 'Por Confirmar'
                                                        WHEN 2 THEN 'Atendido'
                                                        WHEN 3 THEN 'No Asistió'
                                                        WHEN 4 THEN 'En Espera'
                                                        ELSE 'Cancelo' END) AS estado_reservacion_nombre")
            )
            ->where([
                ['reservaciones.estado_reservacion', '<>', '5'],
                ['users.id', '=', $request->empleadoID],
            ])
            ->unionAll($reservaciones)
            ->get();


        return $anonimosyreservaciones;
    }
    //listar todo para agenda anonima
    public function listarTodo(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax
        //trae las que sean diferentes al estado 5 osea al cancelado
        $reservaciones =  DB::table('reservaciones')->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->join('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->join('users as cliente', 'solicitudes.users_users_id', '=', 'cliente.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                DB::raw("CONCAT(cliente.nombre_usuario, ' ',cliente.apellido_usuario) as nombre_completo_cliente"),
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%Y-%m-%d') as date"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%H:%i') as startTime"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%H:%i') as endTime"),
                DB::raw("(CASE reservaciones.estado_reservacion
                                                        WHEN 1 THEN 'Por Confirmar'
                                                        WHEN 2 THEN 'Atendido'
                                                        WHEN 3 THEN 'No Asistió'
                                                        WHEN 4 THEN 'En Espera'
                                                        ELSE 'Cancelo' END) AS estado_reservacion_nombre")
            )
            ->where([
                ['reservaciones.estado_reservacion', '<>', '5'],
                ['users.id', '=', $request->empleadoID]
            ]);


        $anonimos =  DB::table('anonimos')->join('reservaciones', 'reservaciones.id', '=', 'anonimos.reservaciones_id')
            ->join('users', 'reservaciones.users_users_id', '=', 'users.id')
            ->select(
                'reservaciones.id',
                'reservaciones.estado_reservacion',
                'nombre_anonimo as nombre_completo_cliente',
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_completo_empleado"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%Y-%m-%d') as date"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%H:%i') as startTime"),
                DB::raw("DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%H:%i') as endTime"),
                DB::raw("(CASE reservaciones.estado_reservacion
                                                        WHEN 1 THEN 'Por Confirmar'
                                                        WHEN 2 THEN 'Atendido'
                                                        WHEN 3 THEN 'No Asistió'
                                                        WHEN 4 THEN 'En Espera'
                                                        ELSE 'Cancelo' END) AS estado_reservacion_nombre")
            )
            ->where([
                ['reservaciones.estado_reservacion', '<>', '5'],
                ['users.id', '=', $request->empleadoID]
            ])
            ->unionAll($reservaciones)
            ->get();

        return $anonimos;
    }

    public function listarAnonimas(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $anonimas = DB::table('anonimos')
            ->join('reservaciones', 'reservaciones.id', '=', 'anonimos.reservaciones_id')
            ->select(
                'reservaciones.id as id',
                'anonimos.nombre_anonimo as nombre_completo_cliente',
                'anonimos.celular_anonimo as celular',
                'anonimos.notas_anonimo as notas',
                DB::raw("(CASE reservaciones.estado_reservacion
                                WHEN 1 THEN 'Por Confirmar'
                                WHEN 2 THEN 'Atendido'
                                WHEN 3 THEN 'No Asistió'
                                WHEN 4 THEN 'En Espera'
                                ELSE 'Cancelo' END) AS estado_reservacion_nombre"),
                DB::raw("CONCAT(DATE_FORMAT(reservaciones.fechaHoraInicio_reserva, '%d/%m/%Y %h:%i %p'),' a ',
                        DATE_FORMAT(reservaciones.fechaHoraFinal_reserva, '%h:%i %p')) as fecha_reserva")
            )
            ->whereIn('reservaciones.estado_reservacion', [1, 4])
            ->orderBy('reservaciones.id', 'desc')
            ->get();

        return datatables($anonimas)
            ->toJson();
    }

    //cancelar reservacion o enemilar da igual a efecto visual
    public function cancelar(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        return DB::transaction(function () use ($request) {
            //actualiazar el estado del la reservacion a cancelada
            //CANCELO = 5
            $reservaciones = Reservacione::findOrFail($request->id);
            $reservaciones->estado_reservacion = '5';
            $reservaciones->save();
            //Actualizar estado de la solicitud a agendada
            //APENDIENTE = 1 es por si se equivocan en la solicitud la puedan volver a agendar(discutir en el grupo esto)
            if ($reservaciones->solicitudes_solicitudes_id != null) {
                $solicitudes = Solicitude::findOrFail($reservaciones->solicitudes_solicitudes_id);
                $solicitudes->estado_solicitud = '1';
                $solicitudes->save();
            }
        });
    }
    //Marcar como cliente asistio a la cita
    public function clienteAsistio(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        return DB::transaction(function () use ($request) {
            //actualiazar el estado del la reservacion
            //ATENTIDO = 2
            $reservaciones = Reservacione::findOrFail($request->id);

            if ($request->id != '' and $reservaciones->solicitudes_solicitudes_id != '') {
                $reservaciones->estado_reservacion = '2';
                $reservaciones->save();

                //Actualizar estado de la solicitud
                //ATENDIDA = 5
                $solicitudes = Solicitude::findOrFail($reservaciones->solicitudes_solicitudes_id);
                $solicitudes->estado_solicitud = '5';
                $solicitudes->save();
            } else {
                //$reservaciones = Reservacione::findOrFail($request->id);
                $reservaciones->estado_reservacion = '2';
                $reservaciones->save();
            }
        });
    }
    //marcar como cliente no Asistio o no fue atendido
    public function clienteNoAsistio(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        return DB::transaction(function () use ($request) {
            //actualiazar el estado del la reservacion
            //NOASISTIO = 3
            $reservaciones = Reservacione::findOrFail($request->id);

            if ($request->id != '' and $reservaciones->solicitudes_solicitudes_id != '') {
                $reservaciones->estado_reservacion = '3';
                $reservaciones->save();
                //Actualizar estado de la solicitud a agendada
                //NOASISTIO = 6
                $solicitudes = Solicitude::findOrFail($reservaciones->solicitudes_solicitudes_id);
                $solicitudes->estado_solicitud = '6';
                $solicitudes->save();
            } else {
                //$reservaciones = Reservacione::findOrFail($request->id);
                $reservaciones->estado_reservacion = '3';
                $reservaciones->save();
            }
        });
    }
    //Confirmar la reservacion y agendado del lado de Admin
    public function clienteConfirmar(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        return DB::transaction(function () use ($request) {
            //actualiazar el estado del la reservacion
            //ENESPERA = 4
            $reservaciones = Reservacione::findOrFail($request->id);
            $reservaciones->estado_reservacion = '4';
            $reservaciones->save();
            //Actualizar estado de la solicitud a agendada
            //AGENDADA = 2
            $solicitudes = Solicitude::findOrFail($request->solicitudId);
            $solicitudes->estado_solicitud = '2';
            $solicitudes->save();
        });
    }
}
