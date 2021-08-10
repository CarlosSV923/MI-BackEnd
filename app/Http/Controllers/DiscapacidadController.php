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

    public function eliminar_discapacidad($id_discapacidad){
        $discapacidad = Discapacidades::find($id_discapacidad);
        $discapacidad->delete();
        $discapacidades = Discapacidades::all();
        return response() -> json($discapacidades);
    }

    function obtener_discapacidad_por_id($id_discapacidad){
        return Discapacidades::selectRaw("*")
        ->where('discapacidades.id_discapacidad',$id_discapacidad)
        ->get();
    }

    function actualizar_discapacidad(Request $request){
        $discapacidad = Discapacidades::where("id_discapacidad", "=", $request->get("id_discapacidad"));
        $discapacidad->update([
            "nombre" => $request->get("nombre"),
            "codigo" => $request->get("codigo"),
            "descrip" => $request->get("descrip"),            
        ]);
        return response() -> json($discapacidad);
    }
    
    public function discapacidades(Request $request){
        $nombre= $request->get("nombre");
        $query= Discapacidades::select('discapacidades.id_discapacidad','discapacidades.nombre','discapacidades.codigo','discapacidades.descrip');
        if (!empty($nombre)){
            $query= $query->where('discapacidades.nombre','like','%'.$nombre.'%');
        }
        $itemSize = $query->count();
        $query->orderBy('discapacidades.created_at', 'desc');
        // $query->orderBy('discapacidades.created_at', 'asc');
        $query= $query->limit($request->get("page_size"))->offset($request->get("page_size") * $request->get("page_index")); 
        return response()->json(["resp" => $query->get(), "itemSize" => $itemSize])->header("itemSize", $itemSize);
    }

}
