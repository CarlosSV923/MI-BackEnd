<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personas;
use App\Models\PacienteCuidador;
use App\Models\Users;
use App\Models\CuidadorSeguimiento;

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


    public function getCuidadoresFilter(Request $request)
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
            ->Where('roles.nombre', 'like', "%Cuidador%");

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

    public function pacientes_cuidador(Request $request){
        
        $cedula= $request->get("cedula_paciente");

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
        ->Where('paciente_cuidador.cuidador', '=', $request->get("cedula_cuidador"));

        if (!empty($cedula)){
            $query= $query->where('personas.cedula','like','%'.$cedula.'%');
            //print_r("Ingresa");
        }
        
        
        $itemSize = $query->count();
        
        $query->orderBy('personas.created_at', 'desc');
        // return response()->json($query->get());
        // $query->orderBy('personas.created_at', 'asc');
        $query= $query->limit($request->get("page_size"))->offset($request->get("page_size") * $request->get("page_index")); 
        return response()->json(["resp" => $query->get(), "itemSize" => $itemSize])->header("itemSize", $itemSize);

    }

    public function all_cuidadores (){
        return PacienteCuidador::all();
    }

    public function getCuidadoresPacienteFilter(Request $request)
    {
        $filter =  $request->get("filter");
        $paciente =  $request->get("paciente");
        
        $query = Personas::select(
            'personas.cedula',
            'personas.nombre',
            'personas.apellido',
            'personas.correo',
            'roles.nombre as rol',
            'users.username as username',
        )
            ->join('paciente_cuidador', 'paciente_cuidador.cuidador', '=', 'personas.cedula')
            ->join('users', 'users.cedula', '=', 'personas.cedula')
            ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
            ->Where('roles.nombre', 'like', "%Cuidador%")
            ->Where('paciente_cuidador.paciente', '=', $paciente);

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

        $pc = new PacienteCuidador();
        $pc->paciente = $paciente;
        $pc->cuidador = $cuidador;
        $pc->save();

        return response()->json($pc, 200);
    }

    public function deletePacienteAsociadoCuidador(Request $request){
        $paciente =  $request->get("paciente");
        $cuidador =  $request->get("cuidador");
        $reg = PacienteCuidador::select("*")->where("cuidador", "=", $cuidador)->where("paciente", "=", $paciente);

        $reg->delete();
        return response()->json(["log" => "exito"], 200);   
    }

    public function pacientes_asociar(Request $request){
        $query= Users::select(
            // "users.username as usuario",
            "personas.cedula as cedula",
            "personas.nombre as nombre",
            "personas.apellido as apellido",
            )
        ->join("personas", "personas.cedula", '=', "users.cedula")
        ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
        ->where('roles.id_rol', '=', 2)
        ->get();
        
        return response()->json($query);

    }

    public function cuidadores_de_paciente(Request $request){
        $cedula= $request->get("cedula_paciente");
        $query = Personas::select(
            'personas.cedula',
            'personas.nombre',
            'personas.apellido',
            'personas.correo',
            'roles.nombre as rol',
            'users.username as username',
        )
        ->join('paciente_cuidador', 'paciente_cuidador.cuidador', '=', 'personas.cedula')
        ->join('users', 'users.cedula', '=', 'personas.cedula')
        ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
        ->Where('roles.nombre', 'like', "%Cuidador%")
        ->Where('paciente_cuidador.paciente', '=', $cedula)
        ->get();
        return response()->json($query);
    }

    public function asignar_seguimiento_cuidador(Request $request){
        $seguimiento = new CuidadorSeguimiento();
        $seguimiento-> cuidador = $request -> get('cuidador');
        $seguimiento-> seguimiento = $request -> get('seguimiento');
        $seguimiento->save();
        return response()->json($seguimiento->id_cuidador_seguimiento, 200);
    }

}
