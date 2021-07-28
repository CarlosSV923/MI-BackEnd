<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnfermedadesCitas;

class EnfermedadCitaController extends Controller
{
    
    public function mostrar_enfermedades_cita(){
        $enfermedades_citas = EnfermedadesCitas::all();
        return response() -> json($enfermedades_citas);
    }

    public function almacenar_enfermedades_cita_paciente(Request $request){
        
        $lista_enfermedades_cita = $request -> get('enfermedades_cita_paciente');
        for ($i = 0; $i < count($lista_enfermedades_cita); $i++){
            $enfermedades_cita = new EnfermedadesCitas();
            $data = $lista_enfermedades_cita[$i];
            $enfermedades_cita->cita =$request -> get('cita');
            //$enfermedades_cita->descrip = $data['descrip'];
            $enfermedades_cita->enfermedad = $data['enfermedad'];
            $enfermedades_cita -> save();

        }

    }

}
