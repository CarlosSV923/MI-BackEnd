<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguimientos extends Model
{
    protected $table = 'seguimientos';
    protected $primaryKey = 'id_seguimiento';

                    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_inicio', "fecha_fin", "estado", "paciente", "medico"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function pacientes()
    {
        return $this->belongsTo('App\Models\Personas', 'paciente');
    }

    public function medicos()
    {
        return $this->belongsTo('App\Models\Personas', 'medico');
    }

    public function enfermedades_seguimientos()
    {
        return $this->hasMany('App\Models\EnfermedadesSeguimientos', 'seguimiento');
    }

    public function examenes()
    {
        return $this->hasMany('App\Models\Examenes', 'seguimiento');
    }

    public function info_medica()
    {
        return $this->hasMany('App\Models\InfoMedica', 'seguimiento');
    }

    public function cuidador_seguimiento()
    {
        return $this->hasMany('App\Models\CuidadorSeguimiento', 'seguimiento');
    }
}
