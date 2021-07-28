<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnfermedadesHereditarias;

class EnfermedadHereditariaController extends Controller
{
    
    public function mostrar_enfermedades_hereditarias(){
        $enfermedades_hereditarias = EnfermedadesHereditarias::all();
        return response() -> json($enfermedades_hereditarias);
    }

    public function almacenar_enfermedades_hereditarias_paciente(Request $request){

        $lista_enfermedades_hereditarias = $request -> get('enfermedades_hereditarias_paciente');
        for ($i = 0; $i < count($lista_enfermedades_hereditarias); $i++){
            $enfermedades_hereditarias = new EnfermedadesHereditarias();
            $data = $lista_enfermedades_hereditarias[$i];
            // $enfermedades_hereditarias->paciente = $data -> paciente
            $enfermedades_hereditarias->paciente =$request -> get('paciente');
            //$enfermedades_hereditarias->descrip = $data['descrip'];
            $enfermedades_hereditarias->enfermedad = $data['enfermedad'];
            $enfermedades_hereditarias -> save();
        }

    }

}
