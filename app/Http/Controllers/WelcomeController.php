<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Imagene;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $miEmpresa = Empresa::all();
        $logoEmpresa = DB::table('empresas')
                        ->select('logo_empresa','nombre_corto')
                        ->get();
        $imagenes = Imagene::all();
        $servicios = DB::table('servicios')
                    ->select('id','empresas_empresas_id','nombre_servicio','descripcion_servicio','estado_servicio')
                    ->where('estado_servicio', 1)
                    ->orderBy('nombre_servicio', 'asc')
                    ->get();
        
        //aqui enviamos un array llamado miEmpresa a la vista welcome
        return view('welcome', ['miEmpresa' => $miEmpresa, 'imagenes' => $imagenes, 'servicios' => $servicios, 
                                'logoEmpresa' => $logoEmpresa]);
    }
}
