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
}
