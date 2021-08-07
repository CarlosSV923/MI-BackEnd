<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enfermedades;

class EnfermedadController extends Controller
{
    public function mostrar_enfermedades(){
        $enfermedades = Enfermedades::all();
        return response() -> json($enfermedades);
    }

    public function mostrar_enfermedades_paginado($size){
        return Enfermedades::Select("*")
        // $enfermedades = Enfermedades::all()
        ->orderBy('enfermedades.created_at', 'desc')
        ->paginate($size);
        return response() -> json($enfermedades);
    }

    public function almacenar_enfermedad(Request $request){
        $enfermedad = new Enfermedades();
        $enfermedad-> nombreCorto = $request -> get('nombreCorto');
        $enfermedad-> nombreLargo = $request -> get('nombreLargo');
        $enfermedad->codigo = $request -> get('codigo');
        $enfermedad-> descrip = $request -> get('descrip');
        $enfermedad->save();
        return response()->json($enfermedad->id_enfermedad, 200);

    }

    // public function eliminar_enfermedad($id_enfermedad){
    //     $enfermedad = Enfermedades::find($id_enfermedad);
    //     $enfermedad->delete();
    //     return response() -> json(['log' => 'Eliminado correctamente'], 200);
    // }

    public function eliminar_enfermedad($id_enfermedad){
        $enfermedad = Enfermedades::find($id_enfermedad);
        $enfermedad->delete();
        $enfermedades = Enfermedades::all();
        return response() -> json($enfermedades);
    }

    function obtener_enfermedad_por_id($id_enfermedad){
        return Enfermedades::selectRaw("*")
        ->where('enfermedades.id_enfermedad',$id_enfermedad)
        ->get();
    }

    function actualizar_enfermedad(Request $request){
        $enfermedad = Enfermedades::where("id_enfermedad", "=", $request->get("id_enfermedad"));
        $enfermedad->update([
            "nombreCorto" => $request->get("nombreCorto"),
            "nombreLargo" => $request->get("nombreLargo"),
            "codigo" => $request->get("codigo"),
            "descrip" => $request->get("descrip"),            
        ]);
        return response() -> json($enfermedad);
    }

}