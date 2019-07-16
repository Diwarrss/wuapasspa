<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Reservacione;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Servicios_solicitudes;

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
            ->where([['reservaciones.estado_reservacion', 2], ['reservaciones.facturas_id', null]])
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

    public function facturarCargos(Request $request)
    {
        //if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax
        //para validar
        /*$request->validate([

            'servicios' => 'required',
            'fecha_probable' => 'required',
            'comentario' => 'required'
        ]);*/
        //para generear la transacccion
        return DB::transaction(function () use ($request) {
            $saberUltimoFactura = Factura::orderBy('numero_factura', 'desc')->first()->id;
            //saber el ultimo
            //$ultimo = $saberUltimoFactura->last();
            $numFactura = $saberUltimoFactura + 1;

            $facturas = new Factura();
            $facturas->prefijo = $request->prefijo;
            $facturas->numero_factura = $numFactura;
            $facturas->tipo_comprobante = $request->tipo_comprobante;
            $facturas->creado_por = Auth::user()->id;
            $facturas->estado_factura = $request->estado_factura;
            $facturas->tipo_pago = $request->tipo_pago;
            $facturas->valor_descuento = $request->valor_descuento;
            $facturas->valor_total = $request->valor_total;
            $facturas->nota_factura = $request->nota_factura;
            $facturas->save();

            foreach ($request->informacionFacturar as $informacionFacturar) {
                $informacionFacturar = Servicios_solicitudes::findOrFail($informacionFacturar->id_solicitud);
                $informacionFacturar->facturas_id = $facturas->numero_factura;
                $informacionFacturar->empleado_id = $informacionFacturar->id_atendido_por;
                $informacionFacturar->reservaciones_id = $informacionFacturar->id_reserva;
                $informacionFacturar->cantidad_facturada = $informacionFacturar->cantidad;
            }
        });
    }
}
