<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imagene;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImagenesController extends Controller
{
    public function showImagenes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $imagenes = DB::table('imagenes')
                    ->orderBy('id', 'desc')
                    ->get();

        return datatables($imagenes)
        ->toJson();
    }

    public function saveImagen(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //para validar
        $request->validate([
            //'nombre_imagen' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        //aqui guardamos la imagen en esta variable
        $imagenFile = $request->file;
        $nombreImagen = $request->file->getClientOriginalName();

        //insertar la Imagen
        if ($imagenFile) {
            //creamos la ruta dnd se va a guardar la imagen
            //$path = Storage::disk('public')->put('img/carousel', $request->file('file'));//UN METODO DE SUBIR LA IMAGEN PERO SE REPITEN
            $imagenFile->move(public_path('/img/carousel/'), $nombreImagen);
           
            $imagen = new Imagene();
            $imagen->empresas_empresas_id = 1;
            //$imagen->nombre_imagen = 'prueba 1';
            $imagen->url_imagen = $nombreImagen;
            $imagen->save();
        }
    }
    public function deleteImagen(Request $request)
    {
        if (!$request->ajax()) return redirect('/');      

        $url_imagen = $request->url_imagen;

        if($url_imagen){
            //borrar imagen del disco OJO NINGUNA SIRVE NO BORRA
            $image_path = public_path('/img/carousel', $url_imagen);
            Storage::disk('public')->delete('/img/carousel', $url_imagen);
            Storage::delete($image_path);
            File::delete($image_path);
            //unlink($image_path);
            //para borrar el registro de la BD
            $idImagen = Imagene::findOrFail($request->id);
            $idImagen->delete(); 
        }
    }
}
