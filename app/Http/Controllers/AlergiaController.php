<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alergias;
use App\Models\Medicamentos;

class AlergiaController extends Controller
{
    public function mostrar_alergias_pacientes(){
        $alergias_pacientes = Alergias::all();
        return response() -> json($alergias_pacientes);
    }

    public function almacenar_alergias_paciente(Request $request){

        $lista_alergias_paciente = $request -> get('alergias_paciente');
        for ($i = 0; $i < count($lista_alergias_paciente); $i++){
            $alergia_paciente = new Alergias();
            $data = $lista_alergias_paciente[$i];
            $alergia_paciente->paciente = $request -> get('paciente');
            $alergia_paciente->medicamento = $data['medicamento'];
            $alergia_paciente -> save();
        }
    }

    public function almacenar_alergias(Request $request){
        $lista_alergias = $request -> get('alergias');
        //print_r($data);
        $array = [];
        // $array = "a";
        // $array = "b";
//        array_push($array, "a");
//        array_push($array, "b");

        // print_r($lista_alergias);
        //print_r($array);
        for ($i = 0; $i < count($lista_alergias); $i++){
            $ultimo_id = Medicamentos::latest('id_medicamento')->first()->id_medicamento;
            $alergias = new Medicamentos();
            $alergias->nombre = $lista_alergias[$i]['nombre'];
            $alergias->codigo = 'MED'.($ultimo_id+1);
            $alergias->save();
            array_push($array, $alergias->id_medicamento);
        }
        // print_r($array);
        return $array;

    }
}
