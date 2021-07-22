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
}
