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

        //para generear la transacccion
        return DB::transaction(function () use ($request) {
            //insertar el servicio
            $servicios = new Servicio();
            $servicios->empresas_empresas_id = $request->empresas_empresas_id;
            $servicios->nombre_servicio = $request->nombreServicio;
            $servicios->descripcion_servicio = $request->descripcion;
            $servicios->estado_servicio = $request->estadoServicio;
            $servicios->save();
        });
    }

    public function actualizarServicio(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        try {
            //usaremos transacciones
            DB::beginTransaction();

            //para validar
            $request->validate([
                'nombreServicio' => 'required|min:5|max:150|string|unique:servicios,nombre_servicio,'.$request->idServicio,
                'descripcion' => 'required|max:255',
                'estadoServicio' => 'required',
                'categoriaServicio' => 'required',
                'urlVideoServicio' => 'max:500',
                'imagenServicio' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'valorServicio' => 'required|numeric|max:12'
            ]);

            $servicios = Servicio::findOrFail($request->idServicio);
            //insertar el servicio
            $servicios->empresas_empresas_id = $request->empresas_empresas_id;
            $servicios->nombre_servicio = $request->nombreServicio;
            $servicios->descripcion_servicio = $request->descripcion;
            $servicios->estado_servicio = $request->estadoServicio;
            $servicios->save();

            DB::commit();//
        } catch (Exception $e) {
            DB::rollBack();//si hay error no ejecute la transaccion
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
