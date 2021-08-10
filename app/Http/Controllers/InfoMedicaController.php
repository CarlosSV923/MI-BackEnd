<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\InfoMedica;
use App\Models\Personas;
use App\Mail\NotificationMail;

class InfoMedicaController extends Controller
{
    public function mostrar_signos_vitales()
    {
        $signos_vitales = new InfoMedica();
        return response()->json($signos_vitales);
    }

    public function almacenar_signos_vitales_paciente(Request $request)
    {
        $lista_signos_vitales_paciente = $request->get('signos_vitales_paciente');
        for ($i = 0; $i < count($lista_signos_vitales_paciente); $i++) {
            $signo_vital = new InfoMedica();
            $data = $lista_signos_vitales_paciente[$i];
            $signo_vital->cita = $request->get('cita');
            $signo_vital->seguimiento = $request->get('seguimiento');
            $signo_vital->key = $data['key'];
            $signo_vital->value = $data['value'];
            $signo_vital->unidad = $data['unidad'];
            //$signo_vital->descrip = $request -> get('descrip');
            $signo_vital->save();
        }
    }

    public function Log($value)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($value);
    }


    public function saveSignoVital(Request $request)
    {
        $signo_vital = new InfoMedica();
        $signo_vital->seguimiento = $request->get('seguimiento');
        $signo_vital->key = $request->get('key');
        $signo_vital->value = $request->get('value');
        $signo_vital->unidad = $request->get('unidad');
        $signo_vital->descrip = $request->get('descrip');
        $signo_vital->save();
        if ($request->get("isPaciente")) {
            try {
                $paciente = Personas::select("*")->where("cedula", "=",  $request->get("paciente"))->first();
                $medico = Personas::select("*")->where("cedula", "=",  $request->get("medico"))->first();

                $nombPac = $paciente["nombre"] . " " . $paciente["apellido"];
                $accion = "Publico un nuevo Signo Vial en relacion a su seguimiento actual.";
                $value = "Ingrese a la plataforma para revisar mas detalles.";

                Mail::to($medico["correo"])->send(new NotificationMail($nombPac, $accion, $value));
            } catch (\Exception $e) {
                $this->Log("[saveSignoVital]: Fallo envio de correo.");
                $this->Log(json_encode($e));
            }
        }

        return response()->json($signo_vital, 200);
    }

    public function editSignoVital(Request $request)
    {
        $signo_vital = InfoMedica::where("id_info_medica", "=", $request->get("id_info_medica"));
        $signo_vital->update([
            'key' => $request->get('key'),
            "value" =>  $request->get('value'),
            'unidad' => $request->get('unidad'),
            "descrip" => $request->get("descrip"),
        ]);
        return response()->json($signo_vital, 200);
    }

    public function  deleteSignoVital(Request $request)
    {
        $sig = InfoMedica::find($request->get("id_info_medica"));
        $sig->delete();
        return response()->json(["log" => "exito"], 200);
    }
}
