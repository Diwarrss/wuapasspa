<?php

namespace App\Http\Controllers;

use App\Caja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // para obtener el id del cliente que hace la solicitud

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crearCaja(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax
        try {
            //usaremos transacciones
            DB::beginTransaction();
            //para validar los formularios
            $request->validate([
                'empleado_id' => 'required|unique:cajas',
                'nombre_caja' => 'required|min:3|max:150',
                'valor_inicial' => 'max:10|regex:/^\d+(\.\d{1,2})?$/',
                'valor_producido' => 'max:10|regex:/^\d+(\.\d{1,2})?$/',
                'estado_caja' => 'required'
            ]);

            $caja =  new Caja();
            $caja->empleado_id = $request->empleado_id;
            $caja->nombre_caja = $request->nombre_caja;;
            $caja->valor_inicial = $request->valor_inicial;
            $caja->valor_producido = $request->valor_producido;
            $caja->estado_caja = $request->estado_caja;
            $caja->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }


    public function listarCajar(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //creamos la consulta de los usuarios que pertenecen al rol Empleados
        $caja = Caja::join('users', 'cajas.empleado_id', '=', 'users.id')
            ->select(
                'cajas.id',
                'cajas.nombre_caja',
                'cajas.valor_inicial',
                'cajas.valor_producido',
                DB::raw("CONCAT(users.nombre_usuario,' ',users.apellido_usuario) as nombre_usuario")
            )
            ->get();

        //devolvemos el resultado en formato datatable
        return datatables($caja)
            //setrowid elejimos y mostramos el id del atributo
            ->setRowId(function ($caja) {
                return $caja->id;
            })
            ->toJson();
    }


    public function infoCajaDiv(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //creamos la consulta de traer la caja para el empleado que este logueado y que la caja este activa too
        $caja = Caja::where([
            ['empleado_id', Auth::user()->id],
            ['estado_caja', '1']
        ])->get();

        return $caja;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
