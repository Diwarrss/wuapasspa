<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Imagene;
use App\Categoria;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $miEmpresa = Empresa::all();
        $logoEmpresa = DB::table('empresas')
                        ->select('logo_empresa','nombre_corto')
                        ->get();
        $imagenes = DB::table('imagenes')
                    ->select('imagenes.id','imagenes.nombre_imagen','imagenes.url_imagen','imagenes.created_at')
                    ->leftJoin('categorias', 'imagenes.id', '=', 'categorias.imagenes_imagenes_id' )
                    ->leftJoin('servicios', 'imagenes.id', '=', 'servicios.imagenes_imagenes_id' )
                    ->where([['categorias.imagenes_imagenes_id', '=', null],
                    ['servicios.imagenes_imagenes_id', '=', null]])
                    ->orderBy('imagenes.id', 'desc')
                    ->get();
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
