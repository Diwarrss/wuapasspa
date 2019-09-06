<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdenController extends Controller
{
    //enlistar ordenes para facturacion
    public function listarOrdenes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $ordenes = \App\Orden::where('estado_orden', 2)->get();

        return $ordenes;
    }
}
