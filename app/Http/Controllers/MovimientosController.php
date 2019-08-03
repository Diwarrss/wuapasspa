<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\FacturaGastos;

class MovimientosController extends Controller
{
    public function totalGastosDiarios(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $fechahoy = Carbon::now()->format('Y-m-d');

        $cont = FacturaGastos::where([['estado_fact', 1], ['created_at', 'like', '%' . $fechahoy . '%']])
            ->sum('valor_neto');

        return $cont;
    }
}
