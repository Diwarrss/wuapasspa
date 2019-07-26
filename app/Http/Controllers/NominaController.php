<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetalleFactura;
use Illuminate\Support\Facades\DB;
use App\Nomina;
use Illuminate\Support\Facades\Auth;
use App\Movimiento;
use App\Caja;

class NominaController extends Controller
{
    public function listarEmpleadosNomina(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax
        $empleadosNomina = DetalleFactura::join('users as empleado', 'detalle_facturas.empleado_id', '=', 'empleado.id')
            ->join('facturas', 'facturas.id', '=', 'detalle_facturas.facturas_id')
            ->select(
                'detalle_facturas.empleado_id',
                DB::raw("CONCAT(empleado.nombre_usuario, ' ',empleado.apellido_usuario) as nombre_empleado,
                    SUM((detalle_facturas.valor_servicio * detalle_facturas.cantidad_facturada)-detalle_facturas.valor_descuento) as valor_total_servicios,
                    SUM(detalle_facturas.cantidad_facturada) as cantidad_servicios, min(detalle_facturas.created_at) as minFecha,max(detalle_facturas.created_at) as maxFecha")
            )
            ->groupBy('detalle_facturas.empleado_id')
            ->where([
                ['detalle_facturas.nomina_id', null], ['facturas.estado_factura', [1, 2]]
            ])
            ->get();

        return datatables($empleadosNomina)->toJson();
    }

    //realizar el pago de la nomina a Empleado
    public function pagarNomina(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();

            $newMovimiento = new Movimiento();
            $newMovimiento->caja_id = $request->id_caja;
            $newMovimiento->valor_movimiento = $request->valor_pagado;
            $newMovimiento->valor_pendiente = 0;
            $newMovimiento->tipo_movimiento = 2; //para q sea un egreso gasto
            $newMovimiento->save();

            //obtenemos el valor producido y de gastos de la caja por el ID con first
            //$valorProducido = Caja::select('valor_producido')->where('id', $request->id_caja)->first();
            $valorGastos = Caja::select('valor_gastos')->where('id', $request->id_caja)->first();
            //actualizar el valor de gastos y producido caja
            $updateCaja = Caja::find($request->id_caja);
            //restamos el valor consultado menos el valor de la factura
            //$updateCaja->valor_producido = $valorProducido->valor_producido - $request->valor_pagado;
            $updateCaja->valor_gastos = $valorGastos->valor_gastos + $request->valor_pagado;
            $updateCaja->save();

            //creamos el registro en Nominas
            $newNomina = new Nomina();
            $newNomina->realizado_por = Auth::user()->id;
            $newNomina->pagado_a = $request->empleado_id;
            $newNomina->movimientos_id = $newMovimiento->id;
            $newNomina->porcentaje_pagado = $request->porcentaje_pagado;
            $newNomina->valor_pagado = $request->valor_pagado;
            $newNomina->valor_total = $request->valor_total_servicios;
            $newNomina->estado_nomina = 1;
            $newNomina->save();

            DB::table('detalle_facturas')
                ->where([['empleado_id', $request->empleado_id], ['nomina_id', null]])
                ->update(['nomina_id' => $newNomina->id]);

            DB::commit(); //se ahce el commit pa update base datos
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function listarPagosNomina(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $empleadosNomina = Nomina::join('detalle_facturas', 'detalle_facturas.nomina_id', '=', 'nominas.id')
            ->groupBy('nominas.id')
            ->get();

        return datatables($empleadosNomina)->toJson();
    }
}
