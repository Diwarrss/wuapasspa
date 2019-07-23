<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetalleFactura;
use Illuminate\Support\Facades\DB;

class NominaController extends Controller
{
    public function listarEmpleadosNomina(Request $request)
    {
        //if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax
        $empleadosNomina = DetalleFactura::join('users as empleado', 'detalle_facturas.empleado_id', '=', 'empleado.id')
            ->join('facturas', 'facturas.id', '=', 'detalle_facturas.facturas_id')
            ->select(
                'detalle_facturas.empleado_id',
                DB::raw("CONCAT(empleado.nombre_usuario, ' ',empleado.apellido_usuario) as nombre_empleado,
                    SUM(detalle_facturas.valor_servicio * detalle_facturas.cantidad_facturada) as valor_total_servicios,
                    SUM(detalle_facturas.cantidad_facturada) as cantidad_servicios")
            )
            ->groupBy('detalle_facturas.empleado_id')
            ->where([
                ['detalle_facturas.nomina_id', null], ['facturas.estado_factura', [1, 2]],
                ['facturas.tipo_comprobante', 1]
            ])
            ->get();

        return datatables($empleadosNomina)->toJson();
    }
}
