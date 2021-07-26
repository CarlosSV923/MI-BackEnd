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

/* API discapacidades */
Route::get('/mostrar_discapacidades', 'DiscapacidadController@mostrar_discapacidades');

/* API medicamentos */
Route::get('/mostrar_medicamentos', 'MedicamentoController@mostrar_medicamentos');

/* API enfermedades */
Route::get('/mostrar_enfermedades', 'EnfermedadController@mostrar_enfermedades');

