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
    public function crearTransferencia(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax
        try {
            //usaremos transacciones
            DB::beginTransaction();
            //para validar los formularios
            // 'empleado_id' valida que el usuario al que se va asoriar la caja, lo siguiente:
            //                 -que  no tenga caja activa, - que el rol sea diferente a administrador

            $cajaOrigen = Caja::find($request->caja_origen);
            $cajaDestino = Caja::find($request->caja_destino);
            $cajaOrigenNeto = $cajaOrigen->valor_inicial +  $cajaOrigen->valor_producido - $cajaOrigen->valor_gastos;

            if ($request->valor <= $cajaOrigenNeto) {
                $request->validate([
                    'caja_origen' => 'required',
                    'caja_destino' => 'required',
                    'valor' => 'max:10|regex:/^\d+(\.\d{1,2})?$/'
                ]);
            } else {
                $request->validate([
                    'caja_origen' => 'required',
                    'caja_destino' => 'required',
                    'valor' => [
                        'max:10|regex:/^\d+(\.\d{1,2})?$/',
                        function ($attribute, $value, $fail) {
                            if (1 > 0) {
                                $fail('El valor a Transferir supera al Existente');
                            }
                        }
                    ]
                ]);
            }

            $cajaOrigen->valor_producido =  $cajaOrigen->valor_producido -  $request->valor;
            $cajaOrigen->save();
            $cajaDestino->valor_producido =  $cajaDestino->valor_producido +  $request->valor;
            $cajaDestino->save();

            $Transferencia =  new Transferencia();
            $Transferencia->caja_origen = $request->caja_origen;
            $Transferencia->caja_destino = $request->caja_destino;
            $Transferencia->valor = $request->valor;
            $Transferencia->notas = 'NINGUNA';
            $Transferencia->save();


            DB::commit();
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
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
