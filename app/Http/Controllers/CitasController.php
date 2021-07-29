<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CitasController extends Controller
{

    public function log($value)
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

    public function almacenar_cita(Request $request){
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
        return response() -> json ($cita ->id_cita);
    }


}
