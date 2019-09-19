<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdenController extends Controller
{
    //enlistar ordenes para facturacion
    public function listarOrdenes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $ordenes = \App\Orden::join('users as cliente', 'ordens.cliente', '=', 'cliente.id')
            ->select(
                'ordens.id as idOrden',
                'ordens.created_at',
                'ordens.prefijo',
                'ordens.numero_orden',
                'cliente.nombre_usuario',
                'cliente.apellido_usuario'
            )
            ->where('estado_orden', 2)->get();

        return $ordenes;
    }
    //esta madre falta hacerla en la base de datos x ahora solo visual
    public function guardarOrdenes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $detalle = $request->detalle;
        $detalle["guardado"] = 1;
        $detalle["desabilitado"] = true;
        return $detalle;
    }
    public function eliminarArticulo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $eliminado = "true";
        return $eliminado;
    }
}
