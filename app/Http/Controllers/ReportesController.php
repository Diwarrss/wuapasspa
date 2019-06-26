<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;// para hacer transacciones seguras a la db
use App\Solicitude;

class ReportesController extends Controller
{
    //citas en general
    public function showCitasMes(Request $request){
        if (!$request->ajax()) return redirect('/');
        //capturamos año actual
        $year= date('Y');

        $citasMes = DB::table('solicitudes')
                    ->select(DB::raw("count(created_at) as cantidad"),
                        DB::raw("DATE_FORMAT(created_at, '%m') as month"),
                        DB::raw("YEAR(created_at) as year"))
                    //->whereYear('created_at', $year)
                    ->where('estado_solicitud', '<>', 3)
                    ->groupBy('month')
                    ->get();

        return $citasMes;
    }
    //citas atendidas al mes
    public function showCitasAtendidas(Request $request){
        if (!$request->ajax()) return redirect('/');
        //capturamos año actual
        $year= date('Y');

        $citasMes = DB::table('solicitudes')
                    ->select(DB::raw("count(created_at) as cantidad"),
                        DB::raw("DATE_FORMAT(created_at, '%m') as month"),
                        DB::raw("YEAR(created_at) as year"))
                    ->whereYear('created_at', $year)
                    ->where('estado_solicitud', '=', 5)
                    ->groupBy('month')
                    ->get();

        return $citasMes;
    }
    //citas sin Asistir al mes
    public function showCitasNoAsis(Request $request){
        if (!$request->ajax()) return redirect('/');
        //capturamos año actual
        $year= date('Y');

        $citasMes = DB::table('solicitudes')
                    ->select(DB::raw("count(created_at) as cantidad"),
                        DB::raw("DATE_FORMAT(created_at, '%m') as month"),
                        DB::raw("YEAR(created_at) as year"))
                    ->whereYear('created_at', $year)
                    ->where('estado_solicitud', '=', 6)
                    ->groupBy('month')
                    ->get();

        return $citasMes;
    }
    //Reservaciones Atendidas por empleado
    public function showReservacionEmpleado(Request $request){
        if (!$request->ajax()) return redirect('/');
        //capturamos año actual
        $year= date('Y');

        $citasMes = DB::table('reservaciones')
                    ->join('users', 'reservaciones.users_users_id','=','users.id')
                    ->select(DB::raw("count(reservaciones.id) as cantidad"),
                        DB::raw("users.nombre_usuario as nombre"))
                    ->where('estado_reservacion', '=', 2)
                    ->groupBy('nombre')
                    ->get();

        return $citasMes;
    }

    //Reservaciones Atendidas por empleado
    public function showServices(Request $request){
        if (!$request->ajax()) return redirect('/');
        //capturamos año actual
        $year= date('Y');

        $servicios = DB::table('servicios')
                    ->join('servicios_solicitudes', 'servicios.id','=','servicios_solicitudes.servicios_servicios_id')
                    ->select(DB::raw("count(servicios.id) as cantidad"),
                        DB::raw("servicios.nombre_servicio as nombre"))
                    ->groupBy('nombre')
                    ->get();

        return $servicios;
    }
}
