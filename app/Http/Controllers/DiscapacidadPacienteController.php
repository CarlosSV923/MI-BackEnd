<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscapacidadPaciente;

class DiscapacidadPacienteController extends Controller
{

    public function mostrar_discapacidades_pacientes(){
        $discapacidades_pacientes = DiscapacidadPaciente::all();
        return response() -> json($discapacidades_pacientes);
    }

    public function almacenar_discapacidades_paciente(Request $request){

        $lista_discapacidades_paciente = $request -> get('discapacidades_paciente');
        for ($i = 0; $i < count($lista_discapacidades_paciente); $i++){
            $discapacidad_paciente = new DiscapacidadPaciente();
            $data = $lista_discapacidades_paciente[$i];
            // $discapacidad_paciente->paciente = $data -> paciente
            $discapacidad_paciente->paciente =$request -> get('paciente');
            //$discapacidad_paciente->descrip = $data['descrip'];
            $discapacidad_paciente->discapacidad = $data['discapacidad'];
            $discapacidad_paciente -> save();
        }

    }

}
