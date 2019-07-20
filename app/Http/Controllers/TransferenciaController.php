<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caja;
use App\Transferencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // para obtener el id del cliente que hace la solicitud+

class TransferenciaController extends Controller
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


    public function listarTransferencia(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //creamos la consulta de los usuarios que pertenecen al rol cajas
        $transferencia = Transferencia::join('cajas as cajaOrigen', 'transferencias.caja_origen', '=', 'cajaOrigen.id')
            ->join('cajas as cajaDestino', 'transferencias.caja_destino', '=', 'cajaDestino.id')
            ->select(
                'transferencias.id',
                'cajaOrigen.id as id_cajaOrigen',
                'cajaOrigen.nombre_caja as nombre_cajaOrigen',
                'cajaDestino.id as id_cajaDestino',
                'cajaDestino.nombre_caja as nombre_cajaDestino',
                'transferencias.valor',
                'transferencias.notas',
                DB::raw("DATE_FORMAT(transferencias.created_at, '%d/%m/%Y %h:%i %p') as fecha_transferencia"),
                DB::raw("IF(transferencias.estado_transferencia=1, 'Pendiente', 'Recibida') as estado_transferencia")
            )
            ->get();

        //devolvemos el resultado en formato datatable
        return datatables($transferencia)
            //setrowid elejimos y mostramos el id del atributo
            ->setRowId(function ($transferencia) {
                return $transferencia->id;
            })
            ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
