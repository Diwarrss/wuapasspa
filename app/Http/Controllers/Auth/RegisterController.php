<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function showRegistrationForm()
    {
        $logoEmpresa = DB::table('empresas')
                        ->select('logo_empresa','nombre_corto')
                        ->get();

        return view('auth.register', ['logoEmpresa' => $logoEmpresa]);
    }
    

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            //'usuario' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'celular' => ['required', 'string', 'max:100'],
            //'fecha_cumpleaños' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'roles_roles_id' => \App\Role::Cliente,
            'empresas_empresas_id' => '1',
            'nombre_usuario' => $data['nombres'],
            'apellido_usuario' => $data['apellidos'],
            //'usuario' => $data['usuario'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'celular' => $data['celular'],
            'fecha_cumple' => $data['fechaCumple'],
            'imagen' => 'avatar.png',
            'estado_usuario' => \App\User::ACTIVO,
        ]);
    }
}
