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

Route::post('/getExFilter', 'CitasController@getExFilter');

Route::post('/getPacientesFilter', 'PersonasController@getPacientesFilter');

Route::post('/getPacientesCuidadorFilter', 'PersonasController@getPacientesCuidadorFilter');

Route::post('/getCuidadoresFilter', 'PersonasController@getCuidadoresFilter');

Route::post('/getCuidadoresPacienteFilter', 'PersonasController@getCuidadoresPacienteFilter');

Route::post('/savePacienteAsociadoCuidador', 'PersonasController@savePacienteAsociadoCuidador');

Route::post('/deletePacienteAsociadoCuidador', 'PersonasController@deletePacienteAsociadoCuidador');

Route::post('/getMedicosFilter', 'PersonasController@getMedicosFilter');

Route::post('/agendarCita', 'CitasController@agendarCita');

Route::post('/agendarCitaAsociada', 'CitasController@agendarCitaAsociada');

Route::post('/getSeguimientoData', 'SeguimientosController@getSeguimientoData');

Route::post('/finalizarSeguimiento', 'SeguimientosController@finalizarSeguimiento');

Route::post('/crear_seguimiento', 'SeguimientosController@crear_seguimiento');

Route::post('/getAllSeguimientos', 'SeguimientosController@getAllSeguimientos');

Route::post('/getCitasReporte', 'CitasController@getCitasReporte');

Route::post('/getCitasMedico', 'CitasController@getCitasMedico');

Route::post('/getCitasCuidador', 'CitasController@getCitasCuidador');

Route::post('/getCitasSeg', 'CitasController@getCitasSeg');

Route::post('/getCitasPaciente', 'CitasController@getCitasPaciente');

Route::post('/reangedarCancelarCita', 'CitasController@reangedarCancelarCita');

Route::post('/login', 'UsersController@login');


/* API exámenes */
Route::post('/upload/images', 'ImageUploadController@uploadImages');
Route::post('/saveImages', 'ImageUploadController@saveImages');

Route::post('/saveExamen', 'ImageUploadController@saveExamen');
Route::post('/editExamen', 'ImageUploadController@editExamen');
Route::post('/deleteExamen', 'ImageUploadController@deleteExamen');
Route::get('/mostrar_examenes', 'ImageUploadController@mostrar_examenes');

/* API citas */
Route::get('/mostrar_citas', 'CitasController@mostrar_citas');
Route::post('/almacenar_cita', 'CitasController@almacenar_cita');
Route::post('/actualizar_cita', 'CitasController@actualizar_cita');
Route::post('/informacion', 'CitasController@informacion');
Route::get('/info_paciente/{cedula}', 'CitasController@info_paciente');

/* API discapacidades */
Route::get('/mostrar_discapacidades', 'DiscapacidadController@mostrar_discapacidades');
Route::post('/almacenar_discapacidades', 'DiscapacidadController@almacenar_discapacidades');
Route::post('/almacenar_discapacidad', 'DiscapacidadController@almacenar_discapacidad');
Route::delete('/eliminar_discapacidad/{id_discapacidad}', 'DiscapacidadController@eliminar_discapacidad');
Route::get('/obtener_discapacidad_por_id/{id_discapacidad}', 'DiscapacidadController@obtener_discapacidad_por_id');
Route::post('/actualizar_discapacidad','DiscapacidadController@actualizar_discapacidad');
Route::post('/discapacidades','DiscapacidadController@discapacidades');

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
Route::post('/saveSignoVital', 'InfoMedicaController@saveSignoVital');
Route::post('/editSignoVital', 'InfoMedicaController@editSignoVital');
Route::post('/deleteSignoVital', 'InfoMedicaController@deleteSignoVital');
Route::post('/almacenar_signos_vitales_paciente', 'InfoMedicaController@almacenar_signos_vitales_paciente');

/* API medicamentos citas */
Route::get('/mostrar_medicamentos_citas', 'MedicamentoCitaController@mostrar_medicamentos_citas');
Route::post('almacenar_medicamentos_cita_paciente','MedicamentoCitaController@almacenar_medicamentos_cita_paciente');

/* API medicamentos */
Route::get('/mostrar_medicamentos', 'MedicamentoController@mostrar_medicamentos');
Route::post('almacenar_medicamento', 'MedicamentoController@almacenar_medicamento');
Route::delete('/eliminar_medicamento/{id_medicamento}', 'MedicamentoController@eliminar_medicamento');
Route::get('/obtener_medicamento_por_id/{id_medicamento}', 'MedicamentoController@obtener_medicamento_por_id');
Route::get('/buscar_medicamentos/{nombre}', 'MedicamentoController@buscar_medicamentos');
Route::post('/actualizar_medicamento','MedicamentoController@actualizar_medicamento');
Route::post('/medicamentos','MedicamentoController@medicamentos');

/* API enfermedades citas */
Route::get('/mostrar_enfermedades_cita', 'EnfermedadCitaController@mostrar_enfermedades_cita');
Route::post('/almacenar_enfermedades_cita_paciente', 'EnfermedadCitaController@almacenar_enfermedades_cita_paciente');

/* API enfermedades */
Route::get('/mostrar_enfermedades', 'EnfermedadController@mostrar_enfermedades');
Route::get('/mostrar_enfermedades_paginado/{size}', 'EnfermedadController@mostrar_enfermedades_paginado');
Route::post('/almacenar_enfermedad', 'EnfermedadController@almacenar_enfermedad');
Route::delete('/eliminar_enfermedad/{id_enfermedad}', 'EnfermedadController@eliminar_enfermedad');
Route::get('/obtener_enfermedad_por_id/{id_enfermedad}', 'EnfermedadController@obtener_enfermedad_por_id');
Route::post('/actualizar_enfermedad','EnfermedadController@actualizar_enfermedad');
Route::post('/enfermedades','EnfermedadController@enfermedades');

/* API roles */
Route::post('/almacenar_rol', 'RolController@almacenar_rol');
Route::get('/mostrar_roles', 'RolController@mostrar_roles');
Route::delete('/eliminar_rol/{id_rol}', 'RolController@eliminar_rol');
Route::get('/obtener_rol_por_id/{id_rol}', 'RolController@obtener_rol_por_id');
Route::post('/actualizar_rol', 'RolController@actualizar_rol');
Route::post('/roles', 'RolController@roles');


/* API usuarios */
Route::post('/almacenar_usuario', 'UsersController@almacenar_usuario');
Route::get('/mostrar_usuarios', 'UsersController@mostrar_usuarios');
Route::post('/deshabilitar_usuario', 'UsersController@deshabilitar_usuario');
Route::post('/obtener_usuario_por_cedula', 'UsersController@obtener_usuario_por_cedula');
Route::post('/actualizar_usuario_administrador', 'UsersController@actualizar_usuario_administrador');
Route::post('/obtener_perfil_por_cedula', 'UsersController@obtener_perfil_por_cedula');
Route::post('/actualizar_perfil', 'UsersController@actualizar_perfil');
Route::get('/mostrar_pacientes', 'UsersController@mostrar_pacientes');
Route::post('mostrar_informacion_expediente', 'UsersController@mostrar_informacion_expediente');
Route::post('mostrar_informacion_cita_paciente', 'UsersController@mostrar_informacion_cita_paciente');
Route::post('usuarios', 'UsersController@usuarios');
Route::post('pacientes', 'UsersController@pacientes');

/* API personas */
Route::post('/pacientes_cuidador', 'PersonasController@pacientes_cuidador');
Route::get('/all_cui', 'PersonasController@all_cuidadores');
Route::get('/pacientes_asociar', 'PersonasController@pacientes_asociar');
Route::post('/cuidadores_de_paciente', 'PersonasController@cuidadores_de_paciente');
Route::post('/asignar_seguimiento_cuidador', 'PersonasController@asignar_seguimiento_cuidador');