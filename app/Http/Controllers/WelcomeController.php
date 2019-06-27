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
                    ->join('categorias', 'servicios.categorias_categorias_id','=', 'categorias.id')
                    ->select('categorias.id as id_catogoria','servicios.id','servicios.empresas_empresas_id','servicios.nombre_servicio','servicios.descripcion_servicio','servicios.estado_servicio',
                            'servicios.categorias_categorias_id','categorias.nombre_categoria')
                    ->where('servicios.estado_servicio', 1)
                    ->orderBy('servicios.nombre_servicio', 'asc')
                    ->get();
        $categorias = DB::table('categorias')
                    ->select('categorias.id','categorias.nombre_categoria','categorias.estado_categoria', 'categorias.url_video',
                            'imagenes.empresas_empresas_id','imagenes.url_imagen','categorias.id as serviciosobj')
                    ->leftJoin('imagenes', 'categorias.imagenes_imagenes_id', '=', 'imagenes.id')
                    ->get();

                    $serviciosObjetos = array();
                    foreach ($categorias as $categoria) {
                        
                        foreach ($servicios as $servicio) {
                            if($categoria->id == $servicio->id_catogoria){
                                $serviciosObjetos[$servicio->id] =  (array)$servicio;                             
                            }
                        }
                        $categoria->serviciosobj = (object)$serviciosObjetos; 
                        $serviciosObjetos = array();
                    }
        //aqui enviamos un array llamado miEmpresa a la vista welcome
        return view('welcome', ['miEmpresa' => $miEmpresa, 'imagenes' => $imagenes, 'servicios' => $servicios, 'categorias' => $categorias,
                                'logoEmpresa' => $logoEmpresa]);
    }
}
