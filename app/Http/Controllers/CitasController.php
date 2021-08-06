<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\Enfermedades;
use App\Models\Medicamentos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CitasController extends Controller
{

    public function Log($value)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($value);
    }

    public function agendarCita(Request $request)
    {
        $cita = new Citas();

        $cita->paciente = $request->get("paciente");
        $cita->medico = $request->get("medico");
        $cita->init_comment = $request->get("init_comment");
        $cita->inicio_cita = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("inicio_cita"));
        $cita->fin_cita = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("fin_cita"));
        $cita->fecha_agendada = Date('Y-m-d H:i:s');
        $cita->save();

        return response()->json(['log' => 'exito'], 200);
    }

    public function getCitasMedico(Request $request)
    {
        $cedula =  $request->get("cedula");
        $paciente =  $request->get("paciente");
        $dateMin = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_min"));
        $dateMax = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_max"));


        if (empty($cedula) ||  empty($dateMax) || empty($dateMin)) {
            return response()->json(['log' => 'error'], 400);
        }

        $query = Citas::select(
            'citas.id_cita as id',
            'citas.estado as estado',
            'citas.init_comment as desc',
            'citas.inicio_cita as start',
            'citas.fin_cita as end',
            'pacientes.nombre as nombre',
            'pacientes.apellido as apellido',
            'pacientes.cedula as cedula',
        )
            ->join("personas as pacientes", "pacientes.cedula", "=", "citas.paciente")
            ->where("citas.medico", "=", $cedula)
            ->where("citas.inicio_cita", "<=", $dateMax)
            ->where("citas.inicio_cita", ">=", $dateMin);
        if (!empty($paciente)) {
            $query = $query->where("citas.paciente", "=", $paciente);
        }

        return response()->json($query->get(), 200);
    }

    public function getCitasPaciente(Request $request)
    {
        $cedula =  $request->get("cedula");
        $dateMin = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_min"));
        $dateMax = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_max"));

        if (empty($cedula) ||  empty($dateMax) || empty($dateMin)) {
            return response()->json(['log' => 'error'], 400);
        }

        $query = Citas::select(
            'citas.id_cita as id',
            'citas.estado as estado',
            'citas.init_comment as desc',
            'citas.inicio_cita as start',
            'citas.fin_cita as end',
            'medicos.nombre as nombre',
            'medicos.apellido as apellido',
            'medicos.cedula as cedula',
            'medicos.apellido as apellido',
            'especialidades.nombre as especialidad'

        )
            ->join("personas as medicos", "medicos.cedula", "=", "citas.medico")
            ->join("medico_especialidad", "medico_especialidad.medico", "=", "medicos.cedula")
            ->join("especialidades", "especialidades.id_especialidad", "=", "medico_especialidad.especialidad")

            ->where("citas.paciente", "=", $cedula)
            ->where("citas.inicio_cita", "<=", $dateMax)
            ->where("citas.inicio_cita", ">=", $dateMin);
        $this->Log(json_encode($query->get()));
        return response()->json($query->get(), 200);
    }

    public function reangedarCancelarCita(Request $request)
    {
        $cita = Citas::where("id_cita", "=", $request->get("id"));
        $cita->update([
            'inicio_cita' => Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("inicio_cita")),
            "fin_cita" =>  Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("fin_cita")),
            'estado' => $request->get("estado"),
            "init_comment" => $request->get("init_comment"),
        ]);
        return response()->json($cita, 200);
    }

    public function almacenar_cita(Request $request)
    {
        $cita = new Citas();
        $cita->medico = $request->get('medico');
        $cita->paciente = $request->get('paciente');
        $cita->inicio_cita = $request->get('inicio_cita');
        $cita->fin_cita = $request->get('fin_cita');
        $cita->init_comment = $request->get('init_comment');
        $cita->estado = $request->get('estado');
        $cita->observRec = $request->get('observRec');
        $cita->planTratam = $request->get('planTratam');
        $cita->procedimiento = $request->get('procedimiento');
        $cita->instrucciones = $request->get('instrucciones');
        $cita->sintomas = $request->get('sintomas');
        $cita->fecha_agendada = $request->get('fecha_agendada');
        $cita->fecha_atencion = $request->get('fecha_atencion');
        $cita->seguimiento = $request->get('seguimiento');
        $cita->save();
        return response()->json($cita->id_cita);
    }

    public function getCitasReporte(Request $request)
    {
        $cedula =  $request->get("cedula");
        $paciente =  $request->get("paciente");
        $dateMin = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_min"));
        $dateMax = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_max"));


        if (empty($cedula) ||  empty($dateMax) || empty($dateMin)) {
            return response()->json(['log' => 'error'], 400);
        }

        $query = Citas::select(
            'citas.id_cita as id',
            'citas.estado as estado',
            'citas.fecha_agendada as fecha_agendada',
            'citas.fecha_atencion as fecha_atencion',
            'pacientes.nombre as nombrePaciente',
            'pacientes.apellido as apellidoPaciente',
            'pacientes.cedula as cedulaPaciente',
            'medicos.nombre as nombreMedico',
            'medicos.apellido as apellidoMedico',
            'medicos.cedula as cedulaMedico',
        )
            ->join("personas as pacientes", "pacientes.cedula", "=", "citas.paciente")
            ->join("personas as medicos", "medicos.cedula", "=", "citas.medico")
            ->where("citas.medico", "=", $cedula)
            ->where("citas.inicio_cita", "<=", $dateMax)
            ->where("citas.inicio_cita", ">=", $dateMin);
        if (!empty($paciente)) {
            $query = $query->where("citas.paciente", "=", $paciente);
        }

        $arrResp = array();

        foreach ($query->get() as $obj) {
            $paciente = $obj["nombrePaciente"] . " " . $obj["apellidoPaciente"];
            $medico = $obj["nombreMedico"] . " " . $obj["apellidoMedico"];

            $enfQuery = Enfermedades::select(
                'enfermedades.nombreCorto as enfermedad',

            )->join("enfermedades_citas", "enfermedades_citas.enfermedad", "=", "enfermedades.id_enfermedad")
                ->where("enfermedades_citas.cita", "=", $obj["id_cita"]);

            $enfermedades = "";
            foreach ($enfQuery->get() as $enf) {
                $enfermedades = $enf["enfermedad"] . "," . $enfermedades;
            }

            $medQuery = Medicamentos::select(
                'medicamentos.nombre as medicamento',

            )->join("medicamentos_citas", "medicamentos_citas.medicamento", "=", "medicamentos.id_medicamento")
                ->where("medicamentos_citas.cita", "=", $obj["id_cita"]);
            $medicamentos = "";
            foreach ($medQuery->get() as $med) {
                $medicamentos = $med["medicamento"] . "," . $medicamentos;
            }
            $objResp = [
                "paciente" => $paciente,
                "medico" => $medico,
                "cedulaMedico" => $obj["cedulaMedico"],
                "cedulaPaciente" => $obj["cedulaPaciente"],
                "estado" => $obj["estado"],
                "fechaAtendida" => $obj["fecha_atendida"],
                "fechaAgendada" => $obj["fecha_agendada"],
                "enfermedades" => $enfermedades,
                "medicamentos" => $medicamentos,
            ];
            array_push($arrResp, $objResp);
        }

        return response()->json($arrResp, 200);
    }
}
