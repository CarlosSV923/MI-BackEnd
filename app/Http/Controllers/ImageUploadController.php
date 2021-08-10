<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Examenes;
use App\Models\Enfermedades;
use App\Models\Personas;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;
use App\Mail\NotificationMail;

class ImageUploadController extends Controller
{
    public function uploadImages(Request $request)
    {
        $image_url = Cloudinary::upload($request->file('image_name')->getRealPath())->getSecurePath();
        return $image_url;
    }

    public function mostrar_examenes()
    {
        $examenes = Examenes::all();
        return response()->json($examenes);
    }

   

    public function saveImages(Request $request)
    {
        $image = new Examenes();
        $image->url_examen = $request->get('url_examen');
        $image->seguimiento = $request->get('seguimiento');
        $image->diagnostico = $request->get('diagnostico');
        $image->tipo_examen = $request->get('tipo_examen');
        $image->medico = $request->get('medico');
        $image->paciente = $request->get('paciente');
        $image->comentarios = $request->get('comentarios');
        $image->cita = $request->get('cita');
        $image->save();
        return $image->id_examen;
    }

    public function Log($value)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($value);
    }

    public function saveExamen(Request $request)
    {

        $imgs = $request->file('images');
        $this->Log(json_encode($imgs));
        $urls = array();
        foreach ($imgs as $img) {
            $image_url = Cloudinary::upload($img->getRealPath())->getSecurePath();
            array_push($urls, $image_url);
        }
        $image = new Examenes();
        $image->url_examen = implode(",", $urls);
        $image->seguimiento = $request->get('seguimiento');
        $image->diagnostico = $request->get('diagnostico');
        $image->tipo_examen = $request->get('tipo_examen');
        $image->medico = $request->get('medico');
        $image->paciente = $request->get('paciente');
        $image->comentarios = $request->get('comentarios');
        $image->save();
        
        try {
            $paciente = Personas::select("*")->where("cedula", "=",  $request->get("paciente"))->first();
            $medico = Personas::select("*")->where("cedula", "=",  $request->get("medico"))->first();

            $nombPac = $paciente["nombre"] . " " . $paciente["apellido"];
            $accion = "Publico un nuevo examen en relacion a su seguimiento actual.";
            $value = "Ingrese a la plataforma para revisar mas detalles.";

            Mail::to($medico["correo"])->send(new NotificationMail($nombPac, $accion, $value));
        } catch (\Exception $e) {
            $this->Log("[saveExamen]: Fallo envio de correo.");
        }


        return response()->json($image, 200);
    }

    public function editExamen(Request $request)
    {
        $exam = Examenes::select("*")->where("examenes.id_examen", "=", $request->get("id_examen"));
        $regEx = $exam->first();
        $url = $regEx["url_examen"];

        $imgs = $request->file('images');
        $this->Log(json_encode($imgs));
        $urls = array();
        foreach ($imgs as $img) {
            $image_url = Cloudinary::upload($img->getRealPath())->getSecurePath();
            array_push($urls, $image_url);
        }

        $exam->update([
            'tipo_examen' => $request->get("tipo_examen"),
            "diagnostico" =>  $request->get("diagnostico"),
            'comentarios' => $request->get("comentarios"),
            "url_examen" => $url . "," . implode(",", $urls),
        ]);

        return response()->json($exam, 200);
    }

    public function deleteExamen(Request $request)
    {
        $exam = Examenes::select("*")->where("examenes.id_examen", "=", $request->get("id_examen"));

        $exam->delete();
        return response()->json(["log" => "exito"], 200);
    }
}
