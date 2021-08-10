<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicamentos;

class MedicamentoController extends Controller
{
    public function mostrar_medicamentos(){
        $medicamentos = Medicamentos::all();
        return response() -> json($medicamentos);
    }

    public function almacenar_medicamento(Request $request){
        $medicamento = new Medicamentos();
        $medicamento-> nombre = $request -> get('nombre');
        $medicamento->codigo = $request -> get('codigo');
        $medicamento-> descrip = $request -> get('descrip');
        $medicamento->save();
        return response()->json($medicamento->id_medicamento, 200);

    }

    public function eliminar_medicamento($id_medicamento){
        $medicamento = Medicamentos::find($id_medicamento);
        $medicamento->delete();
        $medicamentos = Medicamentos::all();
        return response() -> json($medicamentos);
    }

    function obtener_medicamento_por_id($id_medicamento){
        return Medicamentos::selectRaw("*")
        ->where('medicamentos.id_medicamento',$id_medicamento)
        ->get();
    }

    function actualizar_medicamento(Request $request){
        $medicamento = Medicamentos::where("id_medicamento", "=", $request->get("id_medicamento"));
        $medicamento->update([
            "nombre" => $request->get("nombre"),
            "codigo" => $request->get("codigo"),
            "descrip" => $request->get("descrip"),            
        ]);
        return response() -> json($medicamento);
    }

    function buscar_medicamentos($nombre){
        return Medicamentos::selectRaw("*")
        ->where('medicamentos.nombre','like','%'.$nombre.'%')
        ->get();
    }

    public function medicamentos(Request $request){
        $nombre= $request->get("nombre");
        $query= Medicamentos::select('medicamentos.id_medicamento','medicamentos.nombre','medicamentos.codigo','medicamentos.descrip');
        if (!empty($nombre)){
            $query= $query->where('medicamentos.nombre','like','%'.$nombre.'%');
        }
        $itemSize = $query->count();
        $query->orderBy('medicamentos.created_at', 'desc');
        // $query->orderBy('medicamentos.created_at', 'asc');
        $query= $query->limit($request->get("page_size"))->offset($request->get("page_size") * $request->get("page_index")); 
        return response()->json(["resp" => $query->get(), "itemSize" => $itemSize])->header("itemSize", $itemSize);
    }

}