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

    public function eliminar_rol($id_rol){
        $rol = Roles::find($id_rol);
        $rol->delete();
        $roles = Roles::all();
        return response() -> json($roles);
    }

    function obtener_rol_por_id($id_rol){
        return Roles::selectRaw("*")
        ->where('roles.id_rol',$id_rol)
        ->get();
    }

    function actualizar_rol(Request $request){
        $rol = Roles::where("id_rol", "=", $request->get("id_rol"));
        $rol->update([
            "nombre" => $request->get("nombre"),
            "descrip" => $request->get("descrip"),            
        ]);
        return response() -> json($rol);
    }

}
