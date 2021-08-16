<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seguimientos;
use App\Models\InfoMedica;
use App\Models\Citas;
use App\Models\Examenes;
use Carbon\Carbon;

class SeguimientosController extends Controller
{

    function getSeguimientoData(Request $request)
    {
        $id = $request->get("id");

        $seguimiento = Seguimientos::select(
            "seguimientos.id_seguimiento as id_seguimiento",
            "seguimientos.fecha_inicio as fecha_inicio",
            "seguimientos.fecha_fin as fecha_fin",
            "seguimientos.estado as estadoSeguimiento",
            "medicos.cedula as cedulaMedico",
            "medicos.nombre as nombreMedico",
            "medicos.apellido as apellidoMedico",
            "pacientes.cedula as cedulaPaciente",
            "pacientes.nombre as nombrePaciente",
            "pacientes.apellido as apellidoPaciente"
        )
            ->join("personas as medicos", "medicos.cedula", "=", "seguimientos.medico")
            ->join("personas as pacientes", "pacientes.cedula", "=", "seguimientos.paciente")
            ->where("seguimientos.id_seguimiento", "=", $id)->first();

        $infoMedica = InfoMedica::select(
            "*"
        )->where("info_medica.seguimiento", "=", $seguimiento["id_seguimiento"])->get();

        $citas = Citas::select(
            // "citas.id_cita as id_cita",
            // "citas.estado as estado",
            // "citas.observRec as observRec",
            // "citas.fecha_agendada as fecha_agendada",
            // "citas.fecha_atencion as fecha_atencion",
            // "citas.planTratam as planTratam",
            // "citas.Síntomas as Síntomas",
            // "citas.instrucciones as instrucciones"
            "*"
        )->where("citas.seguimiento", "=", $seguimiento["id_seguimiento"])->get();

        $examenes = Examenes::select(
            "*"
        )->where("examenes.seguimiento", "=", $seguimiento["id_seguimiento"])->get();

        return response()->json(["seguimiento" => $seguimiento, "citas" => $citas, "examenes" => $examenes, "infoMedica" => $infoMedica], 200);
    }

    public function finalizarSeguimiento(Request $request)
    {
        $seg = Seguimientos::where("id_seguimiento", "=", $request->get("id_seguimiento"));
        $seg->update([
            "estado" => $request->get("estado"),
            "fecha_fin" => $request->get("estado") === "F" ? Date('Y-m-d H:i:s') : null,
        ]);
        return response()->json($seg, 200);
    }

    public function getAllSeguimientos(Request $request)
    {

        $dateMin = $request->get("date_min") != null ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_min")) : null;
        $dateMax = $request->get("date_max") != null ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_max")) : null;
        $paciente = $request->get("paciente");
        $medico = $request->get("medico");
        $cuidador = $request->get("cuidador");

        $seguimientos = Seguimientos::select(
            "seguimientos.id_seguimiento as id_seguimiento",
            "seguimientos.fecha_inicio as fecha_inicio",
            "seguimientos.fecha_fin as fecha_fin",
            "seguimientos.estado as estadoSeguimiento",
            "medicos.cedula as cedulaMedico",
            "medicos.nombre as nombreMedico",
            "medicos.apellido as apellidoMedico",
            "pacientes.cedula as cedulaPaciente",
            "pacientes.nombre as nombrePaciente",
            "pacientes.apellido as apellidoPaciente"
        )
            ->join("personas as medicos", "medicos.cedula", "=", "seguimientos.medico")
            ->join("personas as pacientes", "pacientes.cedula", "=", "seguimientos.paciente");

        if (!empty($dateMin)) {
            $seguimientos = $seguimientos->where("seguimientos.fecha_inicio", ">=", $dateMin);
        }
        if (!empty($dateMax)) {
            $seguimientos = $seguimientos->where("seguimientos.fecha_inicio", "<=", $dateMax);
        }
        if (!empty($medico)) {
            $seguimientos = $seguimientos->where("seguimientos.medico", "=", $medico);
        }
        if (!empty($cuidador)) {
            $seguimientos = $seguimientos
                                ->join("cuidador_seguimiento","cuidador_seguimiento.seguimiento" ,"=", "seguimientos.id_seguimiento")
                                ->where("cuidador_seguimiento.cuidador", "=", $cuidador);
        }

        return response()->json($seguimientos->get(), 200);
    }

    public function crear_seguimiento(Request $request){
        $seguimiento = new Seguimientos();
        $seguimiento -> fecha_inicio = $request -> get('fecha_inicio');
        $seguimiento -> paciente = $request -> get('paciente');
        $seguimiento -> medico = $request -> get('medico');
        $seguimiento -> estado = 'P';
        $seguimiento->save();
        return response()->json($seguimiento, 200);
    }
    
}
