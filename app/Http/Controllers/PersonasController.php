<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personas;

class PersonasController extends Controller
{
    //
    public function getPersonasFilter(Request $request)
    {
        $cedula =  $request->get("cedula");
        $apellido =  $request->get("apellido");
        $nombre =  $request->get("nombre");
        $rol =  $request->get("rol");

        $query = Personas::select(
            'personas.cedula',
            'personas.nombre',
            'personas.apellido',
            'roles.nombre as rol',
            'users.username as username',
        )
            ->join('users', 'users.cedula', '=', 'personas.cedula')
            ->join('roles', 'roles.id_rol', '=', 'users.id_rol');
        if (!empty($rol)) {
            $query = $query->Where('roles.nombre', 'like', "%" . $rol . "%");
        }
        $query->Where(function ($query) use($cedula, $nombre, $apellido){
            if (!empty($cedula)) {
                $query = $query->where('personas.cedula', 'like', "%" . $cedula . "%");
            }
            if (!empty($nombre)) {
                $query = $query->orWhere('personas.nombre', 'like', "%" . $nombre . "%");
            }
            if (!empty($apellido)) {
                $query = $query->orWhere('personas.apellido', 'like', "%" . $apellido . "%");
            }
            return $query;
        });
        

        return response()->json($query->get());
    }
}
