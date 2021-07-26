<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id_persona';

                /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', "apellido", "cedula", "genero", "fecha_nacimiento", "correo"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function alergias()
    {
        return $this->hasMany('App\Models\Alergias', 'paciente');
    }

    public function discapacidad_paciente()
    {
        return $this->hasMany('App\Models\DiscapacidadPaciente', 'paciente');
    }

    public function users()
    {
        return $this->hasMany('App\Models\Users', 'cedula');
    }

    public function medico_especialidad()
    {
        return $this->hasMany('App\Models\MedicoEspecialidad', 'medico');
    }

    public function hararios_atencion()
    {
        return $this->hasMany('App\Models\HorariosAtencion', 'medico');
    }

    public function enfermedades_hereditarias()
    {
        return $this->hasMany('App\Models\EnfermedadesHereditarias', 'paciente');
    }

    public function enfermedades_persistentes()
    {
        return $this->hasMany('App\Models\EnfermedadesPersistentes', 'paciente');
    }

    public function paciente_cuidador_p()
    {
        return $this->hasMany('App\Models\PacienteCuidador', 'paciente');
    }

    public function paciente_cuidador_c()
    {
        return $this->hasMany('App\Models\PacienteCuidador', 'cuidador');
    }

    public function examenes_p()
    {
        return $this->hasMany('App\Models\Examenes', 'paciente');
    }

    public function examenes_m()
    {
        return $this->hasMany('App\Models\Examenes', 'medico');
    }

    public function cuidador_seguimiento()
    {
        return $this->hasMany('App\Models\CuidadorSeguimiento', 'cuidador');
    }

    public function medico_seguimiento()
    {
        return $this->hasMany('App\Models\Seguimientos', 'medico');
    }

    public function paciente_seguimiento()
    {
        return $this->hasMany('App\Models\Seguimientos', 'paciente');
    }

    public function paciente_citas()
    {
        return $this->hasMany('App\Models\Citas', 'paciente');
    }

    public function medico_citas()
    {
        return $this->hasMany('App\Models\Citas', 'medico');
    }

    public function cuidador_citas()
    {
        return $this->hasMany('App\Models\CuidadorCitas', 'cuidador');
    }


}

