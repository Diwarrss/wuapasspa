<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\UserSocialAccount;
use Illuminate\Support\Facades\DB;

//para capturar datos de autenticacion
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $logoEmpresa = DB::table('empresas')
            ->select('logo_empresa', 'nombre_corto')
            ->get();

        return view('auth.login', ['logoEmpresa' => $logoEmpresa]); //retornamos la vista q esta en kla carpeta auth
    }

    //clase para acceder al login menu principal
    public function login(Request $request)
    {
        $this->validateLogin($request); //hacemos referencia a la funcion..y se le envia el objeto request

        //validamos los campos q sean iguales a cada uno del objeto request ADMIN, EMPLEADO, CLIENTE
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'estado_usuario' => 1, 'roles_roles_id' => 1])) {
            return redirect('/admin#/dashboard');
        } elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'estado_usuario' => 1, 'roles_roles_id' => 2])) {
            return redirect('/admin#/miAgenda');
        } elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'estado_usuario' => 1, 'roles_roles_id' => 3])) {
            return redirect('/');
        } elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'estado_usuario' => 1, 'roles_roles_id' => 4])) {
            return redirect('/admin#/dashboard');
        }

        return back()
            ->withErrors(['email' => trans('auth.failed')]) //mejoramos con el metodo withs
            ->withErrors(['password' => trans('auth.failed')]) //mejoramos con el metodo withs
            ->withInput(request(['email'])); //devolvemos lo q el ususario a escrito en el input usuario
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [ //codigo para validar el user y password
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
    }

    //metodo para cerrar sesion
    public function logout(Request $request)
    {
        Auth::logout(); //clase auth q se importa
        $request->session()->invalidate();
        return redirect('/');
    }
}
