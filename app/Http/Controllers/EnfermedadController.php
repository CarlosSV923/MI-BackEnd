<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enfermedades;

class EnfermedadController extends Controller
{
    public function mostrar_enfermedades(){
        $enfermedades = Enfermedades::all();
        return response() -> json($enfermedades);
    }
}
