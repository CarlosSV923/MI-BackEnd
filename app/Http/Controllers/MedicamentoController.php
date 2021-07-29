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
}
