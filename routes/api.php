<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/getPacientesFilter', 'PersonasController@getPacientesFilter');

Route::post('/getMedicosFilter', 'PersonasController@getMedicosFilter');

Route::post('/agendarCita', 'CitasController@agendarCita');

Route::post('/getCitasMedico', 'CitasController@getCitasMedico');

Route::post('/getCitasPaciente', 'CitasController@getCitasPaciente');

Route::post('/reangedarCancelarCita', 'CitasController@reangedarCancelarCita');

Route::post('/login', 'UsersController@login');


/* API exámenes */
Route::post('/upload/images', 'ImageUploadController@uploadImages');
Route::post('/saveImages', 'ImageUploadController@saveImages');
Route::get('/mostrar_examenes', 'ImageUploadController@mostrar_examenes');

/* API citas */
Route::get('/mostrar_citas', 'CitasController@mostrar_citas');
Route::post('/almacenar_cita', 'CitasController@almacenar_cita');

/* API discapacidades */
Route::get('/mostrar_discapacidades', 'DiscapacidadController@mostrar_discapacidades');
Route::post('/almacenar_discapacidades', 'DiscapacidadController@almacenar_discapacidades');

/* API discapacidades pacientes */
Route::get('/mostrar_discapacidades_pacientes', 'DiscapacidadPacienteController@mostrar_discapacidades_pacientes');
Route::post('/almacenar_discapacidades_pacientes', 'DiscapacidadPacienteController@almacenar_discapacidades_paciente');

/* API alergias pacientes */
Route::get('/mostrar_alergias_pacientes', 'AlergiaController@mostrar_alergias_pacientes');
Route::post('/almacenar_alergias_paciente', 'AlergiaController@almacenar_alergias_paciente');
Route::post('/almacenar_alergias', 'AlergiaController@almacenar_alergias');

/* API enfermedades hereditarias */
Route::get('/mostrar_enfermedades_hereditarias', 'EnfermedadHereditariaController@mostrar_enfermedades_hereditarias');
Route::post('/almacenar_enfermedades_hereditarias_paciente', 'EnfermedadHereditariaController@almacenar_enfermedades_hereditarias_paciente');

/* API enfermedades persistentes */
Route::get('mostrar_enfermedades_persistentes', 'EnfermedadPersistenteController@mostrar_enfermedades_persistentes');
Route::post('/almacenar_enfermedades_persistentes_paciente', 'EnfermedadPersistenteController@almacenar_enfermedades_persistentes_paciente');

/* API infoMedica signos vitales */
Route::get('/mostrar_signos_vitales', 'InfoMedicaController@mostrar_signos_vitales');
Route::post('/almacenar_signos_vitales_paciente', 'InfoMedicaController@almacenar_signos_vitales_paciente');

/* API medicamentos citas */
Route::get('/mostrar_medicamentos_citas', 'MedicamentoCitaController@mostrar_medicamentos_citas');
Route::post('almacenar_medicamentos_cita_paciente','MedicamentoCitaController@almacenar_medicamentos_cita_paciente');

/* API medicamentos */
Route::get('/mostrar_medicamentos', 'MedicamentoController@mostrar_medicamentos');

/* API enfermedades citas */
Route::get('/mostrar_enfermedades_cita', 'EnfermedadCitaController@mostrar_enfermedades_cita');
Route::post('/almacenar_enfermedades_cita_paciente', 'EnfermedadCitaController@almacenar_enfermedades_cita_paciente');

/* API enfermedades */
Route::get('/mostrar_enfermedades', 'EnfermedadController@mostrar_enfermedades');