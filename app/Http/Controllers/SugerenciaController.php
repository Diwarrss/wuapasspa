<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sugerencia; //importa el model de Sugerencia
use Illuminate\Support\Facades\DB;
use App\Empresa;
use App\Imagene;

class SugerenciaController extends Controller
{
    public function showBuzon(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $sugerencia = DB::table('sugerencias')
                    ->select('id','descripcion',
                        DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y %H:%m %p') as created_at"))
                    ->get();

        //return $sugerencia;
        //devolvemos el resultado en formato datatable
        return datatables($sugerencia)->toJson();
    }

    public function enviarSugerencia(Request $request)
    {
        //para validar
        $request->validate([
            'sugerencia' => 'required'
        ]);
        
        //insertar la solicitud
        $sugerencia = new Sugerencia();
        $sugerencia->empresas_empresas_id = 1;
        $sugerencia->descripcion = $request->sugerencia;
        $sugerencia->save();

        if ($sugerencia) {
            return redirect()->route('welcome')->with('success', 'Sugerencia creada con éxito');
        }
    }
}
