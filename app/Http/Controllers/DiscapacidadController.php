<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discapacidades;

class DiscapacidadController extends Controller
{
    public function mostrar_discapacidades(){
        $discapacidades = Discapacidades::all();
        return response() -> json($discapacidades);
    }

    public function almacenar_discapacidad(Request $request){
        $discapacidad = new Discapacidades();
        $discapacidad-> nombre = $request -> get('nombre');
        $discapacidad->codigo = $request -> get('codigo');
        $discapacidad-> descrip = $request -> get('descrip');
        $discapacidad->save();
        return response()->json($discapacidad->id_discapacidad, 200);

    }

    public function almacenar_discapacidades(Request $request){
        $lista_discapacidades = $request -> get('discapacidades');
        //print_r($data);
        $array = [];
        // $array = "a";
        // $array = "b";
//        array_push($array, "a");
//        array_push($array, "b");

        // print_r($lista_discapacidades);
        //print_r($array);
        for ($i = 0; $i < count($lista_discapacidades); $i++){
            $ultimo_id = Discapacidades::latest('id_discapacidad')->first()->id_discapacidad;
            $discapacidades = new Discapacidades();
            $discapacidades->nombre = $lista_discapacidades[$i]['nombre'];
            $discapacidades->codigo = 'DISCAP'.($ultimo_id+1);
            $discapacidades->save();
            array_push($array, $discapacidades->id_discapacidad);
        }
        // print_r($array);
        return $array;

    }

}
