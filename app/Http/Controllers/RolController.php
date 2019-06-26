<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showrolesDT(Request $request)
    {
        if(!$request->ajax()) return redirect('/');//seguridad http si es diferente a peticion ajax

        //devolvemos un json con las propiedades q datatables necesita
        return datatables()->eloquent(Role::query())->toJson();
    }
}
