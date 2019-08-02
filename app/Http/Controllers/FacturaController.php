<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Reservacione;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Servicios_solicitudes;
use Carbon\Carbon;
use App\DetalleFactura;
use App\Movimiento;
use Carbon\Carbon as CarbonCarbon;
use App\Caja;
use App\FacturaAnulada;
use Barryvdh\DomPDF\PDF;
use App\Empresa;
use App\FacturaGastos;

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

    public function listarFacturacionDiaria(Request $request)
    {
        //if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $fechahoy = Carbon::now()->format('Y-m-d');

        $listarFacturar = DB::table('facturas')
            ->join('reservaciones', 'facturas.id', '=', 'reservaciones.facturas_id')
            ->join('detalle_facturas', 'detalle_facturas.facturas_id', '=', 'facturas.id')
            ->join('movimientos', 'movimientos.factura_id', '=', 'facturas.id')
            ->leftJoin('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->leftJoin('users', 'solicitudes.users_users_id', '=', 'users.id')
            ->leftJoin('anonimos', 'anonimos.reservaciones_id', '=', 'reservaciones.id')
            ->select(
                'facturas.id as id_factura',
                'movimientos.id as id_movimiento',
                'reservaciones.id as id_reserva',
                DB::raw("CONCAT(facturas.prefijo,facturas.numero_factura) as num_factura"),
                DB::raw("DATE_FORMAT(facturas.created_at, '%d/%m/%Y %h:%i %p') as fecha_factura"),
                'anonimos.nombre_anonimo',
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_cliente"),
                'facturas.valor_total',
                'facturas.valor_descuento',
                'facturas.estado_factura',
                DB::raw("MAX(detalle_facturas.nomina_id) as nomina_id")
            )
            ->where([
                ['movimientos.estado', 1],
                ['facturas.created_at', 'like', '%' . $fechahoy . '%']
            ])
            ->groupBy('detalle_facturas.facturas_id')
            //->orderByDesc('facturas.id')
            ->get();

        return datatables($listarFacturar)->toJson();
    }

    public function historialFacturas()
    {
        //if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $listarFacturar = DB::table('facturas')
            ->join('detalle_facturas', 'detalle_facturas.facturas_id', '=', 'facturas.id')
            ->join('movimientos', 'movimientos.factura_id', '=', 'facturas.id')
            ->leftjoin('reservaciones', 'facturas.id', '=', 'reservaciones.facturas_id')
            ->leftjoin('factura_anuladas', 'factura_anuladas.facturas_id', '=', 'facturas.id')
            ->leftJoin('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->leftJoin('users', 'solicitudes.users_users_id', '=', 'users.id')
            ->leftJoin('anonimos', 'anonimos.reservaciones_id', '=', 'reservaciones.id')
            ->select(
                'facturas.id as id_factura',
                'movimientos.id as id_movimiento',
                'factura_anuladas.nombre_cliente as nomCliente_anulada',
                DB::raw("DATE_FORMAT(factura_anuladas.created_at, '%d/%m/%Y %h:%i %p') as fecha_anulacion"),
                'reservaciones.id as id_reserva',
                DB::raw("CONCAT(facturas.prefijo,facturas.numero_factura) as num_factura"),
                DB::raw("DATE_FORMAT(facturas.created_at, '%d/%m/%Y %h:%i %p') as fecha_factura"),
                'anonimos.nombre_anonimo',
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_cliente"),
                'facturas.valor_total',
                'facturas.estado_factura',
                DB::raw("MAX(detalle_facturas.nomina_id) as nomina_id")
            )
            ->groupBy('detalle_facturas.facturas_id')
            ->get();

        return datatables($listarFacturar)->toJson();
    }

    public function mostrarInfoFacturar(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

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
                DB::raw("'1' as cantidad, '0' as valor_descuento")
            )
            ->where('reservaciones.id', '=', $id_reserva)
            ->get();
        //devuelvo un json que se llamara lista
        return $listarDetFacturar;
    }

    public function facturarCargos(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax
        //para generear la transacccion
        try {
            DB::beginTransaction();

            // Obtenemos el la ultima factura por fecha de creacion
            $lastOrder = Factura::orderBy('created_at', 'desc')->first();

            if (!$lastOrder) {
                //si no hay ningun order pos dejamos  number en 0 al final sera 1
                $number = 0;
            } else {
                //obtenemos el ultimo numero de la factura y le sumamos 1
                $number = $lastOrder->numero_factura;
            }
            $numFactura = $number + 1; // sprintf('%06d', intval($number) + 1);

            $facturas = new Factura();
            $facturas->prefijo = $request->prefijo;
            $facturas->numero_factura = $numFactura;
            $facturas->tipo_comprobante = $request->tipo_comprobante;
            $facturas->creado_por = Auth::user()->id;
            $facturas->estado_factura = $request->estado_factura;
            $facturas->tipo_pago = $request->tipo_pago;
            $facturas->valor_descuento = $request->descuento;
            $facturas->valor_total = $request->valor_total;
            $facturas->nota_factura = $request->nota_factura;
            $facturas->save();

            //se captura el id de la reserva a actualizar el id_factura
            $reserva = Reservacione::find($request->id_reserva);
            $reserva->facturas_id = $facturas->id; //colocamos el id de la factura creada
            $reserva->save();

            //creamos el movimiento de la factura hacia la caja
            $movimiento = new Movimiento();
            $movimiento->factura_id = $facturas->id;
            $movimiento->caja_id = $request->id_caja;
            $movimiento->valor_movimiento = $request->valor_total;
            $movimiento->valor_pendiente = 0;
            $movimiento->tipo_movimiento = 1; //para q sea un ingreso
            $movimiento->estado = 1;
            $movimiento->save();

            //actualizamos la caja asociada del usuario obtenemos el valor producido Actual de la caja por el ID con first
            $valorProducido = Caja::select('valor_producido')->where('id', $request->id_caja)->first();
            //actualizar valor de la caja actual menos el que anulo
            $updateCaja = Caja::find($request->id_caja);
            //restamos el valor consultado menos el valor de la factura
            $updateCaja->valor_producido = $valorProducido->valor_producido + $request->valor_total;
            $updateCaja->save();

            //se recibe lo que se tiene en la propiedad informacionFacturar array detalles
            $detalles = $request->informacionFacturar;

            foreach ($detalles as $key => $det) {
                $detalle = new DetalleFactura(); //creamos el objeto detalle q hace referencia al modelo detallefactura
                $detalle->facturas_id = $facturas->id;
                $detalle->servicios_servicios_id = $det['id_servicio'];
                $detalle->empleado_id = $det['id_atendido_por'];
                $detalle->cantidad_facturada = $det['cantidad'];
                $detalle->valor_servicio = $det['valor_servicio'];
                $detalle->valor_descuento = $det['valor_descuento'];
                $detalle->save();
            }

            DB::commit(); //se ahce el commit pa update base datos
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    //para anular las facturas
    public function anularFactura(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //para validar
        $request->validate([
            'motivo_anulacion' => 'required|max:350'
        ]);

        try {
            DB::beginTransaction();
            $anular = Factura::find($request->id_factura);
            $anular->estado_factura = 4;
            $anular->save();

            //quitar de la reservacion solicitada
            $reservaLiberar = Reservacione::find($request->id_reserva);
            $reservaLiberar->facturas_id = null;
            $reservaLiberar->save();

            //creamos registro de factura anulada
            $facturaAnulada = new FacturaAnulada();
            $facturaAnulada->facturas_id = $request->id_factura;
            $facturaAnulada->anulado_por = $request->id_facturadopor;
            $facturaAnulada->descripcion = $request->motivo_anulacion;
            $facturaAnulada->nombre_cliente = $request->nombre_cliente;
            $facturaAnulada->save();

            //Hay que anular el movimiento anterior
            $anularMovimiento = Movimiento::find($request->id_movimiento);
            $anularMovimiento->estado = 2;
            $anularMovimiento->save();

            /* //creamos el registro del movimiento tipo egreso al anular
            $movimiento = new Movimiento();
            $movimiento->factura_id = $request->id_factura;
            $movimiento->caja_id = $request->id_caja;
            $movimiento->valor_movimiento = $request->valor_total;
            $movimiento->valor_pendiente = 0;
            $movimiento->tipo_movimiento = 2; //para q sea un egreso anulacion
            $movimiento->estado = 1;
            $movimiento->save(); */

            //obtenemos el valor producido de la caja por el ID con first
            $valorProducido = Caja::select('valor_producido')->where('id', $request->id_caja)->first();
            //actualizar valor de la caja actual menos el que anulo
            $updateCaja = Caja::find($request->id_caja);
            //restamos el valor consultado menos el valor de la factura
            $updateCaja->valor_producido = $valorProducido->valor_producido - $request->valor_total;
            $updateCaja->save();

            DB::commit(); //se ahce el commit pa update base datos
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    //Funcion para generar informacion factura pdf
    public function pdfFacturaServicios(Request $request, $id_factura)
    {
        $factura = Factura::join('reservaciones', 'facturas.id', '=', 'reservaciones.facturas_id')
            ->leftJoin('solicitudes', 'reservaciones.solicitudes_solicitudes_id', '=', 'solicitudes.id')
            ->leftJoin('users', 'solicitudes.users_users_id', '=', 'users.id')
            ->leftJoin('anonimos', 'anonimos.reservaciones_id', '=', 'reservaciones.id')
            ->join('users as facturador', 'facturador.id', '=', 'facturas.creado_por')
            ->select(
                DB::raw("CONCAT(facturas.prefijo,facturas.numero_factura) as numero_factura"),
                DB::raw("DATE_FORMAT(facturas.created_at, '%d/%m/%Y %h:%i %p') as fecha_factura"),
                DB::raw("CONCAT(users.nombre_usuario, ' ',users.apellido_usuario) as nombre_cliente"),
                DB::raw("CONCAT(facturador.nombre_usuario, ' ',facturador.apellido_usuario) as nombre_facturador"),
                'facturas.valor_descuento',
                'facturas.valor_total',
                'facturas.estado_factura',
                'facturas.created_at',
                'users.celular',
                'anonimos.nombre_anonimo',
                'anonimos.celular_anonimo'
            )
            ->where('facturas.id', $id_factura)->get();

        $detalleFactura = DetalleFactura::join("servicios", 'servicios.id', '=', 'detalle_facturas.servicios_servicios_id')
            ->select(
                'servicios.nombre_servicio',
                DB::raw('SUM(detalle_facturas.valor_descuento) as valor_descuento, SUM(detalle_facturas.cantidad_facturada) as cantidad_facturada,
                SUM(detalle_facturas.valor_servicio) as valor_servicios')
            )
            ->groupBy('servicios.nombre_servicio')
            ->where("detalle_facturas.facturas_id", $id_factura)->get();

        //informacion empresa
        $empresa = Empresa::all();

        /* $cantServicios = DetalleFactura::select(
            DB::raw("SUM(cantidad_facturada) as cant_facturada")
        )
            ->groupBy('facturas_id')
            ->where("facturas_id", $id_factura)->get(); */

        $pdf = \PDF::loadView('dompdf.factura', ['factura' => $factura, 'detalleFactura' => $detalleFactura, 'empresa' => $empresa]);
        $pdf->setPaper(array(0, 0, 250, 700)); //SE PERSONALIZA EL TAMAÑO DEL PAPEL
        //retornamos el pdf en view del navegador
        return $pdf->stream('ticketVenta  -' . $factura[0]->numero_factura . '.pdf');
    }

    public function pdfFacturaAnulServicios(Request $request, $id_factura)
    {
        $factura = Factura::join('factura_anuladas', 'facturas.id', '=', 'factura_anuladas.facturas_id')
            ->join('users as anuladopor', 'anuladopor.id', '=', 'factura_anuladas.anulado_por')
            ->join('users as facturador', 'facturador.id', '=', 'facturas.creado_por')
            ->select(
                DB::raw("CONCAT(facturas.prefijo,facturas.numero_factura) as numero_factura"),
                DB::raw("DATE_FORMAT(facturas.created_at, '%d/%m/%Y %h:%i %p') as fecha_factura"),
                DB::raw("CONCAT(facturador.nombre_usuario, ' ',facturador.apellido_usuario) as nombre_facturador"),
                DB::raw("CONCAT(anuladopor.nombre_usuario, ' ',anuladopor.apellido_usuario) as nombre_anuladopor"),
                'facturas.valor_descuento',
                'facturas.valor_total',
                'facturas.estado_factura',
                'facturas.created_at',
                'factura_anuladas.nombre_cliente'
            )
            ->where('facturas.id', $id_factura)->get();

        $detalleFactura = DetalleFactura::join("servicios", 'servicios.id', '=', 'detalle_facturas.servicios_servicios_id')
            ->select(
                'servicios.nombre_servicio',
                DB::raw('SUM(detalle_facturas.valor_descuento) as valor_descuento, SUM(detalle_facturas.cantidad_facturada) as cantidad_facturada,
                SUM(detalle_facturas.valor_servicio) as valor_servicios')
            )
            ->groupBy('servicios.nombre_servicio')
            ->where("detalle_facturas.facturas_id", $id_factura)->get();

        //informacion empresa
        $empresa = Empresa::all();

        /* $cantServicios = DetalleFactura::select(
            DB::raw("SUM(cantidad_facturada) as cant_facturada")
        )
            ->groupBy('facturas_id')
            ->where("facturas_id", $id_factura)->get(); */

        $pdf = \PDF::loadView('dompdf.facturaAnulada', ['factura' => $factura, 'detalleFactura' => $detalleFactura, 'empresa' => $empresa]);
        $pdf->setPaper(array(0, 0, 250, 700)); //SE PERSONALIZA EL TAMAÑO DEL PAPEL
        //retornamos el pdf en view del navegador
        return $pdf->stream('ticketVenta  -' . $factura[0]->numero_factura . '.pdf');
    }

    //crear factura de gastos
    public function crearFacturaGastos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //para validar
        $request->validate([
            'valor_gasto' => 'required|max:12|regex:/^\d+(\.\d{1,2})?$/',
            'descripcion_gasto' => 'required|max:350'
        ]);

        try {
            DB::beginTransaction();

            //creamos el registro del movimiento tipo egreso al Registrar gasto
            $movimiento = new Movimiento();
            $movimiento->caja_id = $request->id_caja;
            $movimiento->valor_movimiento = $request->valor_gasto;
            $movimiento->valor_pendiente = 0;
            $movimiento->tipo_movimiento = 2; //para q sea un egreso al ser gasto
            $movimiento->estado = 1;
            $movimiento->save();

            // Obtenemos el la ultima factura por fecha de creacion
            $lastOrder = FacturaGastos::orderBy('created_at', 'desc')->first();
            if (!$lastOrder) {
                //si no hay ningun order pos dejamos  number en 0 al final sera 1
                $number = 0;
            } else {
                //obtenemos el ultimo numero de la factura y le sumamos 1
                $number = $lastOrder->numero_factura;
            }
            $numFactura = $number + 1;

            //creamos la factura de gastos
            $crearFact = new FacturaGastos();
            $crearFact->prefijo = $request->prefijo;
            $crearFact->numero_factura = $numFactura;
            $crearFact->creado_por = Auth::user()->id;
            $crearFact->movimiento_id = $movimiento->id;
            $crearFact->valor_neto = $request->valor_gasto;
            $crearFact->descripcion = $request->descripcion_gasto;
            $crearFact->estado_fact = 1;
            $crearFact->save();

            //obtenemos el valor producido de la caja por el ID con first
            $valorProducido = Caja::select('valor_producido')->where('id', $request->id_caja)->first();
            //actualizar valor de la caja actual menos el que anulo
            $updateCaja = Caja::find($request->id_caja);
            //restamos el valor consultado menos el valor de la factura
            $updateCaja->valor_producido = $valorProducido->valor_producido - $request->valor_gasto;
            $updateCaja->save();

            DB::commit(); //se ahce el commit pa update base datos
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function listarGastosDiarios(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $fechahoy = Carbon::now()->format('Y-m-d');

        $listarGastosD = FacturaGastos::join('users as creadopor', 'creadopor.id', '=', 'factura_gastos.creado_por')
            ->select(
                'factura_gastos.estado_fact',
                'factura_gastos.movimiento_id',
                'factura_gastos.valor_neto',
                'factura_gastos.descripcion',
                DB::raw("CONCAT(factura_gastos.prefijo,factura_gastos.numero_factura) as num_factura"),
                DB::raw("CONCAT(creadopor.nombre_usuario, ' ',creadopor.apellido_usuario) as nombre_creadopor"),
                DB::raw("DATE_FORMAT(factura_gastos.created_at, '%d/%m/%Y %h:%i %p') as fecha_factura")
            )
            ->where([['factura_gastos.estado_fact', 1], ['factura_gastos.created_at', 'like', '%' . $fechahoy . '%']])->get();

        return datatables($listarGastosD)->toJson();
    }
    //lista de servicios para mostrar como descripcion de la factura
    public function verInfoFactura(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $id_factura = $request->id_factura;

        $factura = Factura::join('detalle_facturas', 'facturas.id', '=', 'detalle_facturas.facturas_id')
            ->join('servicios', 'servicios.id', '=', 'detalle_facturas.servicios_servicios_id')
            ->join('users as empleado', 'empleado.id', '=', 'detalle_facturas.empleado_id')
            ->select(
                'servicios.nombre_servicio',
                DB::raw("CONCAT(facturas.prefijo,facturas.numero_factura) as numero_factura"),
                DB::raw("CONCAT(empleado.nombre_usuario, ' ',empleado.apellido_usuario) as empleado,
                SUM(detalle_facturas.cantidad_facturada) as cantidad_facturada, SUM(detalle_facturas.valor_descuento) as valor_descuento,
                SUM(detalle_facturas.valor_servicio) as valor_total")
            )
            ->where('facturas.id', $id_factura)
            ->groupBy('servicios.nombre_servicio')
            ->get();

        return $factura;
    }
}
