<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Imagene;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function crearCategoria(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //para validar
        $request->validate([
            //'nombre_imagen' => 'required',
            'imagenCategoria' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nombreCategoria' => 'required|max:200|string|unique:categorias,nombre_categoria',
            'estadoCategoria' => 'required',
            'urlVideoCategoria' => ['nullable', 'max:250', 'regex:/^(http[s]?:\/\/){0,1}(w{3,3}\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/']
        ]);

        //aqui guardamos la imagen en esta variable
        $imagenFile = $request->imagenCategoria;
        $url = $request->urlVideoCategoria;

        if ($url) {
            // break the URL into its components
            $parts = parse_url($url);

            // $parts['query'] contains the query string: 'v=Z29MkJdMKqs&feature=grec_index'

            // parse variables into key=>value array
            $query = array();
            parse_str($parts['query'], $query);

            $url_Final = $query['v']; // Z29MkJdMKqs
        }else {
            $url_Final ='';
        }

        //insertar la Imagen
        if ($imagenFile) {
            $nombreImagen = time().'.'. $request->imagenCategoria->getClientOriginalExtension();
            //creamos la ruta dnd se va a guardar la imagen
            //$path = Storage::disk('public')->put('img/carousel', $request->file('file'));//UN METODO DE SUBIR LA IMAGEN PERO SE REPITEN
            $imagenFile->move(public_path('/img/categorias/'), $nombreImagen);

            $imagen = new Imagene();
            $imagen->empresas_empresas_id = 1;
            $imagen->url_imagen = $nombreImagen;
            $imagen->save();

            $categoria = new Categoria();
            $categoria->nombre_categoria = $request->nombreCategoria;
            $categoria->estado_categoria = $request->estadoCategoria;
            $categoria->url_video = $url_Final;
            $categoria->imagenes_imagenes_id = $imagen->id;
            $categoria->save();
        }else{
            $categoria = new Categoria();
            $categoria->nombre_categoria = $request->nombreCategoria;
            $categoria->estado_categoria = $request->estadoCategoria;
            $categoria->url_video = $url_Final;
            $categoria->save();
        }
    }

    public function showCategoria(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $categoria = DB::table('categorias')
                    ->select('categorias.id','categorias.nombre_categoria','categorias.estado_categoria', 'categorias.url_video',
                            'imagenes.empresas_empresas_id','imagenes.url_imagen')
                    ->leftJoin('imagenes', 'categorias.imagenes_imagenes_id', '=', 'imagenes.id')
                    ->get();

        return datatables($categoria)
        ->toJson();
    }

    public function showCategoriaActivas(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $categoriashow = DB::table('categorias')
                    ->select('id','nombre_categoria', 'estado_categoria')
                    ->where('estado_categoria', 1)
                    ->get();

        return $categoriashow;
    }

    public function updateCategoria(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //para validar los formularios
        $request->validate([
            'imagenCategoria' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nombreCategoria' => 'required|max:200|string|unique:categorias,nombre_categoria,'.$request->idCategoria,
            'estadoCategoria' => 'required|string',
            'urlVideoCategoria' => ['nullable', 'max:250', 'regex:/^(http[s]?:\/\/){0,1}(w{3,3}\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/']
        ]);

        $categoria = Categoria::findOrFail($request->idCategoria);//actualizamos para el user logueado
        $imagenFile = $request->imagenCategoria;//capturamos la imagen

        $url = $request->urlVideoCategoria;

        if ($url) {
            // break the URL into its components
            $parts = parse_url($url);

            // $parts['query'] contains the query string: 'v=Z29MkJdMKqs&feature=grec_index'

            // parse variables into key=>value array
            $query = array();
            parse_str($parts['query'], $query);

            $url_Final = $query['v']; // Z29MkJdMKqs
        }else {
            $url_Final ='';
        }

        if ($imagenFile) {//validamos que alla una imagen

            $idImagen = Imagene::find($categoria->imagenes_imagenes_id);

            if ($idImagen == null) {
                $nombreImagen = time().'.'. $request->imagenCategoria->getClientOriginalExtension();//obtenemos el nombre de la imagen

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
                $nombreImagen = time().'.'. $request->imagenCategoria->getClientOriginalExtension();
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
}
