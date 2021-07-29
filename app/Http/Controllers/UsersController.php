<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Personas;

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

    public function almacenar_usuario(Request $request){
        $persona = new Personas();
        $persona -> cedula = $request -> get('cedula');
        $persona -> nombre = $request -> get('nombre');
        $persona -> correo = $request -> get('correo');
        $persona -> apellido = $request -> get('apellido');
        $persona -> fecha_nacimiento = $request -> get('fecha_nacimiento');
        $persona -> sexo = $request -> get('sexo');
        $persona->save();

        $user = new Users();
        $user -> username = $request -> get('username');
        $user -> password = $request -> get('password');
        $user -> cedula = $request -> get('cedula');
        $user -> id_rol = $request -> get('id_rol');
        $user -> estado = 'A';
        $user->save();

        return response()->json($request -> get('cedula'), 200);


    }

}
