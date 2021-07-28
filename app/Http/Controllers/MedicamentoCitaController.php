<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicamentosCitas;

class MedicamentoCitaController extends Controller
{
    public function mostrar_medicamentos_citas(){
        $medicamentos_citas = MedicamentosCitas::all();
        return response() -> json($medicamentos_citas);
    }


    public function almacenar_medicamentos_cita_paciente(Request $request){
        $lista_medicamentos_cita_paciente = $request -> get('medicamentos_cita_paciente');
        for ($i = 0; $i < count($lista_medicamentos_cita_paciente); $i++){
            $medicamentos_citas = new MedicamentosCitas();
            $data = $lista_medicamentos_cita_paciente[$i];
            $medicamentos_citas->cita =$request -> get('cita');
            $medicamentos_citas->medicamento = $data['medicamento'];
            $medicamentos_citas->dosis = $data['dosis'];
            $medicamentos_citas->frecuencia = $data['frecuencia'];
            $medicamentos_citas->duracion = $data['duracion'];
            $medicamentos_citas -> save();
        }
    }


}
