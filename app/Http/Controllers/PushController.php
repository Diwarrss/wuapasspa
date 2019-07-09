<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Notifications\PushDemo;
use App\User;
use Auth;
use Notification;
use Illuminate\Support\Facades\DB;

class PushController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Store the PushSubscription.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    //para notificar al Administrador creando y llamando PushDemo
    public function push(Request $request){
        if (!$request->ajax()) return redirect('/');
        //capturamos el id del Admin si es autenticado
        //$user = App\User::where('roles_roles_id', 1)->get();
        $user = User::find(1);
        //$user = User::where('roles_roles_id', '=', 1);

        Notification::send($user,new PushDemo);
        return redirect()->back();
    }

    //para notificar a los clientes
    public function pushClientes(Request $request){
        if (!$request->ajax()) return redirect('/');
        //capturamos el id del Admin si es autenticado
        $user = User::where('roles_roles_id', '=', 3);

        Notification::send($user,new CitaAgendada);
        return redirect()->back();
    }
    //para guardar la subscripcion del q acepta las notificaciones
    public function store(Request $request){
        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true],200);
    }
}
