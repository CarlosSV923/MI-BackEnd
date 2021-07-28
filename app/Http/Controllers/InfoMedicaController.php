<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoMedica;

class InfoMedicaController extends Controller
{
    public function mostrar_signos_vitales(){
        $signos_vitales = new InfoMedica();
        return response() -> json($signos_vitales);
    }

    public function almacenar_signos_vitales_paciente(Request $request){
        $lista_signos_vitales_paciente = $request -> get('signos_vitales_paciente');
        for ($i = 0; $i < count($lista_signos_vitales_paciente); $i++){
            $signo_vital = new InfoMedica();
            $data = $lista_signos_vitales_paciente[$i];
            $signo_vital->cita =$request -> get('cita');
            $signo_vital->seguimiento =$request -> get('seguimiento');
            $signo_vital->key = $data['key'];
            $signo_vital->value = $data['value'];
            $signo_vital->unidad = $data['unidad'];
            //$signo_vital->descrip = $request -> get('descrip');
            $signo_vital -> save();
        }
    }

}
