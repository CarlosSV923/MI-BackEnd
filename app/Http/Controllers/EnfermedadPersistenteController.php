<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnfermedadesPersistentes;

class EnfermedadPersistenteController extends Controller
{
    //
    
    public function mostrar_enfermedades_persistentes(){
        $enfermedades_persistentes = EnfermedadesPersistentes::all();
        return response() -> json($enfermedades_persistentes);
    }

    public function almacenar_enfermedades_persistentes_paciente(Request $request){

        $lista_enfermedades_persistentes = $request -> get('enfermedades_persistentes_paciente');
        for ($i = 0; $i < count($lista_enfermedades_persistentes); $i++){
            $enfermedades_persistentes = new EnfermedadesPersistentes();
            $data = $lista_enfermedades_persistentes[$i];
            $enfermedades_persistentes->paciente =$request -> get('paciente');
            //$enfermedades_persistentes->descrip = $data['descrip'];
            $enfermedades_persistentes->enfermedad = $data['enfermedad'];
            $enfermedades_persistentes -> save();

        }


    }
    
}
