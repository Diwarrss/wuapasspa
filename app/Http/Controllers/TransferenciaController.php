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
            $cajaOrigenNeto = $cajaOrigen->valor_inicial +  $cajaOrigen->valor_producido;

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

    public function confirmarTransferencia(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax
        try {
            //usaremos transacciones
            DB::beginTransaction();
            //para validar los formularios
            // 'empleado_id' valida que el usuario al que se va asoriar la caja, lo siguiente:
            //                 -que  no tenga caja activa, - que el rol sea diferente a administrador
            $Transferencia = Transferencia::find($request->id);
            $cajaOrigen = Caja::find($Transferencia->caja_origen);
            $cajaDestino = Caja::find($Transferencia->caja_destino);

            $cajaOrigenNeto = $cajaOrigen->valor_inicial +  $cajaOrigen->valor_producido ;
            //solo se pueden hacer tranferencias si el dinero esta disponible y si aun sigue pendiente la tranferencia, es decir
            //que no haya sido anulada
            if ($Transferencia->valor <= $cajaOrigenNeto && $Transferencia->estado_transferencia == 1) {
                $cajaOrigen->valor_producido =  $cajaOrigen->valor_producido -  $Transferencia->valor;
                $cajaOrigen->save();
                $cajaDestino->valor_producido =  $cajaDestino->valor_producido +  $Transferencia->valor;
                $cajaDestino->save();
                $Transferencia->estado_transferencia = '2';
                $Transferencia->save();
            } else {
                throw new Exception('El valor a transferir ya no esta disponible');
            }

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
                DB::raw("(CASE transferencias.estado_transferencia
                WHEN 1 THEN 'Pendiente'
                WHEN 2 THEN 'Recibida'
                ELSE 'Anulada' END) AS estado_transferencia"),
                'cajaOrigen.empleado_id as EmpCreadorTrans',
                'cajaDestino.empleado_id as EmpRecibeTrans'
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

    public function anularTransferencia(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //para validar
        $request->validate([
            'motivo_anulacion' => 'required|max:255'
        ]);

        try {
            DB::beginTransaction();

            $cancelarTranferencia = Transferencia::find($request->id_Transferencia_Anular);
            //si la transferencia esta en estado pendiente se puede anular de resto NO
            if ($cancelarTranferencia->estado_transferencia == 1) {
                $cancelarTranferencia->estado_transferencia = 3; //es el estado de ANULADA
                $cancelarTranferencia->anulado_por = Auth::user()->id;
                $cancelarTranferencia->motivo_anulacion = $request->motivo_anulacion;
                $cancelarTranferencia->save();
            } else {
                throw new Exception('NO es Posible anular La Transferencia ya Fue Confirmada');
            }


            DB::commit(); //se Hace el commit a la Base de Datos
        } catch (Exception $e) {
            DB::rollBack();
        }
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
