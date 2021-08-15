<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personas;
use App\Models\PacienteCuidador;

class PersonasController extends Controller
{
    //
    public function getPacientesFilter(Request $request)
    {
        $filter =  $request->get("filter");

        $query = Personas::select(
            'personas.cedula',
            'personas.nombre',
            'personas.apellido',
            'roles.nombre as rol',
            'users.username as username',
        )
        
            ->join('users', 'users.cedula', '=', 'personas.cedula')
            ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
            ->Where('roles.nombre', 'like', "%Paciente%");

        $query->Where(function ($query) use ($filter) {

            $query = $query->where('personas.cedula', 'like', "%" . $filter . "%");

            $query = $query->orWhere('personas.nombre', 'like', "%" . $filter . "%");

            $query = $query->orWhere('personas.apellido', 'like', "%" . $filter . "%");

            return $query;
        });


        return response()->json($query->get(), 200);
    }

    public function getPacientesCuidadorFilter(Request $request)
    {
        $filter =  $request->get("filter");
        $cuidador =  $request->get("cuidador");
        
        $query = Personas::select(
            'personas.cedula',
            'personas.nombre',
            'personas.apellido',
            'personas.correo',
            'roles.nombre as rol',
            'users.username as username',
        )
            ->join('paciente_cuidador', 'paciente_cuidador.paciente', '=', 'personas.cedula')
            ->join('users', 'users.cedula', '=', 'personas.cedula')
            ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
            ->Where('roles.nombre', 'like', "%Paciente%")
            ->Where('paciente_cuidador.cuidador', '=', $cuidador);

        $query->Where(function ($query) use ($filter) {

            $query = $query->where('personas.cedula', 'like', "%" . $filter . "%");

            $query = $query->orWhere('personas.nombre', 'like', "%" . $filter . "%");

            $query = $query->orWhere('personas.apellido', 'like', "%" . $filter . "%");

            return $query;
        });


        return response()->json($query->get(), 200);
    }

    public function getMedicosFilter(Request $request)
    {
        $filter =  $request->get("filter");


        $query = Personas::select(
            'personas.cedula',
            'personas.nombre',
            'personas.apellido',
            'roles.nombre as rol',
            'users.username as username',
            "especialidades.nombre as especialidad"
        )
            ->join("medico_especialidad", "medico_especialidad.medico", "=", "personas.cedula")
            ->join("especialidades", "especialidades.id_especialidad", "=", "medico_especialidad.especialidad")
            ->join('users', 'users.cedula', '=', 'personas.cedula')
            ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
            ->Where('roles.nombre', 'like', "%Medico%");

        $query->Where(function ($query) use ($filter) {

            $query = $query->where('personas.cedula', 'like', "%" . $filter . "%");

            $query = $query->orWhere('personas.nombre', 'like', "%" . $filter . "%");

            $query = $query->orWhere('personas.apellido', 'like', "%" . $filter . "%");

            $query = $query->orWhere('especialidades.nombre', 'like', "%" . $filter . "%");

            return $query;
        });


        return response()->json($query->get(), 200);
    }


    public function savePacienteAsociadoCuidador(Request $request){
        
        $paciente =  $request->get("paciente");
        $cuidador =  $request->get("cuidador");

        $pc = new PacienteCuidador()
        $pc->paciente = $paciente;
        $pc->cuidador = $cuidador;
        $pc->save();

        return response()->json($pc, 200);
    }

    public function deletePacienteAsociadoCuidador(Request $request){

        $exam = PacienteCuidador::select("*")->where("examenes.id_examen", "=", $request->get("id_paciente_cuidador"));

        $exam->delete();
        return response()->json(["log" => "exito"], 200);   
    }
}
