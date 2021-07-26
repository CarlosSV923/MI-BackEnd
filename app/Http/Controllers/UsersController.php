<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
{
    //

    public function login(Request $request){
        $username = $request->get("username");
        $password = $request->get("password");

        if (empty($username) ||  empty($password)) {
            return response()->json(['log' => 'error parametros faltantes'], 400);
        }

        $user = Users::select(
            "users.username as username",
            "personas.cedula as cedula",
            "personas.nombre as nombre",
            "personas.apellido as apellido",
            "roles.nombre as rol",
            "users.estado as estado"
        )
        ->join("personas", "personas.cedula", '=', "users.cedula")
        ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
        ->where('users.username','=',$username)
        ->first();

        if($user->estado == 'I'){
            return response()->json(['log'=>'El usuario ingresado está inactivo y no puede acceder al sistema.','user'=>$user], 401);
        }
        return response()->json($user, 200);
    }

}
