<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // para obtener el id del cliente que hace la solicitud
use Illuminate\Support\Facades\DB;// para hacer transacciones seguras a la db
use App\Empresa;//se importa el modelo de las solicitudes

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        $miEmpresa = DB::table('empresas')
                    ->join('users', 'empresas.id', '=', 'users.empresas_empresas_id')
                    ->select('empresas.id','empresas.nombre_empresa','empresas.estado_empresa','empresas.nit_empresa','empresas.direccion_empresa',
                    'empresas.correo_empresa','empresas.urlweb_empresa',
                    'empresas.facebook_empresa','empresas.instagram_empresa',
                    'empresas.celular_empresa','empresas.telefono_empresa','logo_empresa')
                    ->where('users.id', Auth::user()->id)
                    ->get();

        return $miEmpresa;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        //'imagen' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:4084',
        try {
            //usaremos transacciones
            DB::beginTransaction();
            //buscar primero el User a modificar
            $Empresa = Empresa::findOrFail($request->empresa['id']);

            //para validar los formularios
            $request->validate([
                'empresa.nombre_empresa' => 'required|min:3|max:200',
                'empresa.nit_empresa' => 'required|min:3|max:12',
                'empresa.direccion_empresa' => 'required|min:3|max:255',
                'empresa.correo_empresa' => 'required|min:5|max:100|string|email|unique:empresas,correo_empresa,'.$Empresa->id,
                'empresa.urlweb_empresa' => ['required', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', 'max:200'],
                'empresa.facebook_empresa' => ['required', 'string', 'max:500'],
                'empresa.instagram_empresa' => ['required', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', 'max:500'],
                'empresa.celular_empresa' => ['required', 'string', 'max:45']
            ]);

            $Empresa->nombre_empresa = $request->empresa['nombre_empresa'];
            $Empresa->nit_empresa = $request->empresa['nit_empresa'];
            $Empresa->direccion_empresa = $request->empresa['direccion_empresa'];
            $Empresa->correo_empresa = $request->empresa['correo_empresa'];
            $Empresa->urlweb_empresa = $request->empresa['urlweb_empresa'];
            $Empresa->facebook_empresa = $request->empresa['facebook_empresa'];
            $Empresa->instagram_empresa = $request->empresa['instagram_empresa'];
            $Empresa->celular_empresa = $request->empresa['celular_empresa'];
            $Empresa->telefono_empresa = $request->empresa['telefono_empresa'];
            $Empresa->logo_empresa = $request->empresa['logo_empresa'];
            $Empresa->save();//guardamos en la tabla users con el metodo save en la BD

            DB::commit();//
        } catch (Exception $e) {
            DB::rollBack();//si hay error no ejecute la transaccion
        }
    }

    public function updateImagenEmpresa(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //para validar los formularios
        $request->validate([
            'logo_empresa' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $empresa = Empresa::findOrFail(1);//actualizamos para el user logueado

        $imagenFile = $request->logo_empresa;//capturamos la imagen
        $nombreImagen = $request->logo_empresa->getClientOriginalName();//obtenemos el nombre de la imagen

        if ($imagenFile) {//validamos que alla una imagen

            //Subimos la nueva imagen
            $imagenFile->move(public_path('/img/perfiles/'), $nombreImagen);//guardamos la imagen en este directorio

            $empresa->logo_empresa = $nombreImagen;
            $empresa->save();
        }
        /*$imageName = time().'.'.$request->imagen->getClientOriginalExtension();
        $request->imagen->move(public_path('/img/perfiles/'), $imageName);*/
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
