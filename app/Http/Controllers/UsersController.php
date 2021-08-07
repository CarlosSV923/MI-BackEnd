<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Personas;
use Illuminate\Support\Facades\Hash;
use App\Models\DiscapacidadPaciente;
use App\Models\Discapacidades;
use App\Models\Alergias;
use App\Models\EnfermedadesPersistentes;
use App\Models\EnfermedadesHereditarias;
use App\Models\InfoMedica;
use App\Models\Citas;
use App\Models\Examenes;
use App\Models\EnfermedadesCitas;
use App\Models\MedicamentosCitas;
use App\Models\Medicamentos;

class UsersController extends Controller
{
    //

    public function login(Request $request){
        $username = $request->get("username");
        $password = $request->get("password");

        if (empty($username) ||  empty($password)) {
            return response()->json(['log' => 'error parametros faltantes'], 400);
        }

        $user = Users::select(
            "users.username as username",
            "personas.cedula as cedula",
            "personas.nombre as nombre",
            "personas.apellido as apellido",
            "roles.nombre as rol",
            "users.estado as estado"
        )
        ->join("personas", "personas.cedula", '=', "users.cedula")
        ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
        ->where('users.username','=',$username)
        ->first();

        if($user->estado == 'I'){
            return response()->json(['log'=>'El usuario ingresado está inactivo y no puede acceder al sistema.','user'=>$user], 401);
        }
        return response()->json($user, 200);
    }

    public function almacenar_usuario(Request $request){
        $persona = new Personas();
        $persona -> cedula = $request -> get('cedula');
        $persona -> nombre = $request -> get('nombre');
        $persona -> correo = $request -> get('correo');
        $persona -> apellido = $request -> get('apellido');
        $persona -> fecha_nacimiento = $request -> get('fecha_nacimiento');
        $persona -> sexo = $request -> get('sexo');
        $persona->save();
        $user = new Users();
        $user -> username = $request -> get('username');
        // $user -> password = $request ->  get('password');
        $user -> password = Hash::make($request->get('password'));
        $user -> cedula = $request -> get('cedula');
        $user -> id_rol = $request -> get('id_rol');
        $user -> estado = 'A';
        $user->save();
        return response()->json($request -> get('cedula'), 200);
    }

    public function mostrar_usuarios (){
        $usuarios = Users::select(
            "users.username as usuario",
            "personas.cedula as cedula",
            "personas.nombre as nombre",
            "personas.apellido as apellido",
            "personas.correo as correo",
            "personas.sexo as sexo",
            "personas.fecha_nacimiento as fecha_nacimiento",
            "roles.nombre as rol",
            "roles.id_rol as id_rol",
            "users.estado as estado",
            // "users.password as password"
        )
        ->join("personas", "personas.cedula", '=', "users.cedula")
        ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
        ->get();
        return response() -> json($usuarios);
    }

    public function deshabilitar_usuario(Request $request){
        $usuario = Users::where("cedula", "=", $request->get("cedula"));
        $usuario->update([
            "estado" => 'I',           
        ]);
        $usuarios = $this->mostrar_usuarios();
        return response() -> json($usuarios);
    }

    public function obtener_usuario_por_cedula(Request $request){
        $usuarios = Users::select(
            "users.username as usuario",
            "personas.cedula as cedula",
            "personas.nombre as nombre",
            "personas.apellido as apellido",
            "personas.correo as correo",
            "personas.sexo as sexo",
            "personas.fecha_nacimiento as fecha_nacimiento",
            "roles.nombre as rol",
            "roles.id_rol as id_rol",
            "users.estado as estado",
            "users.password as password"
        )
        ->join("personas", "personas.cedula", '=', "users.cedula")
        ->join('roles', 'roles.id_rol', '=', 'users.id_rol')
        ->where('users.cedula', '=', $request -> get('ced'))
        // ->get();
        ->first();
        return response() -> json($usuarios);
    }

    function actualizar_usuario_administrador(Request $request){
        $usuario = Users::where("cedula", "=", $request->get("cedula"));
        $usuario->update([
            "id_rol" => $request->get("id_rol"),
            "estado" => $request->get("estado"),            
        ]);

        $persona = Personas::where("cedula", "=", $request->get("cedula"));
        $persona ->update([
            "nombre" => $request -> get('nombre'),
            "apellido" => $request -> get('apellido'),
            "fecha_nacimiento" => $request -> get('fecha_nacimiento'),
            "sexo" => $request -> get('sexo'),
        ]);

        return response() -> json($persona);
    }

    public function obtener_perfil_por_cedula(Request $request){
        $usuarios = Users::select(
            "users.username as usuario",
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
        ->where('users.cedula', '=', $request -> get('ced'))
        // ->get();
        ->first();
        return response() -> json($usuarios);
    }        
    
    // Hash::check('plain-text', $hashedPassword)
    
    function actualizar_perfil(Request $request){
        $usuario = Users::where("cedula", "=", $request->get("cedula"));
        $password_actual = ($usuario -> get('password') -> first())["password"];

        if ($request->get('cambiar')){
            if(Hash::check($request->get('password_actual'), $password_actual)){
                $usuario->update([
                    "password" => Hash::make($request->get('password_nuevo')),
                ]);
                $persona = Personas::where("cedula", "=", $request->get("cedula"));
                $persona ->update([
                    "nombre" => $request -> get('nombre'),
                    "apellido" => $request -> get('apellido'),
                    "fecha_nacimiento" => $request -> get('fecha_nacimiento'),
                    "sexo" => $request -> get('sexo'),
                ]);
                return response() -> json($persona);
            }
        }else{
            $persona = Personas::where("cedula", "=", $request->get("cedula"));
            $persona ->update([
                "nombre" => $request -> get('nombre'),
                "apellido" => $request -> get('apellido'),
                "fecha_nacimiento" => $request -> get('fecha_nacimiento'),
                "sexo" => $request -> get('sexo'),
            ]);
            return response() -> json($persona);
        }


        // return response() -> json($password_actual);
        // return response() -> json($request -> get ('password_nuevo'));
        // if ($request->get("cedula"))

        // $usuario->update([
        //     "password" => $request->get("id_rol"),
        //     "estado" => $request->get("estado"),            
        // ]);

        // $persona = Personas::where("cedula", "=", $request->get("cedula"));
        // $persona ->update([
        //     "nombre" => $request -> get('nombre'),
        //     "apellido" => $request -> get('apellido'),
        //     "fecha_nacimiento" => $request -> get('fecha_nacimiento'),
        //     "sexo" => $request -> get('sexo'),
        // ]);

        // return response() -> json($persona);
    }

    public function mostrar_pacientes (){
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
        ->where('roles.id_rol', '=', 2)

        ->get();
        return response() -> json($pacientes);
    }

    public function mostrar_informacion_expediente (Request $request){

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
        ->where('personas.cedula', '=', $request -> get("cedula"))
        ->get();

        $discapacidades = DiscapacidadPaciente::select(
            "discapacidad_paciente.discapacidad as discapacidad",
            "discapacidad_paciente.paciente as paciente",
            "discapacidades.nombre as nombre_discapacidad"
        )
        ->join("discapacidades", "discapacidades.id_discapacidad", '=', "discapacidad_paciente.discapacidad")
        ->where('discapacidad_paciente.paciente', '=', $request -> get("cedula"))
        ->get();
                
        $alergias = Alergias::select(
            "alergias.medicamento as medicamento_alergia",
            "alergias.paciente as paciente",
            "medicamentos.nombre as nombre_alergia"
        )
        ->join("medicamentos", "medicamentos.id_medicamento", '=', "alergias.medicamento")
        ->where('alergias.paciente', '=', $request -> get("cedula"))
        ->get();
                    
        $enfermedades_persistentes = EnfermedadesPersistentes::select(
            "enfermedades_persistentes.enfermedad as id_enfermedad",
            "enfermedades_persistentes.paciente as paciente",
            "enfermedades.nombreLargo as nombre_enfermedad"
        )
        ->join("enfermedades", "enfermedades.id_enfermedad", '=', "enfermedades_persistentes.enfermedad")
        ->where('enfermedades_persistentes.paciente', '=', $request -> get("cedula"))
        ->get();
                        
        $enfermedades_hereditarias = EnfermedadesHereditarias::select(
            "enfermedades_hereditarias.enfermedad as id_enfermedad",
            "enfermedades_hereditarias.paciente as paciente",
            "enfermedades.nombreLargo as nombre_enfermedad"
        )
        ->join("enfermedades", "enfermedades.id_enfermedad", '=', "enfermedades_hereditarias.enfermedad")
        ->where('enfermedades_hereditarias.paciente', '=', $request -> get("cedula"))
        ->get();
        
        $ids = InfoMedica::select(
            "info_medica.cita as id_max"
        )
        ->join("citas", "citas.id_cita", '=', "info_medica.cita")
        ->where('citas.paciente', '=', $request -> get("cedula"))
        // ->lastest();
        ->get();


        // return response() -> json(count($ids));

        $signos_vitales = "";

        if(count($ids)){
            $lista = $ids;
            $id_maxi = $ids[count($lista) - 1]["id_max"];
            
            $signos_vitales = InfoMedica::select(
                "info_medica.key as key",
                "info_medica.value as value",
                "info_medica.unidad as unidad"
            )
            ->where('info_medica.cita', '=', $id_maxi)
            ->get();
        }else{
            $signos_vitales = [];
        }


        $citas = Citas::select(
            "citas.id_cita as id_cita",
            "citas.medico as medico",
            "citas.paciente as paciente",
            "citas.fecha_atencion as fecha_atencion",
            "personas.nombre as nombre",
            "personas.apellido as apellido"
        )
        ->join("personas", "personas.cedula", '=', "citas.medico")
        ->where('citas.paciente', '=', $request -> get('cedula') )
        ->where('citas.estado', '=', 'A' )
        ->get();
                                    
        return response() -> json([$pacientes, $alergias, $discapacidades, $enfermedades_hereditarias, $enfermedades_persistentes, $signos_vitales, $citas]);

    }

    public function mostrar_informacion_cita_paciente (Request $request){

        // Información paciente
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
        ->where('personas.cedula', '=', $request -> get("cedula"))
        ->get();

        //Información discapacidades
        $discapacidades = DiscapacidadPaciente::select(
            "discapacidad_paciente.discapacidad as discapacidad",
            "discapacidad_paciente.paciente as paciente",
            "discapacidades.nombre as nombre_discapacidad"
        )
        ->join("discapacidades", "discapacidades.id_discapacidad", '=', "discapacidad_paciente.discapacidad")
        ->where('discapacidad_paciente.paciente', '=', $request -> get("cedula"))
        ->get();

        //Información alergias
        $alergias = Alergias::select(
            "alergias.medicamento as medicamento_alergia",
            "alergias.paciente as paciente",
            "medicamentos.nombre as nombre_alergia"
        )
        ->join("medicamentos", "medicamentos.id_medicamento", '=', "alergias.medicamento")
        ->where('alergias.paciente', '=', $request -> get("cedula"))
        ->get();

        // Información de enfermedades persistentes
        $enfermedades_persistentes = EnfermedadesPersistentes::select(
            "enfermedades_persistentes.enfermedad as id_enfermedad",
            "enfermedades_persistentes.paciente as paciente",
            "enfermedades.nombreLargo as nombre_enfermedad"
        )
        ->join("enfermedades", "enfermedades.id_enfermedad", '=', "enfermedades_persistentes.enfermedad")
        ->where('enfermedades_persistentes.paciente', '=', $request -> get("cedula"))
        ->get();

        // Información de enfermedades hereditarias
        $enfermedades_hereditarias = EnfermedadesHereditarias::select(
            "enfermedades_hereditarias.enfermedad as id_enfermedad",
            "enfermedades_hereditarias.paciente as paciente",
            "enfermedades.nombreLargo as nombre_enfermedad"
        )
        ->join("enfermedades", "enfermedades.id_enfermedad", '=', "enfermedades_hereditarias.enfermedad")
        ->where('enfermedades_hereditarias.paciente', '=', $request -> get("cedula"))
        ->get();

        // Información de signos vitales
        $ids = InfoMedica::select(
            "info_medica.cita as id_max"
        )
        ->join("citas", "citas.id_cita", '=', "info_medica.cita")
        ->where('citas.paciente', '=', $request -> get("cedula"))
        ->get();
        
        //Información de signos vitales
        $signos_vitales = InfoMedica::select(
            "info_medica.key as key",
            "info_medica.value as value",
            "info_medica.unidad as unidad"
        )
        ->where('info_medica.cita', '=', $request -> get("cita"))
        ->get();

        //Información cita
        $citas = Citas::select(
            "citas.id_cita as id_cita",
            "citas.medico as medico",
            "citas.paciente as paciente",
            "citas.fecha_atencion as fecha_atencion",
            "personas.nombre as nombre",
            "personas.apellido as apellido",
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
            "citas.seguimiento as seguimiento",
        )
        ->join("personas", "personas.cedula", '=', "citas.medico")
        ->where('citas.id_cita', '=', $request -> get('cita') )
        ->get();

        //Información exámenes
        $examenes = Examenes::select(
            "examenes.url_examen as url_examen"
        )
        ->where('examenes.cita', '=', $request -> get('cita') )
        ->get();
        
        // Información enfermedades
        $enfermedades_cita = EnfermedadesCitas::select(
            "enfermedades_citas.enfermedad as id_enfermedad",
            "enfermedades.nombreLargo as nombre_enfermedad"
        )
        ->join("enfermedades", "enfermedades.id_enfermedad", '=', "enfermedades_citas.enfermedad")
        ->where('enfermedades_citas.cita', '=', $request -> get("cita"))
        ->get();

        // Información enfermedades
        $medicamentos = MedicamentosCitas::select(
            "medicamentos_citas.medicamento as medicamento",
            "medicamentos_citas.frecuencia as frecuencia",
            "medicamentos_citas.dosis as dosis",
            "medicamentos_citas.duracion as duracion",
            "medicamentos.nombre as nombre_medicamento"
        )
        ->join("medicamentos", "medicamentos.id_medicamento", '=', "medicamentos_citas.medicamento")
        ->where('medicamentos_citas.cita', '=', $request -> get("cita"))
        ->get();

        // return response() -> json($medicamentos);

        return response() -> json([$pacientes, $alergias, $discapacidades, $enfermedades_hereditarias, $enfermedades_persistentes, $signos_vitales, $citas, $examenes, $enfermedades_cita, $medicamentos]);

    }

}
