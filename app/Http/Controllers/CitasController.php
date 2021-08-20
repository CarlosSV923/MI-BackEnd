<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\Examenes;
use App\Models\Enfermedades;
use App\Models\Personas;
use App\Models\Medicamentos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\EnfermedadesHereditarias;
use App\Models\DiscapacidadPaciente;
use App\Models\Alergias;
use App\Models\EnfermedadesPersistentes;
use App\Models\Users;
use App\Mail\NotificationMail;

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

    public function agendarCitaAsociada(Request $request)
    {
        $cita = new Citas();

        $cita->paciente = $request->get("paciente");
        $cita->medico = $request->get("medico");
        $cita->init_comment = $request->get("init_comment");
        $cita->inicio_cita = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("inicio_cita"));
        $cita->fin_cita = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("fin_cita"));
        $cita->fecha_agendada = Date('Y-m-d H:i:s');
        $cita->seguimiento = $request->get("id_seguimiento");
        $cita->save();

        if ($request->get("isPaciente")) {
            try {

                $paciente = Personas::select("*")->where("cedula", "=",  $request->get("paciente"))->first();
                $medico = Personas::select("*")->where("cedula", "=",  $request->get("medico"))->first();

                $nombPac = $paciente["nombre"] . " " . $paciente["apellido"];
                $accion = "Agendó una nueva cita en relación a su seguimiento actual.";
                $value = "Ingrese a la plataforma para revisar mas detalles.";

                Mail::to($medico["correo"])->send(new NotificationMail($nombPac, $accion, $value));
            } catch (\Exception $ex) {
                $this->Log("[agendarCitaAsociada]: Fallo envio de correo");
            }
        }

        return response()->json(['log' => 'exito'], 200);
    }

    public function getCitasMedico(Request $request)
    {
        $cedula =  $request->get("cedula");
        $paciente =  $request->get("paciente");
        $dateMin = $request->get("date_min") != null ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_min")) : null;
        $dateMax = $request->get("date_max") != null ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_max")) : null;


        if (empty($cedula)) {
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
            ->where("citas.medico", "=", $cedula);
            
        if (!empty($paciente)) {
            $query = $query->where("citas.paciente", "=", $paciente);
        }
        if (!empty($dateMax)) {
            $query = $query->where("citas.inicio_cita", "<=", $dateMax);
        }
        if (!empty($dateMin)) {
            $query = $query->where("citas.inicio_cita", ">=", $dateMin);
        }

        return response()->json($query->get(), 200);
    }

   

    public function getCitasSeg(Request $request)
    {
        $seg =  $request->get("id_seguimiento");
        $dateMin = $request->get("date_min") != null ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_min")) : null;
        $dateMax = $request->get("date_max") != null ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_max")) : null;


        if (empty($seg)) {
            return response()->json(['log' => 'error'], 400);
        }

        $query = Citas::select(
            '*'
        )
            ->where("citas.seguimiento", "=", $seg)
            ->where("citas.fecha_agendada", "<=", $dateMax)
            ->where("citas.fecha_agendada", ">=", $dateMin);

        return response()->json($query->get(), 200);
    }
    public function getCitasPaciente(Request $request)
    {
        $cedula =  $request->get("cedula");
        $dateMin = $request->get("date_min") != null ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_min")) : null;
        $dateMax = $request->get("date_max") != null ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_max")) : null;

        if (empty($cedula)) {
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

            ->where("citas.paciente", "=", $cedula);

            if (!empty($dateMax)) {
                $query = $query->where("citas.inicio_cita", "<=", $dateMax);
            }
            if (!empty($dateMin)) {
                $query = $query->where("citas.inicio_cita", ">=", $dateMin);
            }
        $this->Log(json_encode($query->get()));
        return response()->json($query->get(), 200);
    }

    public function getCitasCuidador(Request $request)
    {
        $cedula =  $request->get("cedula");
        $dateMin = $request->get("date_min") != null ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_min")) : null;
        $dateMax = $request->get("date_max") != null ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_max")) : null;

        if (empty($cedula)) {
            return response()->json(['log' => 'error'], 400);
        }

        $query = Citas::select(
            'citas.id_cita as id',
            'citas.estado as estado',
            'citas.init_comment as desc',
            'citas.inicio_cita as start',
            'citas.fin_cita as end',
            'medicos.nombre as nombreMedico',
            'medicos.apellido as apellidoMedico',
            'medicos.cedula as cedulaMedico',
            'pacientes.apellido as apellidoPaciente',
            'pacientes.nombre as nombrePaciente',
            'pacientes.cedula as cedulaPaciente',
            'especialidades.nombre as especialidad'

        )
            
            ->join("paciente_cuidador", "paciente_cuidador.paciente", "=", "citas.paciente")
            ->join("personas as medicos", "medicos.cedula", "=", "citas.medico")
            ->join("personas as pacientes", "pacientes.cedula", "=", "citas.paciente")
            ->join("medico_especialidad", "medico_especialidad.medico", "=", "medicos.cedula")
            ->join("especialidades", "especialidades.id_especialidad", "=", "medico_especialidad.especialidad")

            ->where("paciente_cuidador.cuidador", "=", $cedula);
            if (!empty($dateMax)) {
                $query = $query->where("citas.inicio_cita", "<=", $dateMax);
            }
            if (!empty($dateMin)) {
                $query = $query->where("citas.inicio_cita", ">=", $dateMin);
            }
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

    public function actualizar_cita(Request $request)
    {
        $cita = Citas::where("id_cita", "=", $request->get("id_cita"));
        $cita->update([
            "estado" => $request->get("estado"),
            "observRec" => $request->get("observRec"),
            "planTratam" => $request->get("planTratam"),
            "instrucciones" => $request->get("instrucciones"),
            "sintomas" => $request->get("sintomas"),
            "fecha_atencion" => $request->get("fecha_atencion"),
            "seguimiento" => $request->get("seguimiento"),
        ]);
        return response()->json($cita);
    }

    public function info_paciente($cedula)
    {

        $pacientes = Users::select(
            // "users.username as usuario",
            "personas.cedula as cedula",
            "personas.nombre as nombre",
            "personas.apellido as apellido",
            "personas.correo as correo",
            "personas.sexo as sexo",
            "personas.fecha_nacimiento as fecha_nacimiento",
            // "users.password as password"
        )
            ->join("personas", "personas.cedula", '=', "users.cedula")
            ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
            ->where('personas.cedula', '=', $cedula)
            ->get();
        return response()->json($pacientes);
    }

    public function informacion(Request $request)
    {

        $citas = Citas::select(
            "citas.medico as medico",
            "citas.paciente as paciente",
            "personas.nombre as nombre",
            "personas.apellido as apellido",
        )
            ->where('citas.id_cita', '=', $request->get('id_cita'))
            ->join("personas", "personas.cedula", '=', "citas.paciente")
            ->get();
        return response()->json($citas);
    }

    public function mostrar_citas()
    {
        $citas = Citas::select(
            "citas.medico as medico",
            "citas.paciente as paciente",
            "citas.inicio_cita as inicio_cita",
            "citas.fin_cita as fin_cita",
            "citas.init_comment as init_comment",
            "citas.estado as estado",
            "citas.observRec as observRec",
            "citas.planTratam as planTratam",
            "citas.procedimiento as procedimiento",
            "citas.instrucciones as instrucciones",
            "citas.sintomas as sintomas",
            "citas.fecha_agendada as fecha_agendada",
            "citas.fecha_atencion as fecha_atencion",
            "citas.seguimiento as seguimiento",
        )
            ->get();

        // array_push($array, $discapacidades->id_discapacidad);
        /* Por cada cita debo obtener:
           1 Las discapacidades (discapacidad_paciente)
           2 Las alergias (alergias)
           3 Enfermedades persistentes (enfermedades_persistentes)
           4 Enfermedades hereditarias (enfermedades_hereditarias)
           5 Observaciones (citas) **********
           6 Signos vitales (info_medica)
           7 Examenes (examenes)
           8 Enfermedades diagnóstico "comentario" (enfermedades_cita) el comentario en síntomas (citas) *********
           9 Medicamentos (medicamentos_cita)
           10 Instrucciones médicas (citas)*********
           11 Plan tratamiento (citas)***********
        */

        for ($i = 0; $i < count($citas); $i++) {
            $cedula_paciente = $citas[$i]["paciente"];

            //Aquí obtengo todas las discapacidades de un paciente
            $discapacidades_paciente = DiscapacidadPaciente::select(
                "discapacidad_paciente.discapacidad as discapacidad",
            )
                ->get();

            // Aquí obtengo las alergias de un paciente
            $alergias_paciente = Alergias::select(
                "alergias.medicamento as medicamento",
            )
                ->get();

            //Aquí obtengo las enfermedades persistentes de un paciente
            $enfermedades_persistentes = EnfermedadesPersistentes::select(
                "enfermedades_persistentes.enfermedad as enfermedad_persistente",
            )
                ->get();

            //Aquí obtengo las enfermedades hereditarias de un paciente
            $enfermedades_hereditarias = EnfermedadesHereditarias::select(
                "enfermedades_hereditarias.enfermedad as enfermedad_hereditaria",
            )
                ->get();

            return response()->json($enfermedades_hereditarias);
        }
    }

    public function mostrar_citas2()
    {
        $citas = Citas::select(
            "citas.medico as medico",
            "citas.paciente as paciente",
            "citas.inicio_cita as inicio_cita",
            "citas.fin_cita as fin_cita",
            "citas.init_comment as init_comment",
            "citas.estado as estado",
            "citas.observRec as observRec",
            "citas.planTratam as planTratam",
            "citas.procedimiento as procedimiento",
            "citas.instrucciones as instrucciones",
            "citas.sintomas as sintomas",
            "citas.fecha_agendada as fecha_agendada",
            "citas.fecha_atencion as fecha_atencion",
            "citas.seguimiento as seguimiento",
            "discapacidad_paciente.paciente as paciente_cedula",
            "discapacidad_paciente.discapacidad as discapacidad",
            "alergias.paciente as paciente_ced",
            "alergias.medicamento as medicamento",
            "enfermedades_persistentes.paciente as paciente_ced2",
            "enfermedades_persistentes.enfermedad as enfermedad_persistente",
            "enfermedades_hereditarias.paciente as paciente_ced3",
            "enfermedades_hereditarias.enfermedad as enfermedad_hereditaria",
            "enfermedades_citas.cita as id_cita",
            "info_medica.cita as id_cita1",
            "info_medica.seguimiento as id_seguimiento",
            "info_medica.key as key",
            "info_medica.value as value",
            "info_medica.unidad as unidad",
            "examenes.url_examen as url",
        )
            ->join("discapacidad_paciente", "discapacidad_paciente.paciente", '=', "citas.paciente")
            ->join("alergias", "alergias.paciente", '=', "citas.paciente")
            ->join("enfermedades_persistentes", "enfermedades_persistentes.paciente", '=', "citas.paciente")
            ->join("enfermedades_hereditarias", "enfermedades_hereditarias.paciente", '=', "citas.paciente")
            ->join("enfermedades_citas", "enfermedades_citas.cita", '=', "citas.id_cita")
            ->join("info_medica", "info_medica.cita", '=', "citas.id_cita")
            ->join("examenes", "examenes.cita", '=', "citas.id_cita")

            // ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
            // ->where('users.cedula', '=', $request -> get('ced'))
            ->get();
        // ->first();
        return response()->json($citas);
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

    public function getExFilter(Request $request)
    {
        $seg =  $request->get("id_seguimiento");
        $dateMin = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_min"));
        $dateMax = Carbon::createFromFormat('Y-m-d\TH:i:s+', $request->get("date_max"));


        if (empty($seg) ||  empty($dateMax) || empty($dateMin)) {
            return response()->json(['log' => 'error'], 400);
        }

        $ex = Examenes::select("*")
            ->where("examenes.seguimiento", '=', $seg)
            ->where("examenes.created_at", "<=", $dateMax)
            ->where("examenes.created_at", ">=", $dateMin);

        return response()->json($ex->get(), 200);
    }
}
