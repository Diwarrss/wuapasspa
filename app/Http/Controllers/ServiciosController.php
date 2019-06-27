<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio; //importa el model de servcios
use Illuminate\Support\Facades\DB;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        $servicios = DB::table('servicios')
                    ->select('id','empresas_empresas_id','nombre_servicio','descripcion_servicio','estado_servicio')
                    ->where('estado_servicio', 1)
                    ->orderBy('nombre_servicio', 'asc')
                    ->get();
        return $servicios;
    }

    public function showServicios(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        $servicios = DB::table('servicios')
                    ->select('id','empresas_empresas_id','nombre_servicio','descripcion_servicio','estado_servicio',
                        DB::raw("if(estado_servicio = 1, 'Activo', 'Inactivo') AS estado_solicitud_nombre"))
                    ->get();

        return datatables($servicios)
        ->toJson();
    }

    public function crearServicio(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        //para validar
        $request->validate([
            'categoriaServicio' => 'required',
            'nombreServicio' => 'required|max:150|string|unique:servicios,nombre_servicio',
            'descripcion' => 'required|max:255',
            'estadoServicio' => 'required',
            'urlVideoServicio' => 'max:500',
            'imagenServicio' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'valorServicio' => 'required|max:12'
        ]);

        //aqui guardamos la imagen en esta variable
        $imagenFile = $request->imagenServicio;
        //aqui guardamos la url del video para partirla
        $url = $request->urlVideoServicio;

        // break the URL into its components
        $parts = parse_url($url);

        // $parts['query'] contains the query string: 'v=Z29MkJdMKqs&feature=grec_index'

        // parse variables into key=>value array
        $query = array();
        parse_str($parts['query'], $query);

        $url_Final = $query['v']; // Z29MkJdMKqs

        //insertar la Imagen
        if ($imagenFile) {
            $nombreImagen = $request->imagenServicio->getClientOriginalName();
            //creamos la ruta dnd se va a guardar la imagen
            //$path = Storage::disk('public')->put('img/carousel', $request->file('file'));//UN METODO DE SUBIR LA IMAGEN PERO SE REPITEN
            $imagenFile->move(public_path('/img/servicios/'), $nombreImagen);

            $imagen = new Imagene();
            $imagen->empresas_empresas_id = 1;
            $imagen->url_imagen = $nombreImagen;
            $imagen->save();

            $servicio = new Servicio();
            $servicio->nombre_servicio = $request->nombreServicio;
            $servicio->descripcion_servicio = $request->descripcion;
            $servicio->estado_servicio = $request->estadoServicio;
            $servicio->url_video = $url_Final;
            $servicio->valor_servicio = $request->valorServicio;
            $servicio->empresas_empresas_id = 1;
            $servicio->imagenes_imagenes_id = $imagen->id;
            $servicio->categorias_categorias_id = $request->categoriaServicio;
            $servicio->save();

        }else{
            $servicio = new Servicio();
            $servicio->nombre_servicio = $request->nombreServicio;
            $servicio->descripcion_servicio = $request->descripcion;
            $servicio->estado_servicio = $request->estadoServicio;
            $servicio->url_video = $url_Final;
            $servicio->valor_servicio = $request->valorServicio;
            $servicio->empresas_empresas_id = 1;
            $servicio->imagenes_imagenes_id = $imagen->id;
            $servicio->categorias_categorias_id = $request->categoriaServicio;
            $servicio->save();
        }
    }

    public function actualizarServicio(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //para validar los formularios
        $request->validate([
            'imagenCategoria' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nombreCategoria' => 'required|max:200|string|unique:categorias,nombre_categoria,'.$request->idCategoria,
            'estadoCategoria' => 'required|string',
            'urlVideoCategoria' => 'max:500'
        ]);

        $categoria = Categoria::findOrFail($request->idCategoria);//actualizamos para el user logueado
        $imagenFile = $request->imagenCategoria;//capturamos la imagen

        $url = $request->urlVideoCategoria;

        // break the URL into its components
        $parts = parse_url($url);

        // $parts['query'] contains the query string: 'v=Z29MkJdMKqs&feature=grec_index'

        // parse variables into key=>value array
        $query = array();
        parse_str($parts['query'], $query);

        $url_Final = $query['v']; // Z29MkJdMKqs

        if ($imagenFile) {//validamos que alla una imagen

            $idImagen = Imagene::find($categoria->imagenes_imagenes_id);

            if ($idImagen == null) {
                $nombreImagen = $request->imagenCategoria->getClientOriginalName();//obtenemos el nombre de la imagen

                //Subimos la nueva imagen
                $imagenFile->move(public_path('/img/categorias/'), $nombreImagen);//guardamos la imagen en este directorio

                $imagen = new Imagene();
                $imagen->empresas_empresas_id = 1;
                $imagen->url_imagen = $nombreImagen;
                $imagen->save();

                $categoria->nombre_categoria = $request->nombreCategoria;
                $categoria->estado_categoria = $request->estadoCategoria;
                $categoria->url_video = $url_Final;
                $categoria->imagenes_imagenes_id = $imagen->id;
                $categoria->save();
            }else{
                $nombreImagen = $request->imagenCategoria->getClientOriginalName();
                //Subimos la nueva imagen
                $imagenFile->move(public_path('/img/categorias/'), $nombreImagen);//guardamos la imagen en este directorio

                $imagen = new Imagene();
                $imagen->empresas_empresas_id = 1;
                $imagen->url_imagen = $nombreImagen;
                $imagen->save();

                $categoria->nombre_categoria = $request->nombreCategoria;
                $categoria->estado_categoria = $request->estadoCategoria;
                $categoria->url_video = $url_Final;
                $categoria->imagenes_imagenes_id = $imagen->id;
                $categoria->save();

                $idImagen->delete();
            }
        }else{
            $categoria->nombre_categoria = $request->nombreCategoria;
            $categoria->estado_categoria = $request->estadoCategoria;
            $categoria->url_video = $url_Final;
            $categoria->save();
        }
    }

    //mostrar componenets o vista
    public function componente(){
        $logoEmpresa = DB::table('empresas')
                        ->select('logo_empresa','nombre_corto')
                        ->get();
        return view('/cliente/nuevaCita', ['logoEmpresa' => $logoEmpresa]);
    }
}
