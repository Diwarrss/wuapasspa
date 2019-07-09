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
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax
        try {
            //usaremos transacciones
            DB::beginTransaction();
            //para validar los formularios
            $request->validate([
                'empleado_id' => 'required',
                'nombre_caja' => 'required|min:3|max:150',
                'valor_inicial' => 'max:10|regex:/^\d+(\.\d{1,2})?$/',
                'valor_producido' => 'max:10|regex:/^\d+(\.\d{1,2})?$/',
            ]);

            $caja =  new Caja();
            $caja->empleado_id = $request->empleado_id;
            $caja->nombre_caja = $request->nombre_caja;;
            $caja->valor_inicial = $request->valor_inicial;
            $caja->valor_producido = $request->valor_producido;
            $caja->save();
            DB::commit();


        } catch (Exception $e) {
            DB::rollBack();//si hay error no ejecute la transaccion
        }

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
