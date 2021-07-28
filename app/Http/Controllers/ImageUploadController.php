<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examenes;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

class ImageUploadController extends Controller
{
    public function uploadImages(Request $request){
        $image_url = Cloudinary::upload($request->file('image_name')->getRealPath())->getSecurePath();
        return $image_url;
    }

    public function mostrar_examenes(){
        $examenes = Examenes::all();
        return response() -> json($examenes);
    }

    public function saveImages(Request $request){
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

}
