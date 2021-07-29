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

    public function almacenar_enfermedad(Request $request){
        $enfermedad = new Enfermedades();
        $enfermedad-> nombreCorto = $request -> get('nombreCorto');
        $enfermedad-> nombreLargo = $request -> get('nombreLargo');
        $enfermedad->codigo = $request -> get('codigo');
        $enfermedad-> descrip = $request -> get('descrip');
        $enfermedad->save();
        return response()->json($enfermedad->id_enfermedad, 200);

    }

}
