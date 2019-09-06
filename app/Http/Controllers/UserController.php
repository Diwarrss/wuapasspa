<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // para obtener el id del cliente que hace la solicitud

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //enviamos el rol del usuario autenticado para parametrizar el sistema
    public function enviarRol(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rolUser = User::where('id', Auth::user()->id)
            ->select('roles_roles_id', 'id as id_user')
            ->get();

        return $rolUser;
    }
    public function showEmpleadosDT(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //creamos la consulta de los usuarios que pertenecen al rol Empleados
        $empleados = User::join('roles', 'users.roles_roles_id', '=', 'roles.id')
            ->select(
                'users.id',
                'users.roles_roles_id',
                'empresas_empresas_id',
                'nombre_usuario',
                'apellido_usuario',
                'usuario',
                'email',
                'password',
                'celular',
                'fecha_cumple',
                'imagen',
                'estado_usuario',
                'roles.nombre_rol',
                DB::raw("IF(estado_usuario=1, 'Activo', 'Desactivado') as estado_nombre"),
                DB::raw("CONCAT(users.nombre_usuario,' ',users.apellido_usuario) as nombre_completo")
            )
            ->whereIn('roles_roles_id', [2, 4])
            ->orderBy('users.id', 'asc')
            ->get();

        //devolvemos el resultado en formato datatable
        return datatables($empleados)
            //setrowid elejimos y mostramos el id del atributo
            ->setRowId(function ($empleados) {
                return $empleados->id;
            })
            ->toJson();
    }

    //listar empleados para seleccionarlos en el componente de agenda.
    //los peluqueos tienen el rol 2 y estan activos 1
    public function showEmpleado()
    {
        $empleados = User::select('id', DB::raw("CONCAT(nombre_usuario,'  ',apellido_usuario) AS nombre"))
            ->where([
                ['estado_usuario', '1'],
                ['roles_roles_id', '2'],
            ])->get();
        return $empleados;
    }

    //listar empleados para seleccionarlos en el componente de Caja registradora.
    //los Agendadores tienen el rol 4 y estan activos 1
    public function empleadosAgendadores()
    {
        $empleados = User::select('id', DB::raw("CONCAT(nombre_usuario,'  ',apellido_usuario) AS nombre"))
            ->where('estado_usuario', '1')
            ->whereIn('roles_roles_id', ['1', '4'])->get();
        return $empleados;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createEmpleado(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //para validar los formularios
        $request->validate([
            'nombre_usuario' => 'required|min:3|max:255',
            'apellido_usuario' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'celular' => ['required', 'string', 'max:100'],
            'fecha_cumple' => ['required', 'string', 'max:100'],
            'estado_usuario' => ['required'],
            'roles_roles_id' => ['required']
        ]);

        $empleado =  new User();
        $empleado->roles_roles_id = $request->roles_roles_id;
        $empleado->empresas_empresas_id = 1;
        $empleado->nombre_usuario = $request->nombre_usuario;
        $empleado->apellido_usuario = $request->apellido_usuario;
        $empleado->usuario = $request->usuario;
        $empleado->email = $request->email;
        $empleado->password = Hash::make($request->password);
        $empleado->celular = $request->celular;
        $empleado->fecha_cumple = $request->fecha_cumple;
        $empleado->imagen = 'avatar.png';
        $empleado->estado_usuario = $request->estado_usuario;
        $empleado->save();
    }

    public function actualizarEmpleado(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        try {
            //usaremos transacciones
            DB::beginTransaction();
            //buscar primero el User a modificar
            $empleado = User::findOrFail($request->id);

            //para validar los formularios
            $request->validate([
                'nombre_usuario' => 'required|min:3|max:255',
                'apellido_usuario' => ['required', 'string', 'max:255'],
                'email' => 'required|min:5|max:255|string|email|unique:users,email,' . $empleado->id,
                //'password' => ['required', 'string', 'min:6'],
                'celular' => ['required', 'string', 'max:100'],
                'fecha_cumple' => ['required', 'string', 'max:100'],
                'estado_usuario' => ['required'],
                'roles_roles_id' => ['required'],
            ]);

            $empleado->roles_roles_id = $request->roles_roles_id;
            $empleado->empresas_empresas_id = 1;
            $empleado->nombre_usuario = $request->nombre_usuario;
            $empleado->apellido_usuario = $request->apellido_usuario;
            $empleado->usuario = $request->usuario;
            $empleado->email = $request->email;
            //$empleado->password = Hash::make($request->password);
            $empleado->celular = $request->celular;
            $empleado->fecha_cumple = $request->fecha_cumple;
            $empleado->imagen = $request->imagen;
            $empleado->estado_usuario = $request->estado_usuario;
            $empleado->save(); //guardamos en la tabla users con el metodo save en la BD

            DB::commit(); //
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    public function updateEstadoEmple(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        try {
            //usaremos transacciones
            DB::beginTransaction();
            //buscar primero el User a modificar
            $empleado = User::findOrFail($request->id);

            $empleado->estado_usuario = $request->estado_usuario;
            $empleado->save(); //guardamos en la tabla users con el metodo save en la BD

            DB::commit(); //
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }
    //contar la cantidad de clientes activos
    public function contarClientes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cont = User::join('roles', 'users.roles_roles_id', '=', 'roles.id')
            ->where([['users.roles_roles_id', 3], ['users.estado_usuario', 1]])
            ->count();

        return $cont;
    }

    public function showClientesDT(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //creamos la consulta de los usuarios que pertenecen al rol Clientes
        $clientes = User::join('roles', 'users.roles_roles_id', '=', 'roles.id')
            ->select(
                'users.id',
                'users.roles_roles_id',
                'empresas_empresas_id',
                'nombre_usuario',
                'apellido_usuario',
                'usuario',
                'email',
                'password',
                'celular',
                'fecha_cumple',
                'imagen',
                'estado_usuario',
                DB::raw("CONCAT(users.nombre_usuario,' ',users.apellido_usuario) as nombre_completo"),
                DB::raw("IF(estado_usuario=1, 'Activo', 'Desactivado') as estado_nombre")
            )
            ->where('roles_roles_id', 3)
            ->orderBy('users.id', 'asc')
            ->get();

        //devolvemos el resultado en formato datatable
        return datatables($clientes)
            //setrowid elejimos y mostramos el id del atributo
            ->setRowId(function ($clientes) {
                return $clientes->id;
            })
            ->toJson();
    }

    public function createCliente(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //para validar los formularios
        $request->validate([
            'nombre_usuario' => 'required|min:3|max:255',
            'apellido_usuario' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'celular' => ['required', 'string', 'max:100'],
            'fecha_cumple' => ['required', 'string', 'max:100'],
            'estado_usuario' => ['required'],
        ]);

        $cliente =  new User();
        $cliente->roles_roles_id = 3;
        $cliente->empresas_empresas_id = 1;
        $cliente->nombre_usuario = $request->nombre_usuario;
        $cliente->apellido_usuario = $request->apellido_usuario;
        $cliente->usuario = $request->usuario;
        $cliente->email = $request->email;
        $cliente->password = Hash::make($request->password);
        $cliente->celular = $request->celular;
        $cliente->fecha_cumple = $request->fecha_cumple;
        $cliente->imagen = $request->imagen;
        $cliente->estado_usuario = $request->estado_usuario;
        $cliente->save();
    }

    public function actualizarCliente(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        try {
            //usaremos transacciones
            DB::beginTransaction();
            //buscar primero el User a modificar
            $cliente = User::findOrFail($request->id);

            //para validar los formularios
            $request->validate([
                'nombre_usuario' => 'required|min:3|max:255',
                'apellido_usuario' => ['required', 'string', 'max:255'],
                'email' => 'required|min:5|max:255|string|email|unique:users,email,' . $cliente->id,
                'password' => ['required', 'string', 'min:6'],
                'celular' => ['required', 'string', 'max:100'],
                'fecha_cumple' => ['required', 'string', 'max:100'],
                'estado_usuario' => ['required'],
            ]);

            $cliente->roles_roles_id = 3;
            $cliente->empresas_empresas_id = 1;
            $cliente->nombre_usuario = $request->nombre_usuario;
            $cliente->apellido_usuario = $request->apellido_usuario;
            $cliente->usuario = $request->usuario;
            $cliente->email = $request->email;
            $cliente->password = Hash::make($request->password);
            $cliente->celular = $request->celular;
            $cliente->fecha_cumple = $request->fecha_cumple;
            $cliente->imagen = $request->imagen;
            $cliente->estado_usuario = $request->estado_usuario;
            $cliente->save(); //guardamos en la tabla users con el metodo save en la BD

            DB::commit(); //
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    public function showCumpleClientes(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //consulta para cumpleaños del mes
        $cumpleCliente = User::select(
            'id',
            'roles_roles_id',
            'empresas_empresas_id',
            'usuario',
            'celular',
            'fecha_cumple',
            'imagen',
            'estado_usuario',
            DB::raw('DAY(fecha_cumple) as cumpleDia'),
            DB::raw("CONCAT(users.nombre_usuario,' ',users.apellido_usuario) as nombre_completo")
        )
            ->where([
                ['roles_roles_id', 3],
                ['empresas_empresas_id', 1],
                [DB::raw('MONTH(fecha_cumple)'), '=', DB::raw('MONTH(NOW())')],
            ])
            ->get();


        //funciona perop coloca unos a lso que si
        /*$cumpleCliente = User::select('id', 'roles_roles_id', 'empresas_empresas_id', 'nombre_usuario', 'apellido_usuario',
        'usuario', 'email', 'password', 'celular', 'fecha_cumple', 'imagen', 'estado_usuario',
        DB::raw('CONCAT_WS("-",YEAR(CURDATE()), MONTH(fecha_cumple), DAY(fecha_cumple))
                                        BETWEEN CURDATE() AND ADDDATE(CURDATE(), INTERVAL 10 DAY) AS cumplen'))
                                ->where([
                                    ['roles_roles_id', 3],
                                ] )
                                ->get();*/



        //select(DB::raw('DATEDIFF(fecha_cumple,created_at)  as diasparaCumple'))->where('roles_roles_id', 3)->get();

        //devolvemos el resultado en formato datatable
        return datatables($cumpleCliente)
            //setrowid elejimos y mostramos el id del atributo
            ->setRowId(function ($cumpleCliente) {
                return $cumpleCliente->id;
            })
            ->toJson();
    }

    public function showPerfil(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        $miperfil = User::select(
            'id',
            'roles_roles_id',
            'empresas_empresas_id',
            'nombre_usuario',
            'apellido_usuario',
            'usuario',
            'email',
            'password',
            'celular',
            'fecha_cumple',
            'imagen',
            'estado_usuario',
            'created_at',
            'updated_at',
            DB::raw("IF(estado_usuario=1, 'Activo', 'Desactivado') as estado_nombre")
        )
            ->where('id', Auth::user()->id)
            ->get();

        return $miperfil;
    }

    public function actualizarPerfil(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //'imagen' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:4084',
        try {
            //usaremos transacciones
            DB::beginTransaction();
            //buscar primero el User a modificar
            $miperfil = User::findOrFail($request->id);

            //para validar los formularios
            $request->validate([
                'nombre_usuario' => 'required|min:3|max:255',
                'apellido_usuario' => ['required', 'string', 'max:255'],
                'email' => 'required|min:5|max:255|string|email|unique:users,email,' . $miperfil->id,
                'celular' => ['required', 'string', 'max:100'],
                'fecha_cumple' => ['required', 'string', 'max:100'],
                'estado_usuario' => ['required'],
            ]);

            $miperfil->roles_roles_id = $request->roles_roles_id;
            $miperfil->empresas_empresas_id = 1;
            $miperfil->nombre_usuario = $request->nombre_usuario;
            $miperfil->apellido_usuario = $request->apellido_usuario;
            $miperfil->usuario = $request->usuario;
            $miperfil->email = $request->email;
            $miperfil->celular = $request->celular;
            $miperfil->fecha_cumple = $request->fecha_cumple;
            $miperfil->estado_usuario = $request->estado_usuario;
            $miperfil->save(); //guardamos en la tabla users con el metodo save en la BD

            DB::commit(); //
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    public function updateImagen(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //para validar los formularios
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = User::findOrFail(auth()->user()->id); //actualizamos para el user logueado

        $imagenFile = $request->imagen; //capturamos la imagen
        $nombreImagen = $request->imagen->getClientOriginalName(); //obtenemos el nombre de la imagen

        if ($imagenFile) { //validamos que alla una imagen

            //Subimos la nueva imagen
            $imagenFile->move(public_path('/img/perfiles/'), $nombreImagen); //guardamos la imagen en este directorio

            $user->imagen = $nombreImagen;
            $user->save();
        }
        /*$imageName = time().'.'.$request->imagen->getClientOriginalExtension();
        $request->imagen->move(public_path('/img/perfiles/'), $imageName);*/
    }

    public function actualizarPassword(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); //seguridad http si es diferente a peticion ajax

        //'imagen' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:4084',
        try {
            //usaremos transacciones
            DB::beginTransaction();
            //buscar primero el User a modificar
            $miperfil = User::findOrFail($request->id);

            //para validar los formularios
            $request->validate([
                //'passwordAnt' => ['required', 'string', 'min:6'],
                'password' => ['required', 'string', 'min:6'],
                'password2' => ['required', 'string', 'min:6'],
            ]);
            $miperfil->password = Hash::make($request->password);
            $miperfil->save(); //guardamos en la tabla users con el metodo save en la BD

            DB::commit(); //
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    //enlistar clientes para facturacion
    public function listarClientesFact(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $clientes = \App\User::select(DB::raw('CONCAT(nombre_usuario," ", apellido_usuario) AS cliente'), 'id')
            ->where([['roles_roles_id', 3], ['estado_usuario', 1]])
            ->get();

        return $clientes;
    }
}
