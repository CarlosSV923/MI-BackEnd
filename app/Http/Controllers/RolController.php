<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;

class RolController extends Controller
{
    //
    
    public function almacenar_rol(Request $request){
        $rol = new Roles();
        $rol-> nombre = $request -> get('nombre');
        $rol-> descrip = $request -> get('descrip');
        $rol->save();
        return response()->json($rol->id_rol, 200);
    }

    public function mostrar_roles(){
        $roles = Roles::all();
        return response() -> json($roles);
    }



}
