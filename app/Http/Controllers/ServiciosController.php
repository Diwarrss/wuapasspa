<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio; //importa el model de servcios
use App\Imagene;
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
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $servicios = DB::table('servicios')
            ->select('id', 'empresas_empresas_id', 'nombre_servicio', 'valor_servicio', 'descripcion_servicio', 'estado_servicio')
            ->where('estado_servicio', 1)
            ->orderBy('nombre_servicio', 'asc')
            ->get();
        return $servicios;
    }

    //añadir servicios de facturar
    public function serviciosFaturables(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $servicios = DB::table('servicios')
            ->select('id', 'empresas_empresas_id', 'nombre_servicio', 'valor_servicio', 'descripcion_servicio', 'estado_servicio')
            ->where('estado_servicio', 1)
            ->orderBy('nombre_servicio', 'asc')
            ->get();
        return datatables($servicios)->toJson();
    }

    public function showServicios(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $servicios = DB::table('servicios')
            ->leftJoin('imagenes', 'servicios.imagenes_imagenes_id', '=', 'imagenes.id')
            ->leftJoin('categorias', 'servicios.categorias_categorias_id', '=', 'categorias.id')
            ->select(
                'servicios.id',
                'servicios.nombre_servicio',
                'servicios.descripcion_servicio',
                'servicios.estado_servicio',
                'servicios.url_video',
                'servicios.valor_servicio',
                'servicios.tipo',
                'servicios.stock',
                'imagenes.empresas_empresas_id',
                'imagenes.url_imagen',
                'categorias.nombre_categoria',
                'servicios.categorias_categorias_id'
            )
            ->get();

        return datatables($servicios)
            ->toJson();
    }

    public function crearServicio(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $tipo = $request->tipo;
        if ($tipo == "2") {
            $request->validate([
                'categoriaServicio' => 'required',
                'nombreServicio' => 'required|max:150|string|unique:servicios,nombre_servicio',
                'descripcion' => 'max:255',
                'estadoServicio' => 'required',
                'urlVideoServicio' => ['nullable', 'max:250', 'regex:/^(http[s]?:\/\/){0,1}(w{3,3}\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/'],
                'imagenServicio' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'valorServicio' => 'required|min:2|max:12',
                'tipo' => 'required',
                'stock' => 'required|max:10',
            ]);
        } else {
            //para validar
            $request->validate([
                'categoriaServicio' => 'required',
                'nombreServicio' => 'required|max:150|string|unique:servicios,nombre_servicio',
                'descripcion' => 'max:255',
                'estadoServicio' => 'required',
                'urlVideoServicio' => ['nullable', 'max:250', 'regex:/^(http[s]?:\/\/){0,1}(w{3,3}\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/'],
                'imagenServicio' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'valorServicio' => 'required|min:2|max:12',
                'tipo' => 'required',
            ]);
        }

        //aqui guardamos la imagen en esta variable
        $imagenFile = $request->imagenServicio;
        //aqui guardamos la url del video para partirla
        $url = $request->urlVideoServicio;

        if ($url) {
            // break the URL into its components
            $parts = parse_url($url);

            // $parts['query'] contains the query string: 'v=Z29MkJdMKqs&feature=grec_index'

            // parse variables into key=>value array
            $query = array();
            parse_str($parts['query'], $query);

            $url_Final = $query['v']; // Z29MkJdMKqs
        } else {
            $url_Final = '';
        }

        //insertar la Imagen
        if ($imagenFile) {
            $nombreImagen = time() . '.' . $request->imagenServicio->getClientOriginalExtension();
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
            $servicio->tipo = $request->tipo;
            $servicio->stock = $request->stock;
            $servicio->url_video = $url_Final;
            $servicio->valor_servicio = $request->valorServicio;
            $servicio->empresas_empresas_id = 1;
            $servicio->imagenes_imagenes_id = $imagen->id;
            $servicio->categorias_categorias_id = $request->categoriaServicio;
            $servicio->save();
        } else {
            $servicio = new Servicio();
            $servicio->nombre_servicio = $request->nombreServicio;
            $servicio->descripcion_servicio = $request->descripcion;
            $servicio->estado_servicio = $request->estadoServicio;
            $servicio->tipo = $request->tipo;
            $servicio->stock = $request->stock;
            $servicio->url_video = $url_Final;
            $servicio->valor_servicio = $request->valorServicio;
            $servicio->empresas_empresas_id = 1;
            $servicio->categorias_categorias_id = $request->categoriaServicio;
            $servicio->save();
        }
    }

    public function actualizarServicio(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $tipo = $request->tipo;
        if ($tipo == "2") {
            $request->validate([
                'categoriaServicio' => 'required',
                'nombreServicio' => 'required|max:150|string|', //unique:servicios,nombre_servicio,'.$request->idServicio
                'descripcion' => 'required|max:255',
                'estadoServicio' => 'required',
                'urlVideoServicio' => ['nullable', 'max:250', 'regex:/^(http[s]?:\/\/){0,1}(w{3,3}\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/'],
                'imagenServicio' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'valorServicio' => 'required|min:2|max:12',
                'tipo' => 'required',
                'stock' => 'required|max:10',
            ]);
        } else {
            //para validar
            $request->validate([
                'categoriaServicio' => 'required',
                'nombreServicio' => 'required|max:150|string|', //unique:servicios,nombre_servicio,'.$request->idServicio
                'descripcion' => 'required|max:255',
                'estadoServicio' => 'required',
                'urlVideoServicio' => ['nullable', 'max:250', 'regex:/^(http[s]?:\/\/){0,1}(w{3,3}\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/'],
                'imagenServicio' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'valorServicio' => 'required|min:2|max:12',
                'tipo' => 'required',
            ]);
        }

        $servicio = Servicio::findOrFail($request->idServicio); //actualizamos para el user logueado
        $imagenFile = $request->imagenServicio; //capturamos la imagen

        $url = $request->urlVideoServicio;

        if ($url) {
            // break the URL into its components
            $parts = parse_url($url);

            // $parts['query'] contains the query string: 'v=Z29MkJdMKqs&feature=grec_index'

            // parse variables into key=>value array
            $query = array();
            parse_str($parts['query'], $query);

            $url_Final = $query['v']; // Z29MkJdMKqs
        } else {
            $url_Final = '';
        }

        if ($imagenFile) { //validamos que alla una imagen

            $idImagen = Imagene::find($servicio->imagenes_imagenes_id);

            if ($idImagen == null) {
                $nombreImagen = time() . '.' . $request->imagenServicio->getClientOriginalExtension(); //obtenemos el nombre de la imagen

                //Subimos la nueva imagen
                $imagenFile->move(public_path('/img/servicios/'), $nombreImagen); //guardamos la imagen en este directorio

                $imagen = new Imagene();
                $imagen->empresas_empresas_id = 1;
                $imagen->url_imagen = $nombreImagen;
                $imagen->save();

                $servicio->nombre_servicio = $request->nombreServicio;
                $servicio->descripcion_servicio = $request->descripcion;
                $servicio->estado_servicio = $request->estadoServicio;
                $servicio->tipo = $request->tipo;
                $servicio->stock = $request->stock;
                $servicio->url_video = $url_Final;
                $servicio->valor_servicio = $request->valorServicio;
                $servicio->empresas_empresas_id = 1;
                $servicio->categorias_categorias_id = $request->categoriaServicio;
                $servicio->imagenes_imagenes_id = $imagen->id;
                $servicio->save();
            } else {
                $nombreImagen = $request->imagenServicio->getClientOriginalName();
                //Subimos la nueva imagen
                $imagenFile->move(public_path('/img/categorias/'), $nombreImagen); //guardamos la imagen en este directorio

                $imagen = new Imagene();
                $imagen->empresas_empresas_id = 1;
                $imagen->url_imagen = $nombreImagen;
                $imagen->save();

                $servicio->nombre_servicio = $request->nombreServicio;
                $servicio->descripcion_servicio = $request->descripcion;
                $servicio->estado_servicio = $request->estadoServicio;
                $servicio->tipo = $request->tipo;
                $servicio->stock = $request->stock;
                $servicio->url_video = $url_Final;
                $servicio->valor_servicio = $request->valorServicio;
                $servicio->empresas_empresas_id = 1;
                $servicio->categorias_categorias_id = $request->categoriaServicio;
                $servicio->imagenes_imagenes_id = $imagen->id;
                $servicio->save();

                $idImagen->delete();
            }
        } else {
            $servicio->nombre_servicio = $request->nombreServicio;
            $servicio->descripcion_servicio = $request->descripcion;
            $servicio->estado_servicio = $request->estadoServicio;
            $servicio->tipo = $request->tipo;
            $servicio->stock = $request->stock;
            $servicio->url_video = $url_Final;
            $servicio->valor_servicio = $request->valorServicio;
            $servicio->empresas_empresas_id = 1;
            $servicio->categorias_categorias_id = $request->categoriaServicio;
            $servicio->save();
        }
    }

    //mostrar componenets o vista
    public function componente()
    {
        $logoEmpresa = DB::table('empresas')
            ->select('logo_empresa', 'nombre_corto')
            ->get();
        return view('/cliente/nuevaCita', ['logoEmpresa' => $logoEmpresa]);
    }

    //enlistar servicios para facturacion
    public function listarServProd(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $servicios = \App\Servicio::select('id', 'nombre_servicio', 'tipo')
            ->where('estado_servicio', 1)
            ->get();

        return $servicios;
    }

    //enlistar servicios para facturacion
    public function getServicioID(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;

        $infoService = \App\Servicio::where('id', $id)->get();

        return $infoService;
    }
}
